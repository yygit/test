<?php

class IssueController extends Controller{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';

    /**
     * @var Project property containing the associated Project model instance.
     */
    public $_project = null;

    /**
     * @var User property containing the associated User model instance.
     */
    public $_userId = null;

    /**
     * @return array action filters
     */
    public function filters() {
        return CMap::mergeArray(array(
                'accessControl', // perform access control for CRUD operations
                'projectContext + create', // check to ensure valid project context
                'userContext + create,update', // check to ensure valid user context
            ),
            parent::filters());
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        $id = Yii::app()->request->getQuery('id');
        $ownerId = $id ? $this->loadModel($id)->owner_id : null;

        return array(
            array('allow', // allow
                'actions' => array('create', 'delete', 'index', 'admin', 'ajaxcomment'),
                'users' => array('@'),
            ),
            array('allow', // allow
                'actions' => array('update', 'view'),
                'users' => array('@'),
//                'expression' => "Yii::app()->user->id==$ownerId OR Yii::app()->user->name==Yii::app()->params['God']",
            ),
            /*array('allow', // allow admin only
                'actions' => array('index', 'admin'),
                'users' => array(Yii::app()->params['God']),
            ),*/
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $issue = $this->loadModel($id, 'with comments and author');
        if (!Yii::app()->user->checkAccess('readIssue', array('project' => $issue->project))) {
            throw new CHttpException(403, 'You are not authorized to perform this action.');
        }

        $commentDataProvider = new CActiveDataProvider('Comment', array(
            'criteria' => array(
                'condition' => 't.issue_id=:issueId',
                'params' => array(':issueId' => $issue->id),
            ),
            'sort' => array(
                'defaultOrder' => 't.create_time DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));

        if (!Yii::app()->request->isAjaxRequest)
            $comment = $this->createComment($issue);
        elseif (isset($_POST['Comment']))  // if posted with ajax
            $comment = $this->createCommentAjax($issue, $commentDataProvider);
        else
            $comment = new Comment;

        $this->render('view', array(
            'model' => $issue,
            'comment' => $comment,
            'commentDataProvider' => $commentDataProvider,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        if (!Yii::app()->user->checkAccess('createIssue', array('project' => $this->_project))) {
            throw new CHttpException(403, 'You are not authorized to perform this action.');
        }
        $model = new Issue;
        $model->project_id = $this->_project->id;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Issue'])) {
            $model->attributes = $_POST['Issue'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        if (!Yii::app()->user->checkAccess('updateIssue', array('project' => $model->project))) {
            /*// causes infinite loops if 'HttpsFilter' is on, may help redirecting to another action throwing error in http
            throw new CHttpException(403, 'You are not authorized to perform this action.');*/
            exit('You are not authorized to perform this action.');
        }

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Issue'])) {
            $model->attributes = $_POST['Issue'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        if (!Yii::app()->user->checkAccess('deleteIssue', array('project' => $model->project))) {
            throw new CHttpException(403, 'You are not authorized to perform this action.');
        }
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        if (!Yii::app()->authManager->checkAccessNoBizrule('readIssue')) {
            throw new CHttpException(403, 'You are not authorized to perform this action.');
        }
        $dataProvider = new CActiveDataProvider('Issue');
        $dataProvider->criteria = array(
//            'scopes' => array('owners'),
            'scopes' => array('assignedUsers'),
        );
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        if (!Yii::app()->authManager->checkAccessNoBizrule('readIssue')) {
            throw new CHttpException(403, 'You are not authorized to perform this action.');
        }
        $model = new Issue('search');
//        $model->owners();
        $model->assignedUsers();
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Issue']))
            $model->attributes = $_GET['Issue'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * Cannot specify limit doing 'eager' loading using 'with'. see yiiframework.com/forum/index.php/topic/35586-specifying-limit-in-each-has-many-relations/
     * Use 'lazy' loading instead - yiiframework.com/forum/index.php/topic/25083-limit-on-relations-in-certain-situations/
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Issue the loaded model
     * @throws CHttpException
     */
    public function loadModel($id, $withComments = false) {
        if ($withComments)
            $model = Issue::model()->with(array('comments' => array('with' => 'author')))->findByPk($id);
        else
            $model = Issue::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /*public function loadModel_bak($id) {
        $model = Issue::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }*/

    /**
     * Performs the AJAX validation.
     * @param Issue $model the model to be validated
     */
    protected function performAjaxValidation($model, $id = 'issue-form') {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $id) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Protected method to load the associated Project model class
     * @param integer projectId the primary identifier of the associated Project
     * @return object the Project data model based on the primary key
     */
    protected function loadProject($projectId) {
        //if the project property is null, create it based on input id
        if ($this->_project === null) {
            $this->_project = Project::model()->findByPk($projectId);
            if ($this->_project === null)
                throw new CHttpException(404, 'The requested project does not exist.');
        }
        return $this->_project;
    }

    /**
     * In-class defined filter method, configured for use in the above filters() method
     * It is called before the actionCreate() action method is run in order to ensure a proper project context
     */
    public function filterProjectContext($filterChain) {
        //set the project identifier based on GET input request variables
        $pid = Yii::app()->request->getQuery('pid');
        if (isset($pid))
            $this->loadProject($pid);
        else
            throw new CHttpException(403, 'Must specify a project before performing this action.');

        //complete the running of other filters and execute the requested action
        $filterChain->run();
    }

    /**
     * Protected method to load the associated User model class to assign Project's Owning User
     * @return object the User data model based on the primary key
     */
    protected function loadUser() {
        //if the user property is null, create it based on input id
        if ($this->_userId === null) {
            $this->_userId = Yii::app()->user->id;
            if ($this->_userId === null)
                throw new CHttpException(404, 'The associated user does not exist or not logged.');
        }
        return $this->_userId;
    }

    /**
     * In-class defined filter method, configured for use in the above filters() method
     * It is called before the actionCreate() action method is run in order to ensure a proper user context
     */
    public function filterUserContext($filterChain) {
        $this->loadUser();

        //complete the running of other filters and execute the requested action
        $filterChain->run();
    }

    /**
     * Creates a new comment on an issue
     * @param Issue $issue
     * @return Comment
     */
    protected function createComment(Issue $issue) {
        $comment = new Comment;
        if (isset($_POST['Comment'])) {
            $comment->attributes = $_POST['Comment'];
            if ($issue->addComment($comment)) {
                Yii::app()->user->setFlash('commentSubmitted', "Your comment has been added.");
                $this->refresh();
            }
        }
        return $comment;
    }

    /**
     * Creates a new comment on an issue thru ajax
     * @param Issue $issue
     * @param CActiveDataProvider $commentDataProvider
     */
    protected function createCommentAjax(Issue $issue, CActiveDataProvider $commentDataProvider) {
        $comment = new Comment;
        $comment->attributes = $_POST['Comment'];
        if ($issue->addComment($comment)) {
            Yii::app()->user->setFlash('commentSubmitted', "Your comment has been added via Ajax.");
        } else {
            echo CActiveForm::validate($comment);
        }
        $this->renderPartial('__comments', array(
            'model' => $issue,
            'comment' => $comment,
            'commentDataProvider' => $commentDataProvider,
        ));
        Yii::app()->end();
    }

}

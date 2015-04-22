<?php

class ProjectController extends Controller{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $defaultAction = 'index';

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
                'postOnly + delete', // we only allow deletion via POST request
                'userContext + create,update', //check to ensure valid user context
                array( //example of entire PAGE CACHING - turned off as this does not allow us to use the pagination for issues
                    'COutputCache + view', // cache the entire output from the actionView() method for 2 minutes
                    'duration' => 120,
                    'varyByParam' => array('id', 'Issue_page', 'Issue_sort'), // YY; 20131217 this helps correct caching when sorting
                    'varyByExpression' => 'ProjectUserAssignment::model()->countByAttributes(array("project_id" => (int)$_GET["id"])) + Issue::model()->assignedUsers()->countByAttributes(array("project_id" => (int)$_GET["id"]))', // YY; 20131217 adding issue count helps pagination 20150422 add assigned users count
                    'varyBySession' => true,
                ),
            ),
            parent::filters());
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        /*$id = Yii::app()->request->getQuery('id');
        $model = $id ? $this->loadModel($id) : null;
        $allow = in_array(Yii::app()->user->id, array_values(Project::listRelatedAttr($model, 'users', 'id'))) ? 'true' : 'false';*/

        return array(
            array('allow', // allow
                'actions' => array('index', 'admin', 'delete', 'create', 'adduser', 'deleteuser'),
                'users' => array('@'),
            ),
            array('allow', // allow
                'actions' => array('update', 'view', 'flag'),
                'users' => array('@'),
                /*'expression' => "$allow OR Yii::app()->user->name==Yii::app()->params['God']",*/
            ),
            /*array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('create'), // only 'God' users may currently create projects
                'users' => array(Yii::app()->params['God']),
            ),*/
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular project model.
     * @param integer $id the ID of the model to be displayed
     * @throws CHttpException
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        if (!Yii::app()->user->checkAccess('readProject', array('project' => $model))) {
            throw new CHttpException(403, 'You are not authorized to perform this action!');
        }
        Yii::app()->clientScript->registerLinkTag('alternate', 'application/rss+xml', $this->createUrl('comment/feed', array('pid' => $model->id)));
        Yii::app()->clientScript->registerLinkTag('alternate', 'application/rss+xml', $this->createUrl('comment/feed'));
        $issueDataProvider = new CActiveDataProvider('Issue', array(
            'criteria' => array(
                'condition' => 't.project_id=:projectId',
                'params' => array(':projectId' => $model->id),
                'scopes' => array('assignedUsers'),
            ),
            'sort' => array(
                'defaultOrder' => 't.update_time DESC',
            ),
            'pagination' => array(
                'pageSize' => 5,
            ),
        ));

        $this->render('view', array(
            'model' => $model,
            'issueDataProvider' => $issueDataProvider,
        ));

    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        if (!Yii::app()->authManager->checkAccessNoBizrule('createProject')) {
            exit('You are not authorized to perform this action.');
        }
        $model = new Project;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Project'])) {
            $model->attributes = $_POST['Project'];
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
        if (!Yii::app()->user->checkAccess('updateProject', array('project' => $model))) {
            /*// causes infinite loops if 'HttpsFilter' is on, may help redirecting to another action throwing error in http
            throw new CHttpException(403, 'You are not authorized to perform this action.');*/
            exit('You are not authorized to perform this action.');
        }

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Project'])) {
            $model->attributes = $_POST['Project'];
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
     * @throws CHttpException
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        if (!Yii::app()->user->checkAccess('deleteProject', array('project' => $model))) {
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
        if (!Yii::app()->authManager->checkAccessNoBizrule('readProject')) {
            throw new CHttpException(403, 'You are not authorized to perform this action.');
        }
        Yii::app()->clientScript->registerLinkTag('alternate', 'application/rss+xml', $this->createUrl('comment/feed'));
        $dataProvider = new CActiveDataProvider('Project');
        $dataProvider->criteria = array(
            'scopes' => array('assignedUsers'),
        );

        //get the latest system message to display based on the update_time column
        // $sysMessage = SysMessage::model()->find(array('order'=>'t.update_time DESC',));
        $sysMessage = SysMessage::getLatest(); // use QUERY CACHING
        if (!empty($sysMessage))
            $message = $sysMessage->message;
        else
            $message = null;

        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'sysMessage' => $message,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        if (!Yii::app()->authManager->checkAccessNoBizrule('readProject')) {
            throw new CHttpException(403, 'You are not authorized to perform this action.');
        }
        $model = new Project('search');
        $model->assignedUsers(); // list only projects having currently auth user among the assigned users
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Project']))
            $model->attributes = $_GET['Project'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Project the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
//        $model = Project::model()->findByPk($id);
        $model = Project::model()->assignedUsers()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Project $model the model to be validated
     * * @param string $id
     */
    protected function performAjaxValidation($model, $id = 'project-form') {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $id) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Protected method to load the associated User model class to assign Project's Owning User
     * @return mixed|null|User the User data model based on the primary key
     * @throws CHttpException
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
     * Provides a form so that project administrators can
     * associate other users to the project
     * @todo Allow actionAdduser to users who can do actionCreate ?? Otherwise a user may only create a project
     * and then 'God' user will have to assess the project and possibly make 'owner' an 'assigned user'
     */
    public function actionAdduser($id) {
        $project = $this->loadModel($id);
        if (!Yii::app()->user->checkAccess('createUser', array('project' => $project))) {
            throw new CHttpException(403, 'You are not authorized to perform this action.');
        }

        $form = new ProjectUserForm('insert');
        $form->project = $project;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($form, 'adduser-form');

        // collect user input data
        if (isset($_POST['ProjectUserForm'])) {
            $form->attributes = $_POST['ProjectUserForm'];
            // validate user input
            if ($form->validate()) {
                if ($form->assign()) {
                    Yii::app()->user->setFlash('success', 'user "' . $form->username . '" has been added to the project as "' . $form->role . '"');
                    $form->clearErrors();
                    $this->redirect(array('view', 'id' => $project->id));
                }
            }
        }
        $this->render('adduser', array('model' => $form));
    }

    /**
     * remove user association from the project
     */
    public function actionDeleteuser($id) {
        $project = $this->loadModel($id);
        if (!Yii::app()->user->checkAccess('deleteUser', array('project' => $project))) {
            throw new CHttpException(403, 'You are not authorized to perform this action.');
        }

        $form = new ProjectUserForm('actionDeleteuser');
        $form->project = $project;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($form, 'deleteuser-form');

        // collect user input data
        if (isset($_POST['ProjectUserForm'])) {
            $form->attributes = $_POST['ProjectUserForm'];
            // validate user input
            if ($form->validate()) {
                if ($form->disAssign()) {
                    Yii::app()->user->setFlash('success', 'user "' . $form->username . '" has been revoked from this project');
                    $form->clearErrors();
                    $this->redirect(array('view', 'id' => $project->id));
                }
            }
        }
        $this->render('deleteuser', array('model' => $form));
    }


    /**
     * YY; 20140407 action to send ajax response to FlagColumn.php
     * @param $pk
     * @param $name
     * @param $value
     */
    public function actionFlag($pk, $name, $value) {
        $model = $this->loadModel($pk);
        $model->{$name} = $value;
        $model->save(false);

        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect('admin');
        }
    }

}

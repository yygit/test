<?php

class UserController extends Controller{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';

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
        $modelId = $id ? $this->loadModel($id)->id : null;

        return array(
            array('allow', // allow authenticated user to perform 'index', 'create' actions
                'actions' => array('index', 'admin', 'create'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'update' and 'view' action for their acc
                'actions' => array('view', 'update'),
                'users' => array('@'),
                'expression' => "Yii::app()->user->id==$modelId OR Yii::app()->user->name==Yii::app()->params['God']",
            ),
            array('allow', // allow
                'actions' => array('delete'),
                'users' => array(Yii::app()->params['God']),
            ),
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
        if (!Yii::app()->authManager->checkAccessNoBizrule('member', Yii::app()->user->id)) {
            throw new CHttpException(403, 'You are not authorized to perform this action.');
        }
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        if (!Yii::app()->authManager->checkAccessNoBizrule('owner', Yii::app()->user->id)) {
            exit('You are not authorized to perform this action.');
        }
        $model = new User;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
            'flag' => 'create',
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->oldPassword = $model->password;
        $model->password = '';

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
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
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        if (!Yii::app()->authManager->checkAccessNoBizrule('reader', Yii::app()->user->id)) {
            throw new CHttpException(403, 'You are not authorized to perform this action.');
        }
        $dataProvider = new CActiveDataProvider('User');
        $dataProvider->criteria = array('scopes' => array('myself')); // YY; 20131122; show yourself only (show all to 'God' user)
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        if (!Yii::app()->authManager->checkAccessNoBizrule('reader', Yii::app()->user->id)) {
            throw new CHttpException(403, 'You are not authorized to perform this action.');
        }
        $model = new User('search');
        $model->myself();
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
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

}

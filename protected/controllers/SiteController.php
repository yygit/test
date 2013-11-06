<?php

class SiteController extends Controller{

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            array('ext.bootstrap.filters.BootstrapFilter + page'),
        );
    }

    public function accessRules() {
        $_action = 'login2'; // allow this action to ADMIN only, allow other actions to everyone
        return array(
            array('allow',
                'actions' => array($_action),
                'users' => array('admin'),
            ),
            array('allow',
                'users' => array('*'),
                'expression' => "Yii::app()->controller->action->id!=='$_action'",
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }


    /**
     * Declares class-based actions.
     */

    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'transparent' => true,
                'maxLength' => 3,
                'minLength' => 3,
                'foreColor' => 0x666666,
                'offset' => 2,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
                'layout' => 'bootstrap',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $headers = "From: {$model->email}\r\nReply-To: {$model->email}";
                mail(Yii::app()->params['adminEmail'], $model->subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    public function actionLogin2($substUser = 'demo') {
        Yii::app()->user->logout(false);
        $goduser = new GodUserIdentity($substUser, 'anypass');
        $goduser->authenticate($substUser);
        $loginstatus = Yii::app()->user->login($goduser);
        var_dump($loginstatus);
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionAccordion() {
        $this->render('accordion', array('model' => null));
    }

    public function actionTabs() {
        $this->render('tabs', array('model' => null));
    }

    public function actionDatepicker() {
        $model = User::model()->find(); // find one
        $this->render('datepicker', array('model' => $model));
    }
}

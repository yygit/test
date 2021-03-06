<?php

class SiteController extends Controller{

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            array('ext.bootstrap.filters.BootstrapFilter + page'),
            'ajaxOnly + ajaxresponse,getPageTitles,getPageTitlesAr',
        );
    }

    public function accessRules() {
        $_action = 'login2'; // allow this action to God user only, allow other actions to everyone
        return array(
            array('allow',
                'actions' => array($_action),
                'users' => array(Yii::app()->params['God']),
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
        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'contact-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
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

    public function actionLogin2($substUser = 'NoSuchUser') {
        $goduser = new GodUserIdentity($substUser, 'anypass');
        $goduser->authenticate($substUser);
        Yii::app()->user->logout(false);
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

    public function actionJs() {
        $this->render('js');
    }

    public function actionXml() {
        $this->layout = 'xml';
        $this->render('xml');
    }

    public function actionAjaxresponse() {
        echo "<strong>$this->route:</strong> the date is " . date('r');
    }

    public function actionAjaxcall() {
        $this->render('ajaxcall');
    }

    public function actionJsonresponse() {
        $data = array(
            'title' => 'json response title',
            'content' => 'json response content at ' . date('r'),
        );
        echo CJSON::encode($data);
    }

    public function actionJsoncall() {
        $this->render('jsoncall');
    }

    public function actionAutocomplete() {
        $this->render('autocomplete');
    }

    /**
     * use query builder for faster performance
     */
    public function actionGetPageTitles() {
        $q = 'SELECT id, title AS value FROM page WHERE title LIKE ?';
        $cmd = Yii::app()->db->createCommand($q);
        $result = $cmd->query(array('%' . $_GET['term'] . '%'));
        $data = array();
        foreach ($result as $row) {
            $data[] = $row;
        }
        echo CJSON::encode($data);
        Yii::app()->end();
    }

    /**
     * a slower alternative to query builder in actionGetPageTitles()
     */
    public function actionGetPageTitlesAr() {
        $criteria = new CDbCriteria;
        $criteria->condition = 'title LIKE :title';
        $criteria->params = array(':title' => '%' . $_GET['term'] . '%');
        $titles = Page::model()->findAll($criteria);
        $data = array();
        foreach ($titles as $row) {
            $data[]['value'] = $row->title;
        }
        echo CJSON::encode($data);
        Yii::app()->end();
    }


}

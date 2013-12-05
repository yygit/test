<?php

class StatController extends Controller{

    /**
     * @return array action filters
     */
    public function filters() {
        return CMap::mergeArray(array(
                'accessControl', // perform access control for CRUD operations
                'postOnly + delete', // we only allow deletion via POST request
            ),
            parent::filters());
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index','timestamp'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Comment::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'comment-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }


    /**
     * Testing the auto-refresh block
     * http://www.yiiframework.com/forum/index.php/topic/40819-div-tag-with-ajax-refresh/
     * @todo return total numbers of users, projects, issues, comments
     */
    public function actionIndex() {
        if (!Yii::app()->authManager->checkAccessNoBizrule('member', Yii::app()->user->id)) {
            throw new CHttpException(403, 'You are not authorized to perform this action.');
        }
        echo 'current date is ' . date('r');
    }

    public function actionTimestamp() {
        if (!Yii::app()->authManager->checkAccessNoBizrule('reader', Yii::app()->user->id)) {
            throw new CHttpException(403, 'You are not authorized to perform this action.');
        }
        echo time();
    }
}

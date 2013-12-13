<?php

class DefaultController extends AdminController{

    /**
     * @return array action filters
     */
    public function filters() {
        return CMap::mergeArray(array(
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
        return CMap::mergeArray(array(
                array('allow', // allow
                    'actions' => array('index'),
                    'roles' => array('adminManagement'),
                ),
            ),
            parent::accessRules());
    }

    public function actionIndex() {
        $this->render('index');
    }
}

<?php
class BlogModule extends CWebModule{

    public $defaultController = 'site';

    public function init() {
        // this method is called when the module is being created; you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'blog.models.*',
            'blog.components.*',
        ));

        $this->layout = 'main';
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed; you may place customized code here
            $this->_setController($controller);
            return true;
        } else
            return false;
    }

    /**
     * @param $controller
     */
    private function _setController(CController $controller) {
        $controller->moduleparams = $this->getParams();
        $controller->moduleparams->maincssBaseUrl = Yii::app()->request->baseUrl;
        if (!empty($controller->moduleparams->theme) AND !empty(Yii::app()->theme) AND $controller->moduleparams->theme === Yii::app()->theme->name)
            $controller->moduleparams->maincssBaseUrl = Yii::app()->theme->baseUrl;
    }
}

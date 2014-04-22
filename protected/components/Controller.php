<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController{
    /**
     * @var CAttributeCollection params passed to module
     * YY; 20140419
     */
    public $moduleparams;
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();


    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            array(
                'HttpsFilter + update, create', // update only thru HTTPS
                'schema' => 'https',
            ),
            array(
                'HttpsFilter - update, create', // the rest is only thru HTTP
                'schema' => 'http',
            ),
        );
    }

    /**
     * In-class defined filter method, configured for use in above filters() method
     * It is called before the actionCreate() action method is run in order to ensure a proper request protocol
     */
    public function filterFailInsecure($filterChain) {
        if (!Yii::app()->request->getIsSecureConnection())
            throw new CHttpException(403, 'only secure connection allowed');

        //complete the running of other filters and execute the requested action
        $filterChain->run();
    }


}

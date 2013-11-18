<?php
/**
 * Class SetgetController
 */
class SetgetController extends Controller{
    /**
     *  testing setters and getters from Setget component
     */
    public function actionIndex() {
        $obj = new Setget();
        $obj->var1 = 'var1';
        var_dump($obj->var1);
    }




}

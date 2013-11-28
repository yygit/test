<?php

class HttpsFilter extends CFilter{

    public $schema = 'https';

    protected function preFilter($filterChain) {
        /*try {

        } catch (CDbException $e) {
            if ($e) return true;
        }*/
        $schema = $this->schema == 'https' ? 'https' : 'http';
        $url = $schema . '://' . Yii::app()->getRequest()->serverName . Yii::app()->getRequest()->requestUri;
        if (!Yii::app()->getRequest()->isSecureConnection AND $this->schema == 'https') {
            # Redirect to secure version of the page
            Yii::app()->request->redirect($url);
            return false;
        } elseif (Yii::app()->getRequest()->isSecureConnection AND $this->schema == 'http') {
            # Redirect to insecure version of the page
            Yii::app()->request->redirect($url);
            return false;
        }
        return true;
    }
}

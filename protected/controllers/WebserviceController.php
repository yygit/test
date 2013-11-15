<?php
/**
 * Class WebserviceController
 * // YY; 20131115; see Special Topics: Web Service | The Definitive Guide to Yii
 * http://www.yiiframework.com/doc/guide/1.1/en/topics.webservice
 */
class WebserviceController extends Controller{

    public function actions() {
        return array(
            'quote' => array(
                'class' => 'CWebServiceAction',
            ),
        );
    }

    /**
     * @param string the symbol of the stock
     * @return float the stock price
     * @soap
     */
    public function getPrice($symbol) {
        $prices = array('IBM' => 100, 'GOOGLE' => 350);
        return isset($prices[$symbol]) ? $prices[$symbol] : 0;
    }
}

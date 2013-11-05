<?php

// change the following paths if necessary
//$yii=dirname(__FILE__).'/../yii/framework/yii.php';					// Yii ver. 1.1.7
$yii=dirname(__FILE__).'/../stargame/www/framework/yii.php'; 			// Yii ver. 1.1.13
// $yii=dirname(__FILE__).'/../stargame/www/framework/yiilite.php'; 		
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
$app = Yii::createWebApplication($config);

// adding custom Zend Framework autoloader
/* Yii::import("application.vendors.*");
Yii::import("application.components.EZendAutoloader", true);
Yii::registerAutoloader(array('EZendAutoloader','loadClass'), true);  
 */
  
$app->run();  

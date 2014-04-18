<?php
$host = ($_SERVER['HTTP_HOST'] == 'localhost' OR preg_match('|^127.0.0.1$|', $_SERVER['HTTP_HOST'])) ? 'development' : 'production';
// change the following paths if necessary
//$yii = dirname(__FILE__) . '/../yii/framework/yiilite.php'; // Yii ver. 1.1.7
$yii = dirname(__FILE__) . '/../stargame/www/framework/yiilite.php'; // Yii ver. 1.1.13

// uncomment  to run in production mode (yiilite + no debug)
//$host = 'production';

if ($host == 'development') {
//    $yii=dirname(__FILE__).'/../yii/framework/yii.php';					// Yii ver. 1.1.7
    $yii = dirname(__FILE__) . '/../stargame/www/framework/yii.php'; // Yii ver. 1.1.13
    // remove the following lines when in production mode
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    // specify how many levels of call stack should be shown in each log message
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
}
$config = dirname(__FILE__) . '/protected/config/main.php';

require_once($yii);
$app = Yii::createWebApplication($config);
/*attaching a handler to application start, starting output buffering with gzip handler*/
//Yii::app()->onBeginRequest = create_function('$event', 'return ob_start("ob_gzhandler");');
/*attaching a handler to application end, releasing output buffer*/
//Yii::app()->onEndRequest = create_function('$event', 'return ob_end_flush();');
$app->run();

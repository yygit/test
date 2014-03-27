<?php

// change the following paths if necessary
//$yiit=dirname(__FILE__).'/../../../yii/framework/yiit.php'; // Yii ver. 1.1.7
$yiit=dirname(__FILE__).'/../../../stargame/www/framework/yiit.php'; // Yii ver. 1.1.13
$config=dirname(__FILE__).'/../config/test.php';

require_once($yiit);
require_once(dirname(__FILE__).'/WebTestCase.php');

Yii::createWebApplication($config);

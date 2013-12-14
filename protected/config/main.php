<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('shared','D:\htdocs\test_shared');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'LOCALHOST / TEST',
//    'theme' => 'newtheme',
    'theme' => 'grey',
    'sourceLanguage' => '00',
    'language' => 'en',

    // preloading 'log' and other components
    'preload' => array(
        'log',
//        'bootstrap',
    ),

    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.modules.admin.models.*',
//         'shared.*',
    ),

    'modules' => array(
        // uncomment the following to enable the Gii tool
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => false,
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
        'admin' => array(
            'params' => array(
                'theme' => 'grey',
                'testvar1' => 11111,
                'testvar2' => 1234,
                'testvar3' => '12 some string 34',
            ),
        ),
    ),

    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication ("remember me" feature)
            'allowAutoLogin' => false,
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                '<pid:\d+>/commentfeed' => array('comment/feed', 'urlSuffix' => '.xml', 'caseSensitive' => false),
                'commentfeed' => array('comment/feed', 'urlSuffix' => '.xml', 'caseSensitive' => false),
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        'db' => require(dirname(__FILE__) . '/db.php'),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array_filter(array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error',
                    'logFile' => 'error.log',
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'warning',
                    'logFile' => 'warning.log',
                ),
                /*array(
                    'class' => 'MyCEmailLogRoute',
                    'levels' => 'warning, error',
                    'utf8' => true,
                    'mailer' => 'smtp',
                    'emails' => array('4841601@gmail.com'),
                    'sentFrom' => 'MyCEmailLogRoute@example.com',
                    'subject' => 'MyCEmailLogRoute at '.$_SERVER['HTTP_HOST'],
                    'enabled' => !YII_DEBUG,
                ),*/
                YII_DEBUG ? array(
                    'class' => 'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                    'ipFilters' => array('localhost', '127.0.0.1', '::1'),
                ) : null,
                // uncomment the following to show log messages on web pages
                /*array(
                    'class' => 'CWebLogRoute',
                    'levels' => 'warning, error',
                ),*/
                /*array(
                    'class'=>'CProfileLogRoute',
                ),*/
            )),
        ),

        /*'request'=>array(
             'enableCookieValidation'=>true,
             'enableCsrfValidation'=>true,
        ),*/
        'authManager' => array(
//            'class' => 'CDbAuthManager',
            'class' => 'MyCDbAuthManager',
            'connectionID' => 'db',
            'itemTable' => 'tbl_auth_item',
            'itemChildTable' => 'tbl_auth_item_child',
            'assignmentTable' => 'tbl_auth_assignment',
        ),
        /*'bootstrap' => array(
            'class' => 'ext.bootstrap.components.Bootstrap',
            'responsiveCss' => true,
        ),*/
        /*'session' => array(
            'class' => 'CDbHttpSession',
            'connectionID' => 'db',
            'sessionTableName' => 'session',

//			'class' =>'CCacheHttpSession',
//			'cacheID' => 'cache',
        ),*/

        /*'cache' => array(
			'class' => 'CApcCache',
		),*/
        'Smtpmail' => array(
            'class' => 'ext.smtpmail.PHPMailer',
            'Host' => "smtp.gmail.com",
            'Username' => 'nebazori@gmail.com',
            'Password' => 'z87654312',
            'Mailer' => 'smtp',
            'Port' => 587,
            'SMTPAuth' => true,
            'SMTPSecure' => 'tls',
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'nebazori@gmail.com',
        'encryptionKey' => '1a2S3d4f5G',
        'God' => 'admin',
    ),
);

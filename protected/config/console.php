<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Test Console Application',
    'commandMap' => array(
        'clean' => array(
            'class' => 'ext.clean-command.ECleanCommand',
            'webRoot' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..',
        ),
    ),
    'import' => array(
        //  'ext.TXDbMigration.*',
        'application.models.*',
        'application.components.*',
    ),
    // application components
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=sakila',
            'emulatePrepare' => true,
            'username' => 'yy',
            'password' => 'yura',
            'charset' => 'utf8',
        ),
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
            'itemTable' => 'tbl_auth_item',
            'itemChildTable' => 'tbl_auth_item_child',
            'assignmentTable' => 'tbl_auth_assignment',
        ),
    ),
);

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
        'application.modules.blog.models.*',
        'application.modules.blog.components.*',
    ),
    // application components
    'components' => array(
        'db' => require(dirname(__FILE__) . '/db.php'),
        'db_blog' => require(dirname(__FILE__) . '/db_blog.php'),
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
            'itemTable' => 'tbl_auth_item',
            'itemChildTable' => 'tbl_auth_item_child',
            'assignmentTable' => 'tbl_auth_assignment',
        ),
    ),
);

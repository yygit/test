<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Test Console Application',
	'commandMap' => array(
		'clean' => array(
			'class' => 'ext.clean_command.ECleanCommand',
			'webRoot' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..',
		),
	),
    'import' => array(
        'ext.TXDbMigration.*',
    ),
	// application components
	'components'=>array(
		/* 'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		), */
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=sakila',
			'emulatePrepare' => true,
			'username' => 'yy',
			'password' => 'yura',
			'charset' => 'utf8',
		),		
	),
);

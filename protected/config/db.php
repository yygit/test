<?php
return array(
    'pdoClass' => 'NestedPDO',
    'connectionString' => 'mysql:host=localhost;dbname=sakila',
    'emulatePrepare' => true,
    'username' => 'yy',
    'password' => 'yura',
    'charset' => 'utf8',

	'schemaCachingDuration' => 180,
	'queryCacheID' => 'cache',
    'enableProfiling' => true,
    'enableParamLogging' => true,
);

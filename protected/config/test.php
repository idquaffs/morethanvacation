<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/custom.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			'log'=>array(
				'class'=>'CLogRouter',
				'routes'=>array(
					array(
						'class'=>'CFileLogRoute',
						'levels'=>'error, warning',
					),
					array(
						'class'=>'CWebLogRoute',
						'categories'=>'system.db.CDbCommand',
						'showInFireBug'=>true,
					),
				),
			),
			'db'=>array(
				'connectionString' => 'mysql:host=localhost;dbname=10mins',
				'emulatePrepare' => true,
				'username' => 'root',
				'password' => '',
				'enableProfiling'=>true,
				'enableParamLogging'=>true,
			),
		),
		'modules'=>array(
			// uncomment the following to enable the Gii tool
			//*
			'gii'=>array(
				'class'=>'system.gii.GiiModule',
				'password'=>'1234',
			 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
				'ipFilters'=>array('127.0.0.1','::1'),
				'generatorPaths' => array(
					'ext.giix-core', // giix generators
					'application.gii',
				),
			),
			//*/
		),
	)
);

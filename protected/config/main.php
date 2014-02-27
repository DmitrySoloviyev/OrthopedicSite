<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return [
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'База данных ортопедической обуви',
    'language' => 'ru',
    'charset' => 'utf-8',

    // preloading 'log' component
    'preload' => ['log'],

    // autoloading model and component classes
    'import' => [
        'application.models.*',
        'application.components.*',
    ],

    'modules' => [
        // uncomment the following to enable the Gii tool
        'gii' => [
            'class' => 'system.gii.GiiModule',
            'password' => '1111',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ],
    ],

    // application components
    'components' => [
        'user' => [
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ],
        // uncomment the following to enable URLs in path-format

        /*	'urlManager'=>array(
                'urlFormat'=>'path',
                'showScriptName' => false,
                'rules'=>array(
                    '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+|\w+>'=>'<controller>/<action>',
                    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                ),
            ),*/

        /*
        'db'=>array(
            'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
        ),
        */
        // uncomment the following to use a MySQL database
        'db' => [
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=SHOES',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '1111',
            'charset' => 'utf8',
            // включить кэширование схем бд для улучшения производительности, месяц
//            'schemaCachingDuration' => 2592000,
        ],
        'errorHandler' => [
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ],
/*        	'log'=>array(
                'class'=>'CLogRouter',
                'routes'=>array(
                    array(
                        'class'=>'CFileLogRoute',
                        'levels'=>'error, warning',
                    ),
                    // uncomment the following to show log messages on web pages

                    array(
                        'class'=>'CWebLogRoute',
                    ),

                    array(
                        'class'=>'CProfileLogRoute',
                        'enabled'=>true,
                    ),

                ),
            ),*/
    ],

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => [
        // this is used in contact page
        'adminEmail' => 'dmitry.soloviyev@gmail.com',
    ],
    'timeZone' => 'Europe/Moscow',
];

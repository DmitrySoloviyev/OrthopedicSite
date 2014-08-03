<?php
return [
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'База данных ортопедической обуви',
    'defaultController' => 'order',
    'language' => 'ru',
    'sourceLanguage' => 'en',
    'charset' => 'utf-8',
    'preload' => ['log'],
    'controllerMap' => [
        'min' => [
            'class' => 'ext.minScript.controllers.ExtMinScriptController',
        ],
    ],
//    'aliases' => [
//        'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'),
//    ],
    'import' => [
        'application.models.*',
        'application.components.*',
//        'bootstrap.helpers.TbHtml',
    ],
    'modules' => [
        'admin' => [
            'class' => 'application.modules.admin.AdminModule',
            'preload' => ['bootstrap'],
            'aliases' => [
                'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'),
            ],
            'import' => [
                'bootstrap.helpers.*',
                'bootstrap.behaviors.*',
                'bootstrap.widgets.*',
            ],
            'components' => [
                'bootstrap' => [
                    'class' => 'bootstrap.components.TbApi',
                ],
            ],
        ],
        'gii' => [
            'class' => 'system.gii.GiiModule',
            'password' => '1111',
            'ipFilters' => ['127.0.0.1', '192.168.33.1'],
//            'generatorPaths' => ['bootstrap.gii'],
        ],
    ],
    'components' => [
        'redis' => [
            'class' => 'application.components.YiiRedis.ARedisConnection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 1,
            'prefix' => 'ortho.'
        ],
//        'bootstrap' => [
//            'class' => 'bootstrap.components.TbApi',
//        ],
        'request' => [
            'enableCsrfValidation' => true,
            'enableCookieValidation' => true,
        ],
        'user' => [
            'allowAutoLogin' => true,
            'loginUrl' => ['user/login'],
        ],
        'urlManager' => [
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => [
                'gii' => 'gii',
                '' => 'order/index',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>/<id>',

                '<module:\w+>/<controller:\w+>/<id:\d+>' => '<module>/<controller>/view',
                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',

                '/admin/*' => 'admin',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>/<id>',
            ],
        ],
        'db' => [
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=ortho_db',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '1111',
            'charset' => 'utf8',
            'enableProfiling' => YII_DEBUG,
            'enableParamLogging' => YII_DEBUG,
            'schemaCachingDuration' => YII_DEBUG ? 0 : 2592000,
        ],
        'errorHandler' => [
            'errorAction' => 'order/error',
        ],
        'log' => [
            'class' => 'CLogRouter',
            'routes' => [
                [
                    'class' => 'CProfileLogRoute',
                    'enabled' => YII_DEBUG,
                    'report' => 'summary',
                ],
                [
                    'class' => 'CWebLogRoute',
                ],
            ],
        ],
        'session' => [
            'class' => 'CCacheHttpSession',
        ],
        'cache' => [
            'class' => 'application.components.YiiRedis.ARedisCache'
        ],
        'widgetFactory' => [
            'widgets' => [
                'CLinkPager' => [
                    'maxButtonCount' => 5,
                ],
                'CJuiDatePicker' => [
                    'language' => 'ru',
                    'htmlOptions' => [
                        'required' => 'required',
                        'autocomplete' => 'Off',
                        'style' => 'width:150px',
                        'placeholder' => 'дд.мм.гггг',
                    ],
                    'options' => [
                        'showAnim' => 'fadeIn',
                        'maxDate' => '+0d',
                        'changeYear' => true,
                    ],
                ],
                'CActiveForm' => [
                    'enableClientValidation' => true,
                    'clientOptions' => ['validateOnSubmit' => true],
                ],
            ],
        ],
        'clientScript' => [
            'class' => 'ext.minScript.components.ExtMinScript',
        ],
    ],
    'params' => [
        'adminEmail' => 'dmitry.soloviyev@gmail.com',
        'version' => 'Версия 0.3 - dev',
    ],
    'timeZone' => 'Europe/Moscow',
];

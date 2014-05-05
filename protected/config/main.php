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
    'import' => [
        'application.models.*',
        'application.components.*',
    ],
    'modules' => [
        'gii' => [
            'class' => 'system.gii.GiiModule',
            'password' => '1111',
            'ipFilters' => ['127.0.0.1', '192.168.33.1'],
        ],
    ],
    'components' => [
        'redis' => [
            'class' => 'application.components.YiiRedis.ARedisConnection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 1,
            'prefix' => 'Yii.redis.'
        ],
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
                'gii/<controller:\w+>' => 'gii/<controller>',
                'gii/<controller:\w+>/<action:\w+>' => 'gii/<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+|\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'db' => [
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=ortho_db',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '1111',
            'charset' => 'utf8',
            'enableProfiling' => true,
            'enableParamLogging' => true,
            'schemaCachingDuration' => 0, // месяц 2592000
        ],
        'errorHandler' => [
            'errorAction' => 'order/error',
        ],
        'log' => [
            'class' => 'CLogRouter',
            'routes' => [
                [
                    'class' => 'CProfileLogRoute',
                    'enabled' => true,
                    'report' => 'summary',
                ],
                [
                    'class' => 'CWebLogRoute',
                ],
                [
                    'class' => 'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                    'ipFilters' => ['127.0.0.1', '192.168.33.1'],
                    'enabled' => YII_DEBUG,
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
    ],
    'timeZone' => 'Europe/Moscow',
];

<?php
return [
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'База данных ортопедической обуви',
    'defaultController' => 'site',
    'language' => 'ru',
    'sourceLanguage' => 'en',
    'charset' => 'utf-8',
    'preload' => ['log'],
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
        'request' => [
            'enableCsrfValidation' => true,
            'enableCookieValidation' => true,
        ],
        'user' => [
            'allowAutoLogin' => true,
            'loginUrl' => ['site/login'],
        ],
        'urlManager' => [
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => [
                'gii' => 'gii',
                'gii/<controller:\w+>' => 'gii/<controller>',
                'gii/<controller:\w+>/<action:\w+>' => 'gii/<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+|\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'db' => [
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=SHOES',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '1111',
            'charset' => 'utf8',
            'enableProfiling' => true,
            'enableParamLogging' => true,
            'schemaCachingDuration' => 0, // месяц 2592000
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
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
                    'ipFilters' => array('127.0.0.1', '192.168.33.1'),
                    'enabled' => YII_DEBUG,
                ],
            ],
        ],
        'session' => [
            'class' => 'CCacheHttpSession',
        ],
        'cache' => [
            'class' => 'CApcCache'
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
            ],
        ],
    ],
    'params' => [
        'adminEmail' => 'dmitry.soloviyev@gmail.com',
    ],
    'timeZone' => 'Europe/Moscow',
];

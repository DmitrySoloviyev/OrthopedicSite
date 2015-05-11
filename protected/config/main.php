<?php
return [
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'База данных ортопедической обуви',
    'defaultController' => 'site',
    'language' => 'ru',
    'sourceLanguage' => 'en',
    'charset' => 'utf-8',
    'controllerMap' => [
        'min' => [
            'class' => 'ext.minScript.controllers.ExtMinScriptController',
        ],
    ],
    'aliases' => [
        'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'),
        'yiiwheels' => realpath(__DIR__ . '/../extensions/yiiwheels'),
    ],
    'import' => [
        'application.models.*',
        'application.components.*',
        'application.components.behaviors.*',
        'bootstrap.helpers.*',
        'bootstrap.behaviors.*',
        'bootstrap.widgets.*',
        'bootstrap.components.*',
        'bootstrap.form.*',
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
    ],
    'components' => [
        'bootstrap' => [
            'class' => 'bootstrap.components.TbApi',
        ],
        'yiiwheels' => [
            'class' => 'yiiwheels.YiiWheels',
        ],
        'format' => [
            'class' => 'yiiwheels.widgets.timeago.WhTimeAgoFormatter',
        ],
        'redis' => [
            'class' => 'application.components.YiiRedis.ARedisConnection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 1,
            'prefix' => 'ortho.'
        ],
        'request' => [
            'enableCsrfValidation' => true,
            'enableCookieValidation' => true,
        ],
        'user' => [
            'allowAutoLogin' => true,
            'loginUrl' => ['user/login'],
            'class' => 'WebUser',
        ],
        'session' => [
            'sessionName' => 'phpsession',
            'class' => 'CCacheHttpSession',
            'cookieMode' => 'only',
            'timeout' => 60 * 60 * 4 //сессия закрывается через 4 часа
        ],
        'urlManager' => [
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => [
                'gii' => 'gii',
                '' => 'site/index',
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
            'class' => 'system.db.CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=ortho_db',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '1111',
            'charset' => 'utf8mb4',
            'schemaCachingDuration' => 2592000,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
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
                'WhDatePicker' => [
                    'htmlOptions' => [
                        'required' => 'required',
                        'placeholder' => 'дд.мм.гггг',
                        'autocomplete' => 'Off',
                    ],
                    'pluginOptions' => [
                        'language' => 'ru',
                        'format' => 'yyyy-mm-dd'
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
        'version' => 'Версия 0.5-dev',
    ],
    'timeZone' => 'Europe/Moscow',
];

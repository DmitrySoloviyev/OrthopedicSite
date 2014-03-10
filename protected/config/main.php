<?php
return [
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'База данных ортопедической обуви',
    'language' => 'ru',
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
            'ipFilters' => array('127.0.0.1', '192.168.33.1'),
        ],
    ],
    'components' => [
        'request' => [
            'enableCsrfValidation' => true,
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
//            'schemaCachingDuration' => 2592000, // включить кэширование схем бд для улучшения производительности, месяц
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

    // using Yii::app()->params['paramName']
    'params' => [
        'adminEmail' => 'dmitry.soloviyev@gmail.com',
    ],
    'timeZone' => 'Europe/Moscow',
];

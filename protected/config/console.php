<?php
return [
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Console OrthoDB Application',
    'preload' => ['log'],
    'components' => [
        'db' => [
            'connectionString' => 'mysql:host=localhost;dbname=SHOES',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '1111',
            'charset' => 'utf8',
            'schemaCachingDuration' => 2592000,
        ],
        'log' => [
            'class' => 'CLogRouter',
            'routes' => [
                [
                    'class' => 'CFileLogRoute',
                    'levels' => 'info',
                    'logFile' => 'backup.log',
                ],
            ],
        ],
    ],
    'timeZone' => 'Europe/Moscow',
];

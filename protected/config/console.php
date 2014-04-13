<?php
return [
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Console OrthoDB Application',
    'preload' => ['log'],
    'components' => [
        'db' => [
            'connectionString' => 'mysql:host=localhost;dbname=ortho_db',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '1111',
            'charset' => 'utf8',
            'schemaCachingDuration' => 0,
        ],
        'db_test' => [
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=ortho_db_test',
            'username' => 'root',
            'password' => '1111',
            'charset' => 'utf8',
            'schemaCachingDuration' => 0,
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
    'commandMap' => [
        'migrate' => [
            'class' => 'system.cli.commands.MigrateCommand',
            'interactive' => false,
        ],
    ],
    'timeZone' => 'Europe/Moscow',
];

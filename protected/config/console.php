<?php
return [
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Console OrthoDB Application',
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
        'redis' => [
            'class' => 'application.components.YiiRedis.ARedisConnection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 1,
            'prefix' => 'ortho.'
        ],
        'cache' => [
            'class' => 'application.components.YiiRedis.ARedisCache'
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

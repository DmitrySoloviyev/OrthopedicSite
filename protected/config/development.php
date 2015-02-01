<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 10.08.14
 * Time: 9:30
 */

return CMap::mergeArray(
    require(dirname(__FILE__) . '/main.php'),
    [
        'preload' => ['log'],
        'modules' => [
            'gii' => [
                'class' => 'system.gii.GiiModule',
                'password' => '1111',
                'ipFilters' => ['127.0.0.1', '192.168.33.1'],
            ],
        ],
        'components' => [
            'db' => [
                'class' => 'system.db.CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=ortho_db',
                'emulatePrepare' => true,
                'username' => 'root',
                'password' => '1111',
                'charset' => 'utf8mb4',
                'enableProfiling' => true,
                'enableParamLogging' => true,
                'schemaCachingDuration' => 0,
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
                        'class' => 'CFileLogRoute',
                        'levels' => 'error, warning',
                        'categories' => 'system.db.*',
                        'logFile' => 'db.log',
                    ],
                ],
            ],
        ],
    ]
);

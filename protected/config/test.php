<?php

return CMap::mergeArray(
    require(dirname(__FILE__) . '/main.php'),
    [
        'components' => [
            'fixture' => [
                'class' => 'system.test.CDbFixtureManager',
            ],
            'db' => [
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=localhost;dbname=ortho_db_test',
                'username' => 'root',
                'password' => '1111',
                'charset' => 'utf8',
            ],
            'urlManager' => [
                'urlFormat' => 'get',
                'showScriptName' => true,
            ],
//            'request' => [
//                'serverName' => 'http://localhost',
//                'scriptUrl' => '/',
//                'hostInfo' => 'http://localhost',
//                'baseUrl' => 'http://localhost/index-test.php',
//            ],
        ],
    ]
);

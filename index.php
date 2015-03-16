<?php
$yii = dirname(__FILE__) . '/framework/yii.php';

defined('YII_DEBUG') or define('YII_DEBUG', false);

if (YII_DEBUG) {
    $config = dirname(__FILE__) . '/protected/config/development.php';
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 2);
} else {
    $config = dirname(__FILE__) . '/protected/config/main.php';
}

require_once($yii);
Yii::createWebApplication($config)->run();

<?php
// in production mode $yii = dirname(__FILE__) . '/framework/yiilite.php';
$yii = dirname(__FILE__) . '/framework/yii.php';
$config = dirname(__FILE__) . '/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 2);

require_once($yii);
Yii::createWebApplication($config)->run();

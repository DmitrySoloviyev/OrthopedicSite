<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 10.08.14
 * Time: 11:10
 */
class CacheCommand extends CConsoleCommand
{
    /**
     * Очистка кеша
     */
    public function actionFlush()
    {
        echo (Yii::app()->cache->flush()) ? "OK\n" : "FAIL\n";
    }
}

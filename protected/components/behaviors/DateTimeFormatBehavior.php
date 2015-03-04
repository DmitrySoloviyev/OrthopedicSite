<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 04.03.15
 * Time: 23:11
 */
class DateTimeFormatBehavior extends CBehavior
{
    public function hiddmmyyyy($dateTime = null)
    {
        return date('H:i d.m.Y', $dateTime ? strtotime($dateTime) : time());
    }

}

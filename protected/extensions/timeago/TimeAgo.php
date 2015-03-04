<?php

/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 04.03.15
 * Time: 22:29
 */
class TimeAgo extends CWidget
{
    public $date = null;
    public $tag = 'abbr';
    public $htmlOptions = [];

    public function init()
    {
        $this->attachBehavior('DateTimeFormat', ['class' => 'DateTimeFormatBehavior']);

        if ($this->date == null)
            $this->date = time();

        $this->htmlOptions['title'] = $this->hiddmmyyyy($this->date);

        parent::init();
    }

    public function run()
    {
        parent::run();

        return CHtml::tag($this->tag, $this->htmlOptions, Yii::app()->format->timeago($this->date));
    }

    function __toString()
    {
        return CHtml::tag($this->tag, $this->htmlOptions, Yii::app()->format->timeago($this->date));
    }

}

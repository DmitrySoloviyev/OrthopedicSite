<?php

/**
 * Flash displays web user flash messages.
 */
class Flash extends CWidget
{
    /**
     * @property array the keys for which to get flash messages.
     */
    public $keys;

    public $template = '<div class="{key}">{message}</div>';

    public $htmlOptions = [];

    public $js = "$('.alert').animate({opacity: 1.0}, 3000).slideUp('medium');";
    /**
     * @property string message type ()
     */
    private $type = null;

    public function run()
    {
        $id = $this->getId();

        if (isset($this->htmlOptions['id']))
            $id = $this->htmlOptions['id'];
        else
            $this->htmlOptions['id'] = $id;

        if (is_string($this->keys))
            $this->keys = [$this->keys];

        $markup = '';
        foreach ($this->keys as $key) {
            if (Yii::app()->user->hasFlash($key)) {
                $this->type = $key;
                $markup .= strtr($this->template, [
                    '{key}' => $key,
                    '{message}' => Yii::app()->user->getFlash($key),
                ]);
            }
        }

        if ($markup !== '') {
            echo TbHtml::alert($this->type, $markup);
        }

        if ($this->js) {
            Yii::app()->clientScript->registerScript(__CLASS__ . '#' . $id,
                strtr($this->js, ['{id}' => $id]), CClientScript::POS_END);
        }
    }

}

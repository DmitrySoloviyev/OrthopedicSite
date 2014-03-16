<?php
/**
 * Flash widget class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

/**
 * Flash displays web user flash messages.
 */
class Flash extends CWidget
{
    /**
     * @property array the keys for which to get flash messages.
     */
    public $keys;
    /**
     * @property string the template to use for displaying flash messages.
     */
    public $template = '<div class="{key}">{message}</div>';
    /**
     * @property array the html options.
     */
    public $htmlOptions = array();
    /**
     * @property string the associated JavaScript.
     */
    public $js = null;
    /**
     * @property string message type ()
     */
    private $type = null;

    /**
     * Runs the widget.
     */
    public function run()
    {
        $id = $this->getId();

        if (isset($this->htmlOptions['id']))
            $id = $this->htmlOptions['id'];
        else
            $this->htmlOptions['id'] = $id;

        if (is_string($this->keys))
            $this->keys = array($this->keys);

        $markup = '';
        foreach ($this->keys as $key) {
            if (Yii::app()->user->hasFlash($key)) {
                $this->type = $key;
                $markup .= strtr($this->template, array(
                    '{key}' => $key,
                    '{message}' => Yii::app()->user->getFlash($key),
                ));
            }
        }

        if ($markup !== '') {
            echo CHtml::openTag('div', is_null($this->type) ? [] : $this->htmlOptions[$this->type]);
            echo $markup;
            echo CHtml::closeTag('div');
        }

        if ($this->js){
            Yii::app()->clientScript->registerScript(__CLASS__ . '#' . $id,
                strtr($this->js, array('{id}' => $id)), CClientScript::POS_READY);
        }
    }

}

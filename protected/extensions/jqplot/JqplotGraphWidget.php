<?php
Yii::import('application.extensions.jqplot.JqplotWidget');

class JqplotGraphWidget extends JqplotWidget
{

    public $tagName = 'div';

    public $ajaxOptions = [];

    public $defaultAjaxOptions = [
        'dataType' => 'json',
        'async' => false,
        'success' => 'js:function(data){ret=data;}'
    ];


    protected function createJQPlotScript($plotdata)
    {
        $id = $this->htmlOptions['id'];
        $flotoptions = CJavaScript::encode($this->options);

        return "$.jqplot('$id',$plotdata,$flotoptions);";
    }

    protected function createAjaxJQPlotScript()
    {
        $ajaxoptions = array_merge($this->ajaxOptions, $this->defaultAjaxOptions);
        $ajax = '$.ajax(' . CJavaScript::encode($ajaxoptions) . ');';
        $datarenderer = 'js:function(url,plot,options){var ret=null;' . $ajax . 'return ret;}';
        $this->options['dataRenderer'] = $datarenderer;
        $flotoptions = CJavaScript::encode($this->options);
        $id = $this->htmlOptions['id'];

        return "$.jqplot('$id',[],$flotoptions);";
    }

    public function run()
    {
        if (!isset($this->htmlOptions['id']))
            $this->htmlOptions['id'] = $this->getId();
        echo CHtml::tag($this->tagName, $this->htmlOptions, '');

        if (is_array($this->data))
            $script = $this->createJQPlotScript(CJavaScript::encode($this->data));
        else {
            if (!isset($this->ajaxOptions['url']) && is_string($this->data))
                $this->ajaxOptions['url'] = $this->data;
            $script = $this->createAjaxJQPlotScript($this->ajaxOptions);

        }

        Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $this->htmlOptions['id'], $script);
    }

}

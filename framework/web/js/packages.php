<?php
/**
 * Built-in client script packages.
 *
 * Please see {@link CClientScript::packages} for explanation of the structure
 * of the returned array.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

return array(
	'jquery'=>array(
		'js'=>array(YII_DEBUG ? 'jquery.js' : 'jquery.min.js'),
	),
	'yii'=>array(
		'js'=>array('jquery.yii.js'),
		'depends'=>array('jquery'),
	),
	'yiitab'=>array(
		'js'=>array('jquery.yiitab.js'),
		'depends'=>array('jquery'),
	),
	'yiiactiveform'=>array(
		'js'=>array('jquery.yiiactiveform.js'),
		'depends'=>array('jquery'),
	),
	'jquery.ui'=>array(
		'js'=>array('jui/js/jquery-ui.min.js'),
		'css' => array('jui/css/base/jquery-ui.css'),
		'depends'=>array('jquery'),
	),
	'bgiframe'=>array(
		'js'=>array('jquery.bgiframe.js'),
		'depends'=>array('jquery'),
	),
	'ajaxqueue'=>array(
		'js'=>array('jquery.ajaxqueue.js'),
		'depends'=>array('jquery'),
	),
	'autocomplete'=>array(
		'js'=>array('jquery.autocomplete.js'),
		'depends'=>array('jquery', 'bgiframe', 'ajaxqueue'),
	),
	'maskedinput'=>array(
		'js'=>array(YII_DEBUG ? 'jquery.maskedinput.js' : 'jquery.maskedinput.min.js'),
		'depends'=>array('jquery'),
	),
	'cookie'=>array(
		'js'=>array('jquery.cookie.js'),
		'depends'=>array('jquery'),
	),
	'treeview'=>array(
		'js'=>array('jquery.treeview.js', 'jquery.treeview.edit.js', 'jquery.treeview.async.js'),
		'depends'=>array('jquery', 'cookie'),
	),
	'multifile'=>array(
		'js'=>array('jquery.multifile.js'),
		'depends'=>array('jquery'),
	),
	'rating'=>array(
		'js'=>array('jquery.rating.js'),
		'depends'=>array('jquery', 'metadata'),
	),
	'metadata'=>array(
		'js'=>array('jquery.metadata.js'),
		'depends'=>array('jquery'),
	),
	'bbq'=>array(
		'js'=>array(YII_DEBUG ? 'jquery.ba-bbq.js' : 'jquery.ba-bbq.min.js'),
		'depends'=>array('jquery'),
	),
	'history'=>array(
		'js'=>array('jquery.history.js'),
		'depends'=>array('jquery'),
	),
	'punycode'=>array(
		'js'=>array(YII_DEBUG ? 'punycode.js' : 'punycode.min.js'),
	),
	'highlight'=>array(
		'js'=>array('jquery.highlight.js'),
		'depends'=>array('jquery'),
	),
	'jqplot'=>array(
		'js'=>array('jqplot/js/jquery.jqplot.min.js'),
		'css' => array('jqplot/css/jquery.jqplot.min.css'),
		'depends'=>array('jquery'),
	),
	'jqplot.highlighter'=>array(
		'js'=>array('jqplot/js/jqplot.highlighter.js'),
		'depends'=>array('jquery'),
	),
	'jqplot.canvasTextRenderer'=>array(
		'js'=>array('jqplot/js/jqplot.canvasTextRenderer.min.js'),
		'depends'=>array('jquery'),
	),
	'jqplot.canvasAxisLabelRenderer'=>array(
		'js'=>array('jqplot/js/jqplot.canvasAxisLabelRenderer.min.js'),
		'depends'=>array('jquery'),
	),
	'jqplot.dateAxisRenderer'=>array(
		'js'=>array('jqplot/js/jqplot.dateAxisRenderer.min.js'),
		'depends'=>array('jquery'),
	),
	'jqplot.pieRenderer'=>array(
		'js'=>array('jqplot/js/jqplot.pieRenderer.min.js'),
		'depends'=>array('jquery'),
	),
	'jqplot.enhancedLegendRenderer'=>array(
		'js'=>array('jqplot/js/jqplot.enhancedLegendRenderer.min.js'),
		'depends'=>array('jquery'),
	),
	'jqplot.cursor'=>array(
		'js'=>array('jqplot/js/jqplot.cursor.min.js'),
		'depends'=>array('jquery'),
	),
);

<?php 
$this->pageTitle=Yii::app()->name . ' - Статистика';

$this->Widget('ext.highcharts.HighchartsWidget', array(
	'options'=>array(
	    'title' => array('text' => 'Соответствие сотрудников к их заказам'),
	    'xAxis' => array(
	        'categories' => array('Apples', 'Bananas', 'Oranges'),
	        'title' => array('text' => 'Заказы')
	    ),
	    'yAxis' => array(
	    	'title' => array('text' => 'Сотрудники')
	    ),
	     'series' => array(
	        array('name' => 'Jane', 'data' => array(1, 0, 4)),
	        array('name' => 'John', 'data' => array(5, 7, 3))
	    )
	)
));
?>
<?php 
$this->pageTitle=Yii::app()->name . ' - Статистика';

// Перевод названий месяцев
$monthNameRu = array(
	'January' => 'Январь', 
	'February' => 'Февраль', 
	'March' => 'Март', 
	'April' => 'Апрель', 
	'May' => 'Май', 
	'June' => 'Июнь', 
	'July' => 'Июль', 
	'August' => 'Август', 
	'September' => 'Сентябрь', 
	'October' => 'Октябрь', 
	'November' => 'Ноябрь', 
	'December' => 'Декабрь', 
);

// определяем текущий месяц и устанавливаем  начальную дату поиска на 2 месяца ранее  
$monthNumber = date("m");
$monthNumber -= 2;
$year = date("Y");
$startDate = date("Y-m-d H-i-s", strtotime($year."-".$monthNumber."-01"));

// посылаем запрос в БД, который вернет количество заказов, сгруппированных по дням
// начиная от текущей даты минус 2 месяца
$result = Yii::app()->db
	->createCommand('SELECT COUNT(DAY(Date)) AS COUNT, DAYOFMONTH(Date) AS DAY, MONTHNAME(Date) AS MONTH, DATE(Date) AS DAYDATE
					 FROM Orders 
					 WHERE Date BETWEEN \'{$startDate}\' AND NOW()
					 GROUP BY DAY WITH ROLLUP')->queryAll();
static $i = 0;
$max = 0;
foreach ($result as $key => $value) {
	foreach ($value as $key => $val) {
		if(empty($val) && !isset($val)){
			echo '<p>'.$monthNameRu[$value['MONTH']].': выполнено заказов '.$value['COUNT'].'</p>';
			continue;
		}else{
			if( !empty($value['DAY']) ){
				$data[] = "['".$value['DAYDATE']."', ".$value['COUNT']."]";
				if( $max < $value['COUNT'])
					$max = $value['COUNT'];
			}
		}
	}
	$i++;
}

$strData = "[[".implode(",", $data)."]]"; 
++$max;

Yii::app()->clientScript->registerPackage('jqplot');
Yii::app()->clientScript->registerPackage('jqplot.highlighter');
Yii::app()->clientScript->registerPackage('jqplot.canvasTextRenderer');
Yii::app()->clientScript->registerPackage('jqplot.canvasAxisLabelRenderer');
Yii::app()->clientScript->registerPackage('jqplot.dateAxisRenderer');

Yii::app()->clientScript->registerScript('graph',"
 $.jqplot(
 	'chartdiv',
 	".$strData.",
 	{
 		title:'Оценка производительности по дням недели',
   		axes:{
   			yaxis:{
   				min:0,
   				max:{$max},
   				label: 'Количество заказов',
   				labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
   			},
   			xaxis:{
   				label: 'Дни недели',
   				renderer:$.jqplot.DateAxisRenderer,
   				tickOptions:{formatString:'%#d %b'},
   			},
   		}, 
   		cursor: {
			show: true,
		},
		highlighter: {
			show: true,
			sizeAdjust: 10
		},
    	series:[{
   			color:'#509968',
   			showMarker:true,
    	}]
 	}
 );
", CClientScript::POS_READY);
?>

<div id="chartdiv"></div>
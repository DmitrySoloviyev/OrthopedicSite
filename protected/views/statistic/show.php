<?php
$this->pageTitle = Yii::app()->name . ' - Статистика';

Yii::app()->clientScript->registerScript('prepare', "
$(function(){
	var docHeight = $(document).height();
	$('body').append('<div id=\'overlay\' style=\'z-index=100\'></div>');
	$('#overlay').height(docHeight).css({
	    'opacity' : 0.4,
	    'position': 'absolute',
	    'top': 0,
	    'left': 0,
	    'background-color': 'black',
	    'width': '100%',
	    'z-index': 1
	});
});
", CClientScript::POS_READY);

// Перевод названий месяцев
$monthNameRu = [
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
];

// определяем текущий месяц и устанавливаем  начальную дату поиска на 2 месяца ранее  
$monthNumber = date("m");
$monthNumber -= 2;
$year = date("Y");
$startDate = date("Y-m-d H-i-s", strtotime($year . "-" . $monthNumber . "-01"));
$roof = $monthNumber + 3;

$db = Yii::app()->db;

$pre_result = $db->createCommand("SELECT COUNT(DAY(Date)) AS COUNT, MONTHNAME(Date) AS monthName,
  CONCAT(EmployeeSN, ' ', LEFT(EmployeeFN, 1), '.', LEFT(EmployeeP, 1), '.') as FIO
  FROM Orders JOIN Employees USING(EmployeeID)
  WHERE Date BETWEEN '{$startDate}' AND NOW()
  GROUP BY FIO, monthName WITH ROLLUP")->queryAll();

if (!$pre_result) {
    Yii::app()->clientScript->registerScript('prepareDone', "
	$(function(){
		$('#overlay').remove();
	});
	", CClientScript::POS_READY);
    echo 'Не обнаружено ни одного заказа.';
    return;
} else {
    $pre_result = array_reverse($pre_result);
    foreach ($pre_result as $res) {
        if (empty($res['monthName'])) continue;

        Yii::app()->clientScript->registerScript('show' . $res['monthName'], "
				$('.for" . $res['monthName'] . "').hide();
				$('#" . $res['monthName'] . "').click(function(){
					$('.for" . $res['monthName'] . "').each(function() {
						$(this).slideToggle(300);
					});
				});
			", CClientScript::POS_READY);
        echo '<div id="' . $res['monthName'] . '" style="padding:5px 20px 5px 20px; cursor:pointer;"><i>' .
                $monthNameRu[$res['monthName']] . ': выполнено заказов ' . $res['COUNT'] . '</i></div>';

        echo '<div class="for' . $res['monthName'] . '" style="padding:0 40px;"><i>' . $res['FIO'] .
            ': выполнил(а) заказов ' . $res['COUNT'] . '</i></div>';

    }
}

Yii::app()->clientScript->registerPackage('jqplot');
Yii::app()->clientScript->registerPackage('jqplot.highlighter');
Yii::app()->clientScript->registerPackage('jqplot.canvasTextRenderer');
Yii::app()->clientScript->registerPackage('jqplot.canvasAxisLabelRenderer');
Yii::app()->clientScript->registerPackage('jqplot.dateAxisRenderer');
Yii::app()->clientScript->registerPackage('jqplot.pieRenderer');
Yii::app()->clientScript->registerPackage('jqplot.enhancedLegendRenderer');
Yii::app()->clientScript->registerPackage('jqplot.cursor');

/*
 * ПЕРВЫЙ ГРАФИК
 */
// посылаем запрос в БД, который вернет количество заказов, сгруппированных по дням, начиная от текущей даты минус 2 месяца
$result = $db->createCommand("SELECT COUNT(DAY(Date)) AS COUNT, DAYOFMONTH(Date) AS DAY, MONTHNAME(Date) AS MONTH, DATE(Date) AS DAYDATE FROM Orders
					WHERE Date BETWEEN '{$startDate}' AND NOW()
					GROUP BY MONTH, DAY ORDER BY DAYDATE")->queryAll();
$max = 0;
$data = array();
for ($i = 0; $i < count($result); $i++) {
    // имея рассматриваемую дату и следующую в массиве, проверяем. если следующая дата $result[1]['DAYDATE']
    // вычисляем количество дней разницы между этими датами и пишем в массив нули по этим датам
    $next_cell = $i + 1;
    if (isset($result[$next_cell]['DAYDATE'])) {
        $datetime1 = date_create($result[$i]['DAYDATE']);
        $datetime2 = date_create($result[$next_cell]['DAYDATE']);
        $interval = date_diff($datetime1, $datetime2);
        $days_missing = $interval->format('%d');

        if ($days_missing >= 2) {
            $data[] = "['" . date("Y-m-d", strtotime('+1 day', strtotime($result[$i]['DAYDATE']))) . "', 0]";
            $data[] = "['" . date("Y-m-d", strtotime('-1 day', strtotime($result[$next_cell]['DAYDATE']))) . "', 0]";
        }
        $data[] = "['" . $result[$i]['DAYDATE'] . "', " . $result[$i]['COUNT'] . "]";
        if ($max < $result[$i]['COUNT'])
            $max = $result[$i]['COUNT'];
    } else {
        if ($max < $result[$i]['COUNT'])
            $max = $result[$i]['COUNT'];
        $data[] = "['" . $result[$i]['DAYDATE'] . "', " . $result[$i]['COUNT'] . "]";
    }
}
$strData = "[[" . implode(",", $data) . "]]";

if ($max % 2 == 1)
    $max += 1;
else
    $max += 2;

Yii::app()->clientScript->registerScript('graph', "
 $.jqplot(
 	'chartdiv',
 	" . $strData . ",
 	{
 		title:'Общая оценка производительности по дням недели',
 		animate: true,
        animateReplot: true,
   		axes:{
   			yaxis:{
   				min:0,
   				max:{$max},
   				label: 'Количество заказов',
   				labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
   				tickOptions:{formatString:'%d'},
   				tickInterval: 2,
   			},
   			xaxis:{
   				label: 'Дни недели',
   				renderer:$.jqplot.DateAxisRenderer,
   				tickOptions:{formatString:'%#d %b'},
   			},
   		}, 
   		cursor: {
			show: true,
			zoom: true,
			showTooltip: false,
		},
		seriesDefaults: {
          	rendererOptions: {
            	smooth: true
          	}
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


/*
 * ВТОРОЙ ГРАФИК
 */
$result2 = $db->createCommand("SELECT COUNT(DAY(Date)) AS COUNT, DAYOFMONTH(Date) AS DAY, MONTHNAME(Date) AS MONTH, DATE(Date) AS DAYDATE, EmployeeID,
		CONCAT(EmployeeSN, ' ', LEFT(EmployeeFN, 1), '.', LEFT(EmployeeP, 1), '.') as FIO  
		FROM Orders INNER JOIN Employees USING(EmployeeID) 
		WHERE Date BETWEEN '{$startDate}' AND NOW() 
		GROUP BY DAY, EmployeeID, MONTH ORDER BY EmployeeID, DAYDATE")->queryAll();

$sorted_employee_id = array();
$employee_fio = array();

for ($i = 0; $i < count($result2); $i++) {
    if (!array_key_exists($result2[$i]['EmployeeID'], $employee_fio))
        $employee_fio[$result2[$i]['EmployeeID']] = $result2[$i]['FIO'];

    if (array_key_exists($result2[$i]['EmployeeID'], $sorted_employee_id)) {
        $sorted_employee_id[$result2[$i]['EmployeeID']] .= ", ['" . $result2[$i]['DAYDATE'] . "', " . $result2[$i]['COUNT'] . "]";
    } else {
        $sorted_employee_id[$result2[$i]['EmployeeID']] = "['" . $result2[$i]['DAYDATE'] . "', " . $result2[$i]['COUNT'] . "]";
    }

    // необходимо отслеживать разницу в днях, только если в следующей ячейке тот же самый модельер
    $next_cell_2 = $i + 1;
    if (isset($result2[$next_cell_2]) && ($result2[$i]['EmployeeID'] == $result2[$next_cell_2]['EmployeeID'])) {
        $datetime1 = date_create($result2[$i]['DAYDATE']);
        $datetime2 = date_create($result2[$next_cell_2]['DAYDATE']);
        $interval2 = date_diff($datetime1, $datetime2);
        $days_missing_2 = $interval2->format('%d');
        if ($days_missing_2 >= 2) {
            $sorted_employee_id[$result2[$i]['EmployeeID']] .= ", ['" . date("Y-m-d", strtotime('+1 day', strtotime($result2[$i]['DAYDATE']))) . "', 0]";
            $sorted_employee_id[$result2[$i]['EmployeeID']] .= ", ['" . date("Y-m-d", strtotime('-1 day', strtotime($result2[$next_cell_2]['DAYDATE']))) . "', 0]";
        }
    } else {
        $days_missing_2 = 0;
    }
}

// ФИО модельеров для легенды
$legend = "";
foreach ($employee_fio as $value) {
    $legend .= "{label: '" . $value . "'},";
}

// подгоняем информацию под нужный формат jqplot
$data2 = "[";
foreach ($sorted_employee_id as $key => $value) {
    $data2 .= "[" . $value . "],";
}
$data2 .= "]";

$style = array(
    'diamond',
    'circle',
    'square',
    'x',
    'plus',
    'filledDiamond',
    'filledCircle',
    'filledSquare'
);

Yii::app()->clientScript->registerScript('graph2', "
 $.jqplot(
 	'chartdiv2',
 	" . $data2 . ",
 	{
 		title:'Оценка производительности модельеров по дням недели',
 		animate: true,
        animateReplot: true,
        axesDefaults: {
        	labelRenderer: $.jqplot.CanvasAxisLabelRenderer
      	},
 		legend: { 
 			show:true, 
 			location: 'nw',
 			renderer: $.jqplot.EnhancedLegendRenderer,
 			rendererOptions: {
                    numberRows: 2
                },
		},
   		axes:{  
   			yaxis:{
   				min:0,

   				label: 'Количество заказов',
   				labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
   				tickOptions:{formatString:'%d'},
   				tickInterval: 1,
   			},
   			xaxis:{
   				label: 'Дни недели',
   				renderer:$.jqplot.DateAxisRenderer,
   				tickOptions:{
   					formatString:'%#d %b', 
   				},
   			},
   		}, 
   		seriesDefaults: {
          	rendererOptions: {
            	smooth: true
          	},
          	markerOptions: {
                    style: '" . $style[rand(0, 7)] . "',
                    size: 8
                },
      	},
   		cursor: {
			show: true,
			zoom: true,
			showTooltip: false,
		},
		highlighter: {
			show: true,
			sizeAdjust: 10
		},
    	series:[
    		" . $legend . "
    		{showMarker:true},
   		]
 	}
 );
", CClientScript::POS_READY);


/*
 * ТРЕТИЙ ГРАФИК
 */
$result3 = $db->createCommand("SELECT COUNT(DAY(Date)) AS COUNT, CONCAT(EmployeeSN, ' ', LEFT(EmployeeFN, 1), '.', LEFT(EmployeeP, 1), '.') as FIO
		FROM Orders INNER JOIN Employees USING(EmployeeID) 
		WHERE Date BETWEEN '{$startDate}' AND NOW() GROUP BY EmployeeID")->queryAll();

foreach ($result3 as $key => $value) {
    $data3[] = "['" . $value['FIO'] . "', " . $value['COUNT'] . "]";
}

$strData3 = "[[" . implode(",", $data3) . "]]";

Yii::app()->clientScript->registerScript('graph3', "
$.jqplot(
  	'chartdiv3', 
  	" . $strData3 . ",
    { 
    	title:'Объем реализованных заказов по модельерам за последние 3 месяца',
      	seriesDefaults: {
        	renderer: $.jqplot.PieRenderer, 
        	rendererOptions: {
        		showDataLabels: true,
        		sliceMargin: 4, 
        		padding: 2
        	}
      	}, 
      	legend: { 
      		show:true, 
      		location: 'ne',
      		rendererOptions: {
                numberRows: 2,
            }, 
      	}
    }
);
", CClientScript::POS_READY);

Yii::app()->clientScript->registerScript('prepareDone', "
$(function(){
	$('#overlay').remove();
});
", CClientScript::POS_READY);
?>

<div id="chartdiv"></div>
<div id="chartdiv2" style="margin-top:40px"></div>
<div id="chartdiv3" style="margin-top:40px"></div>

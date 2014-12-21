<?php
/** @var $ordersPerDay OrdersPerDay */
/** @var $ordersPie EmployeesPieByOrders */
/** @var $employeesByOrdersPerDay EmployeesByOrdersPerDay */

$this->pageTitle = Yii::app()->name . ' - Статистика';

if (Order::hasOrders() == 0) {
    echo 'Заказов не обнаружено.';
    return;
}

$this->widget('ext.EmployeesOrdersWidget.EmployeesOrders', []);

$this->widget('ext.jqplot.JqplotGraphWidget', [
    'data' => $ordersPerDay->build(),
    'options' => [
        'seriesDefaults' => [
            'rendererOptions' => [
                'smooth' => true,
            ]
        ],
        'animate' => true,
        'animateReplot' => true,
        'title' => $ordersPerDay->getTitle(),
        'axes' => [
            'xaxis' => [
                'label' => 'Дни недели',
                'renderer' => 'js:$.jqplot.DateAxisRenderer',
                'tickOptions' => ['formatString' => '%#d %b'],
            ],
            'yaxis' => [
                'max' => $ordersPerDay->lineBuilder->getMax(),
                'numberTicks' => 6,
                'min' => 0,
                'label' => 'Количество заказов',
                'labelRenderer' => 'js:$.jqplot.CanvasAxisLabelRenderer',
                'tickOptions' => ['formatString' => '%d'],
                'tickInterval' => 2,
            ],
        ],
        'cursor' => [
            'renderer' => 'js:$.jqplot.Cursor',
            'show' => true,
            'zoom' => true,
            'showTooltip' => false,
        ],
        'highlighter' => [
            'renderer' => 'js:$.jqplot.highlighter',
            'show' => true,
            'sizeAdjust' => 10,
        ],
        'series' => [
            ['color' => '#509968',],
            ['showMarker' => true,]
        ],
    ],
    'pluginScriptFile' => [
        'jqplot.dateAxisRenderer.js',
        'jqplot.categoryAxisRenderer.js',
        'jqplot.canvasAxisLabelRenderer.js',
        'jqplot.cursor.js',
        'jqplot.highlighter.js',
        'jqplot.canvasTextRenderer.js',
    ],
]);

//echo '<pre>';
//print_r($employeesByOrdersPerDay->build());
//echo '</pre>';
//echo $employeesByOrdersPerDay->getMax();

print_r($employeesByOrdersPerDay->lineBuilder->getLegend());

// второй график
$this->widget('ext.jqplot.JqplotGraphWidget', [
    'data' => $employeesByOrdersPerDay->build(),
    'options' => [
        'seriesDefaults' => [
            'rendererOptions' => [
                'smooth' => true,
            ],
            'markerOptions' => [
                'style' => $employeesByOrdersPerDay->getStyle(),
                'size' => 8,
            ],
        ],
        'animate' => true,
        'animateReplot' => true,
        'title' => $employeesByOrdersPerDay->getTitle(),
//        'axesDefaults' => [
//            'labelRenderer' => 'js:$.jqplot.CanvasAxisLabelRenderer',
//      	],
        'legend' => [
            'show' => true,
            'location' => 'nw',
            'renderer' => 'js:$.jqplot.EnhancedLegendRenderer',
            'rendererOptions' => [
                'numberRows' => 2,
            ],
        ],
        'axes' => [
            'xaxis' => [
                'label' => 'Дни недели',
                'renderer' => 'js:$.jqplot.DateAxisRenderer',
                'tickOptions' => ['formatString' => '%#d %b'],
            ],
            'yaxis' => [
                'max' => $employeesByOrdersPerDay->lineBuilder->getMax(),
                'numberTicks' => 6,
                'min' => 0,
                'label' => 'Количество заказов',
                'labelRenderer' => 'js:$.jqplot.CanvasAxisLabelRenderer',
                'tickOptions' => ['formatString' => '%d'],
                'tickInterval' => 1,
            ],
        ],
        'cursor' => [
            'renderer' => 'js:$.jqplot.Cursor',
            'show' => true,
            'zoom' => true,
            'showTooltip' => false,
        ],
        'highlighter' => [
            'renderer' => 'js:$.jqplot.highlighter',
            'show' => true,
            'sizeAdjust' => 10,
        ],
        'series' => [
            ['color' => '#509968',],
            ['showMarker' => true,],
            ['legend' => $employeesByOrdersPerDay->lineBuilder->getLegend()],
        ],
    ],
    'pluginScriptFile' => [
        'jqplot.dateAxisRenderer.js',
        'jqplot.categoryAxisRenderer.js',
        'jqplot.canvasAxisLabelRenderer.js',
        'jqplot.cursor.js',
        'jqplot.highlighter.js',
        'jqplot.canvasTextRenderer.js',
//        'jqplot.EnhancedLegendRenderer',
    ],
]);


// третий график
$this->widget('ext.jqplot.JqplotGraphWidget', [
    'data' => $ordersPie->build(),
    'options' => [
        'seriesDefaults' => [
            'renderer' => 'js:$.jqplot.PieRenderer',
            'rendererOptions' => [
                'smooth' => true,
                'showDataLabels' => true,
                'sliceMargin' => 4,
                'padding' => 2
            ]
        ],
        'legend' => [
            'show' => 'true',
            'location' => 'ne',
            'rendererOptions' => [
                'numberRows' => 2,
            ],
        ],
        'title' => $ordersPie->getTitle(),
    ],
    'pluginScriptFile' => [
        'jqplot.pieRenderer.js',
    ],
]);



// ВТОРОЙ ГРАФИК
/*
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
            $sorted_employee_id[$result2[$i]['EmployeeID']] .= ", ['" . date("Y-m-d", strtotime(' + 1 day', strtotime($result2[$i]['DAYDATE']))) . "', 0]";
            $sorted_employee_id[$result2[$i]['EmployeeID']] .= ", ['" . date("Y-m-d", strtotime(' - 1 day', strtotime($result2[$next_cell_2]['DAYDATE']))) . "', 0]";
        }
    } else {
        $days_missing_2 = 0;
    }
}

// ФИО модельеров для легенды
$legend = "";
foreach ($employee_fio as $value) {
    $legend .= "{
    label:
    '" . $value . "'},";
}
*/

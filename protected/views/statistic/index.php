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
                'max' => $ordersPerDay->getMax(),
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
        'axesDefaults' => [
            'labelRenderer' => 'js:$.jqplot.CanvasAxisLabelRenderer',
        ],
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
                'max' => $employeesByOrdersPerDay->getMax(),
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
        'series' => $employeesByOrdersPerDay->getLegend(),
    ],
    'pluginScriptFile' => [
        'jqplot.dateAxisRenderer.js',
        'jqplot.categoryAxisRenderer.js',
        'jqplot.canvasAxisLabelRenderer.js',
        'jqplot.cursor.js',
        'jqplot.highlighter.js',
        'jqplot.canvasTextRenderer.js',
        'jqplot.enhancedLegendRenderer.min.js',
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

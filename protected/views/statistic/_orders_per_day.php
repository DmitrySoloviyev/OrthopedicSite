<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 28.02.15
 * Time: 23:12
 *
 * @var $ordersPerDay OrdersPerDay
 */

$this->widget('ext.jqplot.JqplotGraphWidget', [
    'id' => 'ordersPerDay',
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

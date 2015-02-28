<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 28.02.15
 * Time: 23:13
 *
 * @var $usersByOrdersPerDay UsersByOrdersPerDay
 */

$this->widget('ext.jqplot.JqplotGraphWidget', [
    'id' => 'usersByOrdersPerDay',
    'data' => $usersByOrdersPerDay->build(),
    'options' => [
        'seriesDefaults' => [
            'rendererOptions' => [
                'smooth' => true,
            ],
            'markerOptions' => [
                'style' => $usersByOrdersPerDay->getStyle(),
                'size' => 8,
            ],
        ],
        'animate' => true,
        'animateReplot' => true,
        'title' => $usersByOrdersPerDay->getTitle(),
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
                'max' => $usersByOrdersPerDay->getMax(),
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
        'series' => $usersByOrdersPerDay->getLegend(),
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

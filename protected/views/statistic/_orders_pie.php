<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 28.02.15
 * Time: 23:14
 *
 * @var $ordersPie UsersPieByOrders
 */

$this->widget('ext.jqplot.JqplotGraphWidget', [
    'id' => 'ordersPie',
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
            'show' => true,
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

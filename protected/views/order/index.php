<?php
$this->pageTitle = Yii::app()->name . ' - Все заказы';

$this->widget('bootstrap.widgets.TbBreadcrumb', [
    'links' => [
        'Все заказы',
    ],
]);

$this->widget('bootstrap.widgets.TbGridView', [
    'id' => 'order-grid',
    'type' => TbHtml::GRID_TYPE_STRIPED,
    'template' => "{summary}\n{pager}\n{items}\n{pager}",
    'dataProvider' => $order->search(),
    'pager' => [
        'class' => 'bootstrap.widgets.TbPager',
        'maxButtonCount' => 12,
        'pageSize' => 20,
        'htmlOptions' => [
            'align' => TbHtml::PAGINATION_ALIGN_CENTER
        ],
    ],
    'emptyText' => 'Нет записей',
    'ajaxUpdate' => true,
    'summaryText' => 'Показано {start} - {end} из {count} заказов.',
    'filter' => $order,
    'columns' => [
        'order_name',
        'model_id' => [
            'name' => 'model_id',
            'type' => 'raw',
            'value' => 'CHtml::link($data->model->name, ["model/view", "id" => $data->model->id], ["target" => "_blank"])',
        ],
        'sizes' => [
            'name' => 'sizes',
            'type' => 'html',
            'value' => '$data->sizesValues("<br>", "л", "п")',
        ],
        'urks' => [
            'name' => 'urks',
            'type' => 'html',
            'value' => '$data->urksValues("<br>", "л", "п")',
        ],
        'ordersMaterials' => [
            'name' => 'ordersMaterials',
            'type' => 'raw',
            'value' => '$data->materialsList()',
        ],
        'heights' => [
            'name' => 'heights',
            'type' => 'html',
            'value' => '$data->heightsValues("<br>", "л", "п")',
        ],
        'top_volumes' => [
            'name' => 'top_volumes',
            'type' => 'html',
            'value' => '$data->topVolumesValues("<br>", "л", "п")'
        ],
        'ankle_volumes' => [
            'name' => 'ankle_volumes',
            'type' => 'html',
            'value' => '$data->ankleVolumesValues("<br>", "л", "п")'
        ],
        'kv_volumes' => [
            'name' => 'kv_volumes',
            'type' => 'html',
            'value' => '$data->kvVolumesValues("<br>", "л", "п")'
        ],
        'customer_id' => [
            'name' => 'customer_id',
            'value' => '$data->customer->fullName()'
        ],
        'author_id' => [
            'name' => 'author_id',
            'value' => '$data->author->fullName()'
        ],
        'date_created' => [
            'name' => 'date_created',
            'value' => '$data->hiddmmyyyy($data->date_created)',
            'filter' => false,
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'header' => 'Действия',
            'template' => '{view} &nbsp; {update} &nbsp; {delete}',
        ],
    ],
]);

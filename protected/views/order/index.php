<?php
$this->pageTitle = Yii::app()->name . ' - Все заказы';

$this->widget('bootstrap.widgets.TbBreadcrumb', [
    'links' => [
        'Все заказы',
    ],
]);

$this->widget('bootstrap.widgets.TbGridView', [
    'id' => 'order-grid',
    'template' => "{summary}\n{pager}\n{items}\n{pager}",
    'dataProvider' => $order->search(),
    'emptyText' => 'Нет записей',
    'ajaxUpdate' => true,
    'itemsCssClass' => 'dboutput',
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
            'value' => '$data->size_left . " л<br>" . $data->size_right . " п"',
        ],
        'urks' => [
            'name' => 'urks',
            'type' => 'html',
            'value' => '$data->urk_left . " л<br>" . $data->urk_right . " п"',
        ],
        'material_id' => [
            'name' => 'material_id',
            'value' => '$data->material->title',
        ],
        'heights' => [
            'name' => 'heights',
            'type' => 'html',
            'value' => '$data->height_left . " л<br>" . $data->height_right . " п"'
        ],
        'top_volumes' => [
            'name' => 'top_volumes',
            'type' => 'html',
            'value' => '$data->top_volume_left . " л<br>" . $data->top_volume_right . " п"'
        ],
        'ankle_volumes' => [
            'name' => 'ankle_volumes',
            'type' => 'html',
            'value' => '$data->ankle_volume_left . "л<br>" . $data->ankle_volume_right . "п"'
        ],
        'kv_volumes' => [
            'name' => 'kv_volumes',
            'type' => 'html',
            'value' => '$data->kv_volume_left . "л<br>" . $data->kv_volume_right . "п"'
        ],
        'customer_id' => [
            'name' => 'customer_id',
            'value' => '$data->customer->fullName()'
        ],
        'user_id' => [
            'name' => 'user_id',
            'value' => '$data->user->fullName()'
        ],
        'date_created' => [
            'name' => 'date_created',
            'value' => 'date("H:i d.m.Y", strtotime($data->date_created))'
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'header' => 'Действия',
        ],
    ],
]);

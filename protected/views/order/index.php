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
            'value' => '$data->size_left . " л<br>" . $data->size_right . " п"',
        ],
        'urks' => [
            'name' => 'urks',
            'type' => 'html',
            'value' => '$data->urk_left . " л<br>" . $data->urk_right . " п"',
        ],
        'materials_ids' => [
            'name' => 'materials_ids',
            'type' => 'raw',
            'value' => '$data->materialsList()',
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
        'author_id' => [
            'name' => 'author_id',
            'value' => '$data->author->fullName()'
        ],
        'date_created' => [
            'name' => 'date_created',
            'value' => 'date("H:i d.m.Y", strtotime($data->date_created))',
            'filter' => false,
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'header' => 'Действия',
        ],
    ],
]);

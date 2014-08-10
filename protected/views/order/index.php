<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'order-grid',
    'template' => "{pager}\n{items}\n{pager}",
    'dataProvider' => $order->search(),
    'emptyText' => 'Нет записей',
    'ajaxUpdate' => true,
    'itemsCssClass' => 'dboutput',
    'summaryText' => 'Показано {start} - {end} из {count} заказов.',
    'filter' => $order,
    'columns' => [
        'order_id',
        'model_id' => [
            'name' => 'model_id',
            'value' => '$data->model->name',
        ],
        'sizes' => [
            'name' => 'sizes',
            'type' => 'html',
            'value' => '$data->sizeLeft->size . " л<br>" . $data->sizeRight->size . " п"',
        ],
        'urks' => [
            'name' => 'urks',
            'type' => 'html',
            'value' => '$data->urkLeft->urk . " л<br>" . $data->urkRight->urk . " п"',
        ],
        'material_id' => [
            'name' => 'material_id',
            'value' => '$data->material->material_name',
        ],
        'heights' => [
            'name' => 'heights',
            'type' => 'html',
            'value' => '$data->heightLeft->height . " л<br>" . $data->heightRight->height . " п"'
        ],
        'top_volumes' => [
            'name' => 'top_volumes',
            'type' => 'html',
            'value' => '$data->topVolumeLeft->volume . " л<br>" . $data->topVolumeRight->volume . " п"'
        ],
        'ankle_volumes' => [
            'name' => 'ankle_volumes',
            'type' => 'html',
            'value' => '$data->ankleVolumeLeft->volume . "л<br>" . $data->ankleVolumeRight->volume . "п"'
        ],
        'kv_volumes' => [
            'name' => 'kv_volumes',
            'type' => 'html',
            'value' => '$data->kvVolumeLeft->volume . "л<br>" . $data->kvVolumeRight->volume . "п"'
        ],
        'customer_id' => [
            'name' => 'customer_id',
            'value' => '$data->customer->fullName()'
        ],
        'employee_id' => [
            'name' => 'employee_id',
            'value' => '$data->employee->fullName()'
        ],
        'date_created' => [
            'name' => 'date_created',
            'value' => 'date("H:i d.m.Y", strtotime($data->date_created))'
        ],
        [
            'class' => 'CButtonColumn',
            'header' => 'Действия',
        ],
    ],
]);

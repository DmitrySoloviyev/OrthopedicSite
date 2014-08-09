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
        'size_left_id' => [
            'name' => 'size_left_id',
            'type' => 'html',
            'value' => '$data->sizeLeft->size . "л<br>" . $data->sizeRight->size . "п"',
        ],
        'urk_left_id' => [
            'name' => 'urk_left_id',
            'type' => 'html',
            'value' => '$data->urkLeft->urk . "л<br>" . $data->urkRight->urk . "п"'
        ],
        'material_id' => [
            'name' => 'size_left_id',
            'value' => '$data->material->material',
        ],
        'height_left_id' => [
            'name' => 'height_left_id',
            'type' => 'html',
            'value' => '$data->heightLeft->height . "л<br>" . $data->heightRight->height . "п"'
        ],
        'top_volume_left_id' => [
            'name' => 'top_volume_left_id',
            'type' => 'html',
            'value' => '$data->topVolumeLeft->volume . "л<br>" . $data->topVolumeRight->volume . "п"'
        ],
        'ankle_volume_left_id' => [
            'name' => 'ankle_volume_left_id',
            'type' => 'html',
            'value' => '$data->ankleVolumeLeft->volume . "л<br>" . $data->ankleVolumeRight->volume . "п"'
        ],
        'kv_volume_left_id' => [
            'name' => 'kv_volume_left_id',
            'type' => 'html',
            'value' => '$data->kvVolumeLeft->volume . "л<br>" . $data->kvVolumeRight->volume . "п"'
        ],
        'customer_id' => [
            'name' => 'customer_id',
            'type' => 'html',
            'value' => '$data->customer->fullName()'
        ],
        'employee_id' => [
            'name' => 'employee_id',
            'type' => 'html',
            'value' => '$data->employee->fullName()'
        ],
        'date_created',
        [
            'class' => 'CButtonColumn',
        ],
    ],
]);

<?php //$sort = $dataProvider->getSort(); ?>
    <!--<table cols='14' border='2' class='dboutput'>-->
    <!--    <tr>-->
    <!--        <th>--><? //= $sort->link('order_id', '№ заказа', ['class' => 'sorter_link']); ?><!--</th>-->
    <!--        <th>--><? //= $sort->link('model_id', 'Модель', ['class' => 'sorter_link']); ?><!--</th>-->
    <!--        <th>Размер</th>-->
    <!--        <th>Длина УРК</th>-->
    <!--        <th>--><? //= $sort->link('material_id', 'Материал', ['class' => 'sorter_link']); ?><!--</th>-->
    <!--        <th>Высота</th>-->
    <!--        <th>Объем верха</th>-->
    <!--        <th>Объем лодыжки</th>-->
    <!--        <th>Объем КВ</th>-->
    <!--        <th>Заказчик</th>-->
    <!--        <th>--><? //= $sort->link('employee_id', 'Модельер', ['class' => 'sorter_link']); ?><!--</th>-->
    <!--        <th>--><? //= $sort->link('date_created', 'Дата заказа', ['class' => 'sorter_link']); ?><!--</th>-->
    <!--        <th width="110px">Комментарий</th>-->
    <!--        --><?php //if (!Yii::app()->user->isGuest): ?>
    <!--            <th>Правка</th>-->
    <!--            <th>Удалить</th>-->
    <!--        --><?php //endif; ?>
    <!--    </tr>-->
    <!--    --><?php //$this->widget('zii.widgets.CListView', [
//        'dataProvider' => $dataProvider,
//        'itemView' => '_view',
//        'emptyText' => 'Нет записей',
//        'ajaxUpdate' => true,
//        'summaryText' => 'Показано {start} - {end} из {count} заказов.',
//    ]);
?>
    <!--</table>-->


<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'order-grid',
//    'htmlOptions' => ['class' => 'dboutput'],
    'template' => "{pager}\n{items}\n{pager}",
    'dataProvider' => $order->search(),
    'emptyText' => 'Нет записей',
    'ajaxUpdate' => true,
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
]); ?>
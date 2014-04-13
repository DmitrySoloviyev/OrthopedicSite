<?php $sort = $dataProvider->getSort(); ?>
<table cols='14' border='2' class='dboutput'>
    <tr>
        <th><?= $sort->link('order_id', '№ заказа', ['class' => 'sorter_link']); ?></th>
        <th><?= $sort->link('model_id', 'Модель', ['class' => 'sorter_link']); ?></th>
        <th>Размер</th>
        <th>Длина УРК</th>
        <th><?= $sort->link('material_id', 'Материал', ['class' => 'sorter_link']); ?></th>
        <th>Высота</th>
        <th>Объем верха</th>
        <th>Объем лодыжки</th>
        <th>Объем КВ</th>
        <th>Заказчик</th>
        <th><?= $sort->link('employee_id', 'Модельер', ['class' => 'sorter_link']); ?></th>
        <th><?= $sort->link('date_created', 'Дата заказа', ['class' => 'sorter_link']); ?></th>
        <th width="110px">Комментарий</th>
        <?php if (!Yii::app()->user->isGuest): ?>
            <th>Правка</th>
            <th>Удалить</th>
        <?php endif; ?>
    </tr>
    <?php $this->widget('zii.widgets.CListView', [
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
        'emptyText' => 'Нет записей',
        'ajaxUpdate' => true,
        'summaryText' => 'Показано {start} - {end} из {count} заказов.',
    ]);?>
</table>

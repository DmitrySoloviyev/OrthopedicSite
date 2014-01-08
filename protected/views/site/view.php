<?php $sort=$dataProvider->getSort();?>
<table cols='14' border='2' class='dboutput'>
	<tr>
		<th><?=$sort->link('OrderID', '№ заказа', array('class'=>'sorter_link'));?></th>
	    <th><?=$sort->link('ModelName', 'Модель', array('class'=>'sorter_link'));?></th>
	    <th>Размер</th>
	    <th>Длина УРК</th>
	    <th><?=$sort->link('MaterialValue', 'Материал', array('class'=>'sorter_link'));?></th>
	    <th>Высота</th>
	    <th>Объем верха</th>
	    <th>Объем лодыжки</th>
	    <th>Объем КВ</th>
	    <th>Заказчик</th>
	    <th><?=$sort->link('EmployeeSN', 'Модельер', array('class'=>'sorter_link'));?></th>
	    <th><?=$sort->link('Date', 'Дата заказа', array('class'=>'sorter_link'));?></th>
	    <th width="110px">Комментарий</th>
	    <th>Правка</th>
	    <th>Удалить</th>
	</tr>
<?php
$this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
	'emptyText' => 'Нет записей',
	'ajaxUpdate'=>true,
	'summaryText'=>'Показано {start} - {end} из {count} заказов.',
));
?>
</table>
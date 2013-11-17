<table cols='14' border='2' class='dboutput'>
	    <tr>
	      <th>№ заказа</th>
	      <th>Модель</th>
	      <th>Размер</th>
	      <th>Длина УРК</th>
	      <th>Материал</th>
	      <th>Высота</th>
	      <th>Объем верха</th>
	      <th>Объем лодыжки</th>
	      <th>Объем КВ</th>
	      <th>Заказчик</th>
	      <th>Модельер</th>
	      <th>Дата заказа</th>
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
	'sortableAttributes'=>array('OrderID', 'ModelName', 'Date'),
	'summaryText'=>'Показано {start} - {end} из {count} заказов',
	'sorterHeader'=>'Сортировать по: ',
));
?>
</table>
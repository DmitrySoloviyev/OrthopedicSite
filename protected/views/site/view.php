<?php Yii::app()->clientScript->registerScript('showQuickSearchBtn',"
	$('#quickSearch').attr('disabled', 'disabled');
	$('#quickSearchVal').change(function(e){
		var query = $('#quickSearchVal').val();
		if( query != '')
			$('#quickSearch').removeAttr('disabled');
	});
", CClientScript::POS_READY);
?>

<div class="form" style="margin:0 100px 4px 100px">
	<?php $form=$this->beginWidget('CActiveForm', array('method'=>'GET')); ?>
		<fieldset style="margin:0 auto">
			<input type="text" id='quickSearchVal' name="quickSearchValue" autocomplete='Off' placeholder='Поиск по ключевому слову' style="width:78%;" />
			<?php echo CHtml::submitButton('Поиск', array('name'=>'quickSearch', 'id'=>'quickSearch', 'style'=>'width:20%;')); ?>
		</fieldset>
	<?php $this->endWidget(); ?>
</div>

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
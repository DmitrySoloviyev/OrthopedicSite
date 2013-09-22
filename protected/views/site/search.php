<?php $this->pageTitle=Yii::app()->name . ' - Поиск';

Yii::app()->clientScript->registerScript('search',"

var Models = null;
var currentModel = 0;


$('#Models_ModelName').change(function(e){
    var modelName = $(this).val();
    if(modelName != ''){
    	getAllModelsInfo();
    }
});

$('#Models_ModelName').change(function(e){
    var modelName = $(this).val();
	getModelInfo();
});

function getModelInfo(){
	var modelName = $('#Models_ModelName').val();
	//пытаемся загрузить указанную модель, если ее не существует, отмечаем флажок и грузим форму создания новой модели
	$.post('".$this->createUrl('/site/GetModelInfo')."', {modelName:modelName}, function(data){
		var info = $.parseJSON(data);
			Models = info;
			$('#Models_ModelPicture').attr('src', '../../'+info[0].ModelPicture);
			$('#pic').attr('href', '../../'+info[0].ModelPicture);
			$('#Models_ModelDescription').val(info[0].ModelDescription);
			$('#modelNameTitle').text('Модель № ' + info[0].ModelName);
			$('#Models_DateModified').text('Дата изменения: ' + info[0].DateModified);
    });
}

//обрабатываем нажатие на флажок
$('#showAllModels').click(function() {
	if( $(this).is(':checked') ){
		getAllModelsInfo();
	}else{
		$('#Models_ModelName').val();
	}
});

//функция вывода информации о модели
function getAllModelsInfo(){
	var modelName = $('#Models_ModelName').val();

	$.post('".$this->createUrl('/site/GetAllModelsInfo')."', {}, function(data){
		var info = $.parseJSON(data);
		Models = info;
		$('#Models_ModelName').val(info[0].ModelName);
		$('#Models_ModelPicture').attr('src', info[0].ModelPicture);
		$('#pic').attr('href', '../../'+info[0].ModelPicture);
		$('#Models_ModelDescription').append(info[0].ModelDescription);
		$('#modelNameTitle').text('Модель № ' + info[0].ModelName);
		$('#Models_DateModified').text('Дата изменения: ' + info[0].DateModified);
    });
}

//кнопка ДАЛЕЕ
$('#next').click(function(e){
    $('#ModelForm').hide('drop', {direction: 'left'}, 300);

	    if(Models != null && Models.length > 1)
	    {
	    	if(currentModel < Models.length-1){
	    		currentModel++;

	    		$('#Models_ModelName').val(Models[currentModel].ModelName);
				$('#Models_ModelPicture').attr('src', Models[currentModel].ModelPicture);
				$('#pic').attr('href', '../../'+Models[currentModel].ModelPicture);
				$('#Models_ModelDescription').text(Models[currentModel].ModelDescription);
				$('#modelNameTitle').text('Модель № ' + Models[currentModel].ModelName);
				$('#Models_DateModified').text('Дата изменения: ' + Models[currentModel].DateModified);
			}
	    }

    $('#ModelForm').show('drop', {direction: 'right'}, 300);
    e.preventDefault;
});
  
//кнопка НАЗАД
$('#previous').click(function(e){

	$('#ModelForm').hide('drop', {direction: 'right'}, 300);

		if(Models != null && Models.length > 1)
	    {
	    	if(currentModel != 0)
	    		--currentModel;
	    	else
	    		currentModel=0;

	    		$('#Models_ModelName').val(Models[currentModel].ModelName);
				$('#Models_ModelPicture').attr('src', Models[currentModel].ModelPicture);
				$('#pic').attr('href', '../../'+Models[currentModel].ModelPicture);
				$('#Models_ModelDescription').text(Models[currentModel].ModelDescription);
				$('#modelNameTitle').text('Модель № ' + Models[currentModel].ModelName);
				$('#Models_DateModified').text('Дата изменения: ' + Models[currentModel].DateModified);
	    }

    $('#ModelForm').show('drop', {direction: 'left'}, 300);
    e.preventDefault;
});

$('#ModelForm').draggable({
    delay:150,
    start:function(){
	    $(this).css('opacity', 0.6).css('cursor','move')
	  },
    stop:function(){
	    $(this).css('opacity', '').css('cursor','')
	  }
});

$('#close_ModelForm').click(function(e){
    $('#ModelForm').animate({opacity: 0.0}, 400);
    return false;
});

$('#hint').hide().delay(1000).slideDown(500).delay(2000).fadeOut(2000);
", CClientScript::POS_READY);
?>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('error')):?>
    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>

<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'orders-new-form',
		'enableClientValidation'=>false,
		'clientOptions'=>array('validateOnSubmit'=>false),
	)); ?>
	<fieldset>
	<legend style="margin-left:60px;">Поиск</legend>
	<?php echo $form->errorSummary($model); ?>
	<table>
	    <tr>
			<td style="width:160px">№ заказа:</td>
			<td style="width:330px">
				<div class="row">
					<?php 
						echo $form->TextField($model,'OrderID', array('autocomplete'=>'Off')); 
						echo $form->error($model,'OrderID'); ?>
				</div>
			</td>
	    	<td id="ModelForm" rowspan="10">
	    		<a href="#" id="close_ModelForm"></a>
	    		<fieldset>
	    		<legend style="margin-left:30px;">Модель</legend>
	    			<table>
	    				<tr>
	    					<td colspan="2" style="font-style: normal; font-size: 1em; text-align:center">
	    						<span id="previous"><img src="/images/previous.png" /></span>
	    						<span id="modelNameTitle">Модель №</span>
    							<span id="next"><img src="/images/next.png" /></span><hr />
	    					</td>
	    				</tr>
	    				<tr>
	    					<td colspan="2"><span id="pic"><img id='Models_ModelPicture' src=<?php echo "'".$modelsModel->ModelPicture."'";?> alt='изображение модели' width="200" height="200" /></span></td>
	    				</tr>
	    				<tr>
	    					<td>Описание: </td>
	    					<td id='Models_ModelDescription'><?php echo CHtml::encode($modelsModel->ModelDescription); ?></td>
	    				</tr>
	    				<tr>
	    					<td colspan="2" id='Models_DateModified'>Дата изменения: <?php echo CHtml::encode($modelsModel->DateModified);?></td>
	    				</tr>
	    			</table>
	    		</fieldset>
	    	</td>
	    </tr>
	    <tr>
			<td>Модель:</td>
			<td>
				<div class="row">
				<?php $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
					'model'=>$modelsModel,
					'attribute'=>'ModelName',
					'name'=>'ModelName',
					'source'=>$this->createUrl("/site/GetModelNames"),
					'options'=>array(
						'minLength'=>'1',
						'select'=>new CJavaScriptExpression('function(event,ui) {
							$("#Models_ModelName").val(ui.item.label).change();
							return false;
						}')
					),
					'htmlOptions'=>array(
						'id'=>CHtml::activeId($modelsModel,'ModelName'),
						'autocomplete'=>'Off',
						'maxlength'=>'6'
					),
				)); 
				echo "<br /><input type='checkbox' id='showAllModels'/><label for='showAllModels'>Показать все модели</label>";
				echo $form->error($modelsModel,'ModelName');
				$this->widget('ext.fancybox.EFancyBox',array(    
					 	'target'=>'#pic',
				        'config'=>array(
				            'enableEscapeButton'=>true,
				        ),
				));
				?>
				</div>
			</td>
	    </tr>
	    <tr>
			<td>Размер:</td>
			<td>
				<div class="row">
				<?php 
					echo $form->TextField($model,'Size', array('autocomplete'=>'Off')); 
					echo $form->error($model,'Size');?>
				</div>
			</td>
	    </tr>
	    <tr>
			<td>УРК:</td>
			<td>
				<div class="row">
				<?php 
					echo $form->TextField($model,'Urk', array('autocomplete'=>'Off')); 
					echo $form->error($model,'Urk');?>
				</div>
			</td>
	    </tr>
	    <tr>
			<td>Материал:</td>
			<td>
				<div class="row">
				<?php 
					echo $form->checkBoxList($materialsModel, 'MaterialID', $materialsModel->getMaterialsList()); 
					echo $form->error($materialsModel,'MaterialID');?>
				</div>
			</td>
	    </tr>
	    <tr>
			<td>Высота:</td>
			<td>
				<div class="row">
				<?php 
					echo $form->TextField($model,'Height', array('autocomplete'=>'Off')); 
					echo $form->error($model,'Height');?>
				</div>
			</td>
	    </tr>
	    <tr>
			<td>Объем верха:</td>
			<td>
				<div class="row">
				<?php 
					echo $form->TextField($model,'TopVolume', array('autocomplete'=>'Off')); 
					echo $form->error($model,'TopVolume');?>
				</div>
			</td>
	    </tr>
	    <tr>
			<td>Объем лодыжки:</td>
			<td>
				<div class="row">
				<?php 
					echo $form->TextField($model,'AnkleVolume', array('autocomplete'=>'Off')); 
					echo $form->error($model,'AnkleVolume');?>
				</div>
			</td>
	    </tr>
	    <tr>
			<td title="косого взъема">Объем КВ:</td>
			<td>
				<div class="row">
				<?php 
					echo $form->TextField($model,'KvVolume', array('autocomplete'=>'Off')); 
					echo $form->error($model,'KvVolume');?>
				</div>
			</td>
	    </tr>
	    <tr>
	    	<td colspan="2">
			Заказчик:
				<div style="margin-left:60px">
					<div class="row">
						<?php 
						echo $form->TextField($customersModel,'CustomerSN', array('autocomplete'=>'Off', 'placeholder'=>'Фамилия')); 
						echo $form->error($customersModel,'CustomerSN');?>
					</div>
					<div class="row">
						<?php 
						echo $form->TextField($customersModel,'CustomerFN', array('autocomplete'=>'Off', 'placeholder'=>'Имя')); 
						echo $form->error($customersModel,'CustomerFN');?>
					</div>
					<div class="row">
						<?php 
						echo $form->TextField($customersModel,'CustomerP', array('autocomplete'=>'Off', 'placeholder'=>'Отчество')); 
						echo $form->error($customersModel,'CustomerP');?>
					</div>
				</div>
			</td>
	    </tr>
	    <tr>
			<td>Модельер:</td>
			<td>
				<div class="row">
				<?php 
					echo $form->checkBoxList($employeesModel, 'EmployeeID', $employeesModel->getEmployeeList()); 
					echo $form->error($employeesModel,'EmployeeID');?>
				</div>
			</td>
	    </tr>
	    <tr>
			<td>Комментарий:</td>
			<td><?php echo $form->TextField($model,'Comment'); ?></td>
	    </tr>
	    <tr>
			<td colspan="3">
		    	<div class="row submit">
					<?php echo CHtml::submitButton('Искать', array('class'=>'button')); ?>
				</div>
			</td>
	    </tr>
	</table>
	</fieldset>
	<?php $this->endWidget(); ?>
</div><!-- form -->

<div id="hint">
  <i>Поля, оставленные пустыми,<br /> участвовать в поиске не будут.<br />
    Для задания диапазона используйте тире "-". Отделяйте каждое значение и диапазон пробелом.
  </i>
</div>


<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
?>
<p><h2 align='center'>Результаты поиска:</h2></p>
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
//	'sortableAttributes'=>array('OrderID', 'modelName'),
	'summaryText'=>'Показано {start} - {end} из {count} заказов',
//	'sorterHeader'=>'Сортировать по: ',
));
?>
</table>
<?php } ?>
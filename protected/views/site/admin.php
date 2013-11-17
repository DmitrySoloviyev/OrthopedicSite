<?php
if(Yii::app()->user->isGuest){
	header("Location: index.php");
	exit();
}
$this->pageTitle=Yii::app()->name . ' - Администрирование';
Yii::app()->clientScript->registerPackage('jquery.ui');
Yii::app()->clientScript->registerScript('datePicker',"

	$.datepicker.regional['ru'] = {
        closeText: 'Закрыть',
        prevText: '&#x3c;Пред',
        nextText: 'След&#x3e;',
		currentText: 'Сегодня',
		monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
		'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
		monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
		'Июл','Авг','Сен','Окт','Ноя','Дек'],
		dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
		dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
		dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
		weekHeader: 'Не',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};

	$.datepicker.setDefaults(
		$.extend($.datepicker.regional['ru'])
	);
	$('#startDate').datepicker({
		firstDay:1,
		showAnim: 'blind',
		maxDate: '+0d'
	});
	$('#endDate').datepicker({
		firstDay:1,
		showAnim: 'blind',
		maxDate: '+0d'
	});
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


	<div class="form" style="float:left; width:50%; ">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'employee-delete-form',
			'enableClientValidation'=>true,
			'clientOptions'=>array('validateOnSubmit'=>true),
			'htmlOptions'=>array('style'=>'margin:10px'),
		)); ?>
		<fieldset>
			<legend style="margin-left:60px;">Удалить модельера</legend>
			<div class="row">
				<?php 
					echo $form->dropDownList($employeesModel, 'EmployeeID', $employeesModel->getEmployeeList(), array('empty' => 'Ф.И.О Модельера', 'style'=>'width:204px'));
					echo $form->error($employeesModel,'EmployeeID');?>
			</div>
		   	<div class="row submit">
				<?php echo CHtml::submitButton('Удалить', array('class'=>'button')); ?>
			</div>
		</fieldset>
		<?php $this->endWidget(); ?>
	</div><!-- form -->


	<div class="form" style="float:right; width:50%; ">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'optimize-db-form',
			'htmlOptions'=>array('style'=>'margin:10px'),
		)); ?>
		<fieldset>
			<legend style="margin-left:60px;">Оптимизация</legend>
			<div class="row" style="margin-bottom:15px">
				Оптимизировать Базу Данных
			</div>
		   	<div class="row submit">
				<?php echo CHtml::submitButton('Оптимизировать', array('class'=>'button', 'name'=>'optimizeDbBtn')); ?>
			</div>
		</fieldset>
		<?php $this->endWidget(); ?>
	</div><!-- form -->

	<div class="clear"></div>

	<div class="form" style="float:left; width:50%; ">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'backup-db-form',
			'enableClientValidation'=>true,
			'clientOptions'=>array('validateOnSubmit'=>true),
			'htmlOptions'=>array('style'=>'margin:10px'),
		)); ?>
		<fieldset>
			<legend style="margin-left:60px;">Резервирование</legend>
			<div class="row" style="margin-bottom:15px">
				Создать резервную копию БД
			</div>
		   	<div class="row submit">
				<?php echo CHtml::submitButton('Создать', array('class'=>'button', 'name'=>'backupDbBtn')); ?>
			</div>
		</fieldset>
		<?php $this->endWidget(); ?>
	</div><!-- form -->


	<div class="form" style="float:right; width:50%; ">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'recovery-db-form',
			'htmlOptions' => array(
				'enctype' => 'multipart/form-data',
				'style'=>'margin:10px',
			),
		)); ?>
		<fieldset>
			<legend style="margin-left:60px;">Восстановить БД</legend>
			<div class="row">
				<?php echo CHtml::fileField('recoveryDb', ''); ?>
			</div>
		   	<div class="row submit">
				<?php echo CHtml::submitButton('Восстановить', array('class'=>'button', 'name'=>'recoveryDbBtn')); ?>
			</div>
		</fieldset>
		<?php $this->endWidget(); ?>
	</div><!-- form -->

	<div class="clear"></div>

	<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'htmlOptions'=>array('style'=>'margin:10px'),
		)); ?>
		<fieldset>
			<legend style="margin-left:60px;">Отчет за период</legend>
			<input type="text" name="startDate" id="startDate" required autocomplete="Off" placeholder="дд.мм.гггг" /> 
			&nbsp;&mdash;&nbsp; 
			<input type="text" id="endDate" name="endDate" required autocomplete="Off" placeholder="дд.мм.гггг" />
			<div class="row submit">
				<?php echo CHtml::submitButton('Сохранить в Excel', array('class'=>'button', 'name'=>'saveAsExcel')); ?>
			</div>
		</fieldset>
		<?php $this->endWidget(); ?>
	</div>
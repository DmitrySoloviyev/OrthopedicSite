<?php
$this->pageTitle=Yii::app()->name . ' - Администрирование';
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
			'id'=>'employee-delete-form',
			'enableClientValidation'=>true,
			'clientOptions'=>array('validateOnSubmit'=>true),
		)); ?>
		<fieldset>
		<legend style="margin-left:60px;">Удалить модельера</legend>


			<div class="row">
				<?php 
					echo $form->dropDownList($employeesModel, 'EmployeeID', $employeesModel->getEmployeeList(), array('empty' => 'Ф.И.О Модельера'));
					echo $form->error($employeesModel,'EmployeeID');?>
			</div>
		   	<div class="row submit">
				<?php echo CHtml::submitButton('Удалить', array('class'=>'button')); ?>
			</div>
		</fieldset>
		<?php $this->endWidget(); ?>
	</div><!-- form -->


	<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'optimize-db-form',
		)); ?>
		<fieldset>
		<legend style="margin-left:60px;">Оптимизация</legend>
			<div class="row">
				Оптимизировать Базу Данных
			</div>
		   	<div class="row submit">
		   		<?php //echo $form->fileField('', 'loadImage', array('style'=>'width:114px'));?>
				<?php echo CHtml::submitButton('Оптимизировать', array('class'=>'button', 'name'=>'optimizeDbBtn')); ?>
			</div>
		</fieldset>
		<?php $this->endWidget(); ?>
	</div><!-- form -->


	<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'backup-db-form',
			'enableClientValidation'=>true,
			'clientOptions'=>array('validateOnSubmit'=>true),
		)); ?>
		<fieldset>
		<legend style="margin-left:60px;">Резервирование</legend>
			<div class="row">
				Создать резервную копию БД
			</div>
		   	<div class="row submit">
				<?php echo CHtml::submitButton('Создать', array('class'=>'button', 'name'=>'backupDbBtn')); ?>
			</div>
		</fieldset>
		<?php $this->endWidget(); ?>
	</div><!-- form -->


	<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'recovery-db-form',
			'htmlOptions' => array('enctype' => 'multipart/form-data'),
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
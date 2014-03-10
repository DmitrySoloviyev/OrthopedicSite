<?php
if (Yii::app()->user->isGuest) {
    $this->redirect(['site/login']);
    Yii::app()->end();
}
$this->pageTitle = Yii::app()->name . ' - Администрирование';
?>

<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<?php if (Yii::app()->user->hasFlash('error')): ?>
    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>


<div class="form" style="float:left; width:50%; ">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'employee-delete-form',
        'enableClientValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true),
        'htmlOptions' => array('style' => 'margin:10px'),
    )); ?>
    <fieldset>
        <legend style="margin-left:60px;">Удалить модельера</legend>
        <div class="row">
            <?php
            echo $form->dropDownList($employeesModel, 'EmployeeID', $employeesModel->getEmployeeList(), array(
                'empty' => 'Ф.И.О Модельера',
                'style' => 'width:204px'
            ));
            echo $form->error($employeesModel, 'EmployeeID');?>
        </div>
        <div class="row submit">
            <?php echo CHtml::submitButton('Удалить', array('class' => 'button')); ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div><!-- form -->


<div class="form" style="float:right; width:50%; ">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'optimize-db-form',
        'htmlOptions' => array('style' => 'margin:10px'),
    )); ?>
    <fieldset>
        <legend style="margin-left:60px;">Оптимизация</legend>
        <div class="row" style="margin-bottom:21px">
            Оптимизировать Базу Данных
        </div>
        <div class="row submit">
            <?php echo CHtml::submitButton('Оптимизировать', array('class' => 'button', 'name' => 'optimizeDbBtn')); ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div><!-- form -->

<div class="clear"></div>

<div class="form" style="float:left; width:50%; ">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'backup-db-form',
        'enableClientValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true),
        'htmlOptions' => array('style' => 'margin:10px'),
    )); ?>
    <fieldset>
        <legend style="margin-left:60px;">Резервирование</legend>
        <div class="row" style="margin-bottom:25px">
            Создать резервную копию БД
        </div>
        <div class="row submit">
            <?php echo CHtml::submitButton('Создать', array('class' => 'button', 'name' => 'backupDbBtn')); ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div><!-- form -->


<div class="form" style="float:right; width:50%; ">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'recovery-db-form',
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data',
            'style' => 'margin:10px',
        ),
    )); ?>
    <fieldset>
        <legend style="margin-left:60px;">Восстановить БД</legend>
        <div class="row">
            <?php echo CHtml::fileField('recoveryDb', ''); ?>
        </div>
        <div class="row submit">
            <?php echo CHtml::submitButton('Восстановить', array('class' => 'button', 'name' => 'recoveryDbBtn')); ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div><!-- form -->

<div class="clear"></div>

<div class="form" style="float:left; width:50%;">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'htmlOptions' => array('style' => 'margin:10px'),
    )); ?>
    <fieldset>
        <legend style="margin-left:60px;">Отчет за период</legend>
        <div class="row">
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', [
                'name' => 'startDate',
                'attribute' => 'startDate',
            ]);?>
            &nbsp;&mdash;&nbsp;
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', [
                'name' => 'endDate',
                'attribute' => 'endDate',
            ]);?>
        </div>
        <div class="row submit">
            <?php echo CHtml::submitButton('Сохранить в Excel', array('class' => 'button', 'name' => 'saveAsExcel')); ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>

<!-- Новый материал -->
<div class="form" style="float:right; width:50%; ">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'create-new-material-form',
        'enableClientValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true),
        'htmlOptions' => array(
            'style' => 'margin:10px',
        ),
    )); ?>
    <fieldset>
        <legend style="margin-left:60px;">Новый материал</legend>
        <div class="row">
            <?php
            echo $form->TextField($materialsModel, 'MaterialValue', array(
                'autocomplete' => 'Off',
                'placeholder' => 'Название материала',
                'class' => 'input_text'
            ));
            echo $form->error($materialsModel, 'MaterialValue');
            ?>
        </div>
        <div class="row submit">
            <?php echo CHtml::submitButton('Создать', array('class' => 'button', 'name' => 'newMaterialBtn')); ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div><!-- form -->

<div class="clear"></div>

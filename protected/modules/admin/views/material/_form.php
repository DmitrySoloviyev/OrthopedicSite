<?php
/* @var $this MaterialController */
/* @var $model Material */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'material-form',
        'enableAjaxValidation' => false,
    ]); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->labelEx($model, 'material_name'); ?>
    <?= $form->textField($model, 'material_name', [
        'size' => 30,
        'maxlength' => 30,
        'placeholder' => $model->getAttributeLabel('material_name'),
        'autocomplete' => 'off',
    ]); ?>

    <div class="buttons">
        <?= CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-primary']); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>

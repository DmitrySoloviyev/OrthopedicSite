<?php
/* @var $this ModelController */
/* @var $model Models */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'models-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->labelEx($model, 'name'); ?>
    <?= $form->textField($model, 'name', ['size' => 30, 'maxlength' => 6]); ?>
    <?= $form->error($model, 'name'); ?>

    <?= $form->labelEx($model, 'description'); ?>
    <?= $form->textArea($model, 'description', ['size' => 60, 'maxlength' => 255]); ?>
    <?= $form->error($model, 'description'); ?>

    <?= $form->labelEx($model, 'picture'); ?>
    <?= $form->fileField($model, 'picture'); ?>
    <?= $form->error($model, 'picture'); ?>

    <div class="buttons">
        <?= CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>

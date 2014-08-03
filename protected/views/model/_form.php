<?php
/* @var $this ModelController */
/* @var $model Models */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', [
        'id' => 'models-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <fieldset class="formContainer">
        <legend style="margin-left:60px;">
            <?= $model->isNewRecord ? 'Новая модель' : 'Редактирование модели ' . $model->name; ?>
        </legend>
        <?= $form->errorSummary($model); ?>

        <div class="row">
        <?= $form->labelEx($model, 'name'); ?>
        <?= $form->textField($model, 'name', ['size' => 30, 'maxlength' => 30]); ?>
        <?= $form->error($model, 'name'); ?>
        </div>

        <div class="row">
        <?= $form->labelEx($model, 'description'); ?>
        <?= $form->textArea($model, 'description', ['size' => 60, 'maxlength' => 255]); ?>
        <?= $form->error($model, 'description'); ?>
            </div>

        <?= $form->labelEx($model, 'picture'); ?>
        <?= $form->fileField($model, 'picture'); ?>
        <?= $form->error($model, 'picture'); ?>

        <div class="buttons">
            <?= CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>

</div>

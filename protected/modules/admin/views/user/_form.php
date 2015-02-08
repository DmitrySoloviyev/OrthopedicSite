<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'user-form',
        'enableAjaxValidation' => false,
    ]); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->labelEx($model, 'surname'); ?>
    <?= $form->textField($model, 'surname', [
        'size' => 30,
        'maxlength' => 30,
        'placeholder' => $model->getAttributeLabel('surname'),
        'autocomplete' => 'off',
    ]); ?>

    <?= $form->labelEx($model, 'name'); ?>
    <?= $form->textField($model, 'name', [
        'size' => 30,
        'maxlength' => 30,
        'placeholder' => $model->getAttributeLabel('name'),
        'autocomplete' => 'off',
    ]); ?>

    <?= $form->labelEx($model, 'patronymic'); ?>
    <?= $form->textField($model, 'patronymic', [
        'size' => 30,
        'maxlength' => 30,
        'placeholder' => $model->getAttributeLabel('patronymic'),
        'autocomplete' => 'off',
    ]); ?>

    <div class=" buttons">
        <?= CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-primary']); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>

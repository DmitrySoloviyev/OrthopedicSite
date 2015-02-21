<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'user-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
    ]); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->textFieldControlGroup($model, 'login', ['span' => 5, 'autocomplete' => 'Off', 'maxlength' => 255]); ?>

    <?= $form->passwordFieldControlGroup($model, 'password', ['span' => 5, 'autocomplete' => 'Off', 'maxlength' => 255]); ?>

    <?= $form->textFieldControlGroup($model, 'surname', ['span' => 5, 'autocomplete' => 'Off', 'maxlength' => 255]); ?>

    <?= $form->textFieldControlGroup($model, 'name', ['span' => 5, 'autocomplete' => 'Off', 'maxlength' => 255]); ?>

    <?= $form->textFieldControlGroup($model, 'patronymic', ['span' => 5, 'autocomplete' => 'Off', 'maxlength' => 255]); ?>

    <?= TbHtml::formActions([
        TbHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', [
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
        ]),
        TbHtml::resetButton('Очистить', [
            'color' => TbHtml::BUTTON_COLOR_DEFAULT,
        ]),
    ]); ?>

    <?php $this->endWidget(); ?>

</div>

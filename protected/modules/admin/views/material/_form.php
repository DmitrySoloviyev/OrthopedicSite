<?php
/* @var $this MaterialController */
/* @var $model Material */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'material-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
    ]); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->textFieldControlGroup($model, 'title', ['span' => 5, 'autocomplete' => 'off', 'maxlength' => 255]); ?>

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

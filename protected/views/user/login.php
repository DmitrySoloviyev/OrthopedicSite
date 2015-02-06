<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form TbActiveForm */

$this->pageTitle = Yii::app()->name . ' - Войти';
?>

<div class="form">
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'login-form',
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
        'enableClientValidation' => true,
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
    ]); ?>

    <?= TbHtml::blockAlert(TbHtml::ALERT_COLOR_INFO,
        '<p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>'); ?>

    <?= $form->textFieldControlGroup($model, 'username'); ?>
    <?= $form->passwordFieldControlGroup($model, 'password'); ?>
    <?= $form->checkBoxControlGroup($model, 'rememberMe'); ?>
    <?= TbHtml::formActions([
        TbHtml::submitButton('Войти', ['color' => TbHtml::BUTTON_COLOR_PRIMARY]),
        TbHtml::resetButton('Очистить'),
    ]); ?>

    <?php $this->endWidget(); ?>
</div>

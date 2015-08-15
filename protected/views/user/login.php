<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form TbActiveForm */
$this->pageTitle = Yii::app()->name . ' - Войти';
?>

<div class="form span12">
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'login-form',
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
        'enableClientValidation' => true,
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
    ]); ?>

    <?= TbHtml::blockAlert(TbHtml::ALERT_COLOR_INFO,
        '<p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>', [
            'closeText' => ''
        ]); ?>

    <!--[if IE]>
    <div class="col-md-12">
        <h1 class="alert alert-danger">ВНИМАНИЕ! Вы используете браузер Internet Explorer!</h1>
        <h4 class="alert alert-danger" style="text-align: justify">
            Данная система построена на передовых, современных технологиях и не поддерживает Internet Explorer.
            Настоятельно рекомендуем Вам выбрать к использованию любой другой браузер последней версии.
            Браузер Internet Explorer не может предоставить все возможности, которые могут предоставить современные
            браузеры, а скорость его работы в несколько раз ниже! Internet Explorer не способен корректно отображать
            большинство современных сайтов.
        </h4>
    </div>
    <![endif]-->

    <?= $form->textFieldControlGroup($model, 'username'); ?>
    <?= $form->passwordFieldControlGroup($model, 'password'); ?>
    <?= $form->checkBoxControlGroup($model, 'rememberMe'); ?>
    <?= TbHtml::formActions([
        TbHtml::submitButton('Войти', ['color' => TbHtml::BUTTON_COLOR_PRIMARY]),
        TbHtml::resetButton('Очистить'),
    ]); ?>

    <?php $this->endWidget(); ?>
</div>

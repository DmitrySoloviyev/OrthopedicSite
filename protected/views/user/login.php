<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - Войти';
?>

<p>Пожалуйста, заполните следующую форму вашими учетными данными:</p>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', [
        'id' => 'login-form',
        'enableClientValidation' => true,
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
    ]); ?>

    <p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

    <div class="row">
        <?= $form->labelEx($model, 'username'); ?><br/>
        <?= $form->textField($model, 'username', ['class' => 'input_text']); ?>
        <?= $form->error($model, 'username'); ?>
    </div>

    <div class="row">
        <?= $form->labelEx($model, 'password'); ?><br/>
        <?= $form->passwordField($model, 'password', ['class' => 'input_text']); ?>
        <?= $form->error($model, 'password'); ?>
    </div>

    <div class="row rememberMe">
        <?= $form->checkBox($model, 'rememberMe'); ?>
        <?= $form->label($model, 'rememberMe'); ?>
        <?= $form->error($model, 'rememberMe'); ?>
    </div>

    <div class="row buttons">
        <?= CHtml::submitButton('Войти', ['class' => 'button']); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->

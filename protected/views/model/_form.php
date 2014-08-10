<?php
/* @var $this ModelController */
/* @var $model Models */
/* @var $form CActiveForm */

Yii::app()->clientScript->registerScriptFile('/js/preview.js', CClientScript::POS_END);
$this->widget('ext.fancybox.EFancyBox', [
    'target' => '#preview',
    'config' => [
        'enableEscapeButton' => true,
    ],
]); ?>

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
        <div style="float: left; margin-right: 40px">
            <div class="row">
                <?= $form->labelEx($model, 'name'); ?><br>
                <?= $form->textField($model, 'name', ['maxlength' => 6, 'autocomplete' => 'off']); ?>
                <?= $form->error($model, 'name'); ?>
            </div>

            <div class="row">
                <?= $form->labelEx($model, 'description'); ?><br>
                <?= $form->textArea($model, 'description', ['cols' => 30, 'rows' => 10, 'maxlength' => 255]); ?>
                <?= $form->error($model, 'description'); ?>
            </div>

            <div class="row">
                <?= $form->labelEx($model, 'picture'); ?><br>
                <?= $form->fileField($model, 'picture'); ?>
                <?= $form->error($model, 'picture'); ?>
            </div>

            <div class="buttons">
                <?= CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class'=>'button']); ?>
            </div>
        </div>
        <div>
            <img alt="preview" id="preview" src="<?= Models::MODEL_IMAGE_PATH . 'ortho.jpg' ?>" width="350px"/>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>

</div>


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

<div class="row-fluid">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'models-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => ['enctype' => 'multipart/form-data', 'class' => 'span5'],

    ]); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->labelEx($model, 'name'); ?>
    <?= $form->textField($model, 'name', ['size' => 30, 'maxlength' => 6, 'autocomplete' => 'off']); ?>
    <?= $form->error($model, 'name'); ?>

    <?= $form->labelEx($model, 'description'); ?>
    <?= $form->textArea($model, 'description', ['size' => 60, 'maxlength' => 255]); ?>
    <?= $form->error($model, 'description'); ?>

    <?= $form->labelEx($model, 'picture'); ?>
    <?= $form->fileField($model, 'picture'); ?>
    <?= $form->error($model, 'picture'); ?>

    <div><br>
        <?= CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-primary']); ?>
    </div>

    <?php $this->endWidget(); ?>

    <div class="span5">
        <img alt="preview" id="preview" src="<?= Models::MODEL_IMAGE_PATH . ($model->isNewRecord ? 'ortho.jpg' : $model->picture) ?>" width="350px"/>
    </div>

</div>

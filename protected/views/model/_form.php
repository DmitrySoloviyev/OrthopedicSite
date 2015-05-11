<?php
/* @var $this ModelController */
/* @var $model Models */
/* @var $form TbActiveForm */

Yii::app()->clientScript->registerScriptFile('/js/preview.js', CClientScript::POS_END);
$this->widget('ext.fancybox.EFancyBox', [
    'target' => '#preview',
    'config' => [
        'enableEscapeButton' => true,
    ],
]);
$src = Models::MODEL_IMAGE_PATH . ($model->isNewRecord ? 'ortho.jpg' : $model->picture);
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'models-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <div class="row-fluid">
        <div class="span7">
            <?= $form->errorSummary($model); ?>

            <?= $form->textFieldControlGroup($model, 'name', [
                'span' => 10,
                'maxlength' => 6,
                'autocomplete' => 'off',
                'value' => Yii::app()->request->getParam('name', $model->name)
            ]) ?>
            <?= $form->labelEx($model, 'description') ?>
            <?php $this->widget('yiiwheels.widgets.redactor.WhRedactor', [
                'model' => $model,
                'attribute' => 'description',
                'pluginOptions' => [
                    'lang' => Yii::app()->language,
                ],
            ]); ?>
            <br>
            <?= $form->labelEx($model, 'comment') ?>
            <?php $this->widget('yiiwheels.widgets.redactor.WhRedactor', [
                'model' => $model,
                'attribute' => 'comment',
                'pluginOptions' => [
                    'lang' => Yii::app()->language,
                ],
            ]); ?>
        </div>
        <div class="span5">
            <?= TbHtml::imagePolaroid($src, 'изображение модели', [
                'href' => $src,
                'id' => 'preview',
                'style' => 'cursor:pointer',
            ]); ?>
            <?= $form->fileFieldControlGroup($model, 'picture') ?>
        </div>
    </div>
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

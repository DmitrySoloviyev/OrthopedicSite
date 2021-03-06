<?php
/* @var $this ModelController */
/* @var $model Models */

$this->pageTitle = Yii::app()->name . ' - Редактирование модели №' . $model->name;

$this->widget('bootstrap.widgets.TbBreadcrumb', [
    'links' => [
        'Модели' => ['model/index'],
        $model->name . ' ' => Yii::app()->createUrl('model/view', ['id' => $model->id]),
        'Редактирование',
    ],
]);

$this->widget('ext.yii-flash.Flash', [
    'keys' => ['success', 'error'],
]);

$this->renderPartial('_form', ['model' => $model]);

<?php
/* @var $this ModelController */
/* @var $model Models */

$this->pageTitle = Yii::app()->name . ' - Новая модель';

$this->widget('bootstrap.widgets.TbBreadcrumb', [
    'links' => [
        'Модели' => ['model/index'],
        'Новая модель',
    ],
]);

$this->widget('ext.yii-flash.Flash', [
    'keys' => ['success', 'error'],
]);

$this->renderPartial('_form', ['model' => $model]);

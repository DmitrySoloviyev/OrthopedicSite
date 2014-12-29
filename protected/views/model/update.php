<?php
/* @var $this ModelController */
/* @var $model Models */

$this->pageTitle = Yii::app()->name . ' - Редактирование модели №' . $model->name;
$this->renderPartial('_form', ['model' => $model]);

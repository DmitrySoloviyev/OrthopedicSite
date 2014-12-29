<?php
/* @var $this ModelController */
/* @var $model Models */

$this->pageTitle = Yii::app()->name . ' - Новая модель';
$this->renderPartial('_form', ['model' => $model]);

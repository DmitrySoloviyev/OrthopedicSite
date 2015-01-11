<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 11.01.15
 * Time: 17:39
 */

$form = $this->beginWidget('CActiveForm', [
    'method' => 'GET',
    'id' => 'search-form',
    'action' => Yii::app()->createUrl('site/search'),
]);

echo $form->textField($model, 'query', [
    'autocomplete' => 'Off',
    'placeholder' => 'Поиск по сайту',
    'id' => 'search-form-input',
]);

$this->endWidget();

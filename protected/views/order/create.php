<?php
/**
 * @var $order Order
 * @var $customer Customer
 * @var $form CActiveForm
 */

$this->pageTitle = Yii::app()->name . ' - Новый заказ';
Yii::app()->clientScript->registerScriptFile('/js/model.js', CClientScript::POS_END);

$this->widget('bootstrap.widgets.TbBreadcrumb', [
    'links' => [
        'Заказы' => ['order/index'],
        'Новый заказ',
    ],
]);

$this->widget('ext.yii-flash.Flash', [
    'keys' => ['success', 'error'],
]);

$this->renderPartial('_form', ['order' => $order, 'customer' => $customer]);

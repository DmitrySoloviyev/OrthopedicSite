<?php
/**
 * @var $order Order
 * @var $customer Customer
 * @var $form CActiveForm
 */

$this->pageTitle = Yii::app()->name . ' - Редактирование заказа №' . $order->order_name;
Yii::app()->clientScript->registerScriptFile('/js/hideFlash.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/js/model.js', CClientScript::POS_END);

$this->widget('ext.yii-flash.Flash', [
    'keys' => ['success', 'error'],
    'htmlOptions' => [
        'success' => ['class' => 'flash-success'],
        'error' => ['class' => 'flash-error'],
    ],
]);

$this->widget('bootstrap.widgets.TbBreadcrumb', [
    'links' => [
        'Заказы' => ['order/index'],
        'Редактирование ' . $order->order_name => Yii::app()->createUrl('order/view', ['id' => $order->id]),
    ],
]);

$this->renderPartial('_form', ['order' => $order, 'customer' => $customer]);

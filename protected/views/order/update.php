<?php
/**
 * @var $order Order
 * @var $customer Customer
 * @var $form CActiveForm
 */

$this->pageTitle = Yii::app()->name . ' - Редактирование заказа №' . $order->order_name;
Yii::app()->clientScript->registerScriptFile('/js/model.js', CClientScript::POS_END);

$this->widget('bootstrap.widgets.TbBreadcrumb', [
    'links' => [
        'Заказы' => ['order/index'],
        $order->order_name . ' ' => Yii::app()->createUrl('order/view', ['id' => $order->id]),
        'Редактирование',
    ],
]);

$this->renderPartial('_form', ['order' => $order, 'customer' => $customer]);

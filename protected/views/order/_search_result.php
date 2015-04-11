<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 31.01.15
 * Time: 13:23
 */
?>

<div class="view">
    <b><?= CHtml::encode($data->getAttributeLabel('order_name')); ?>:</b>
    <?= CHtml::link(CHtml::encode($data->order_name), ['order/view', 'id' => $data->id]); ?>
    <br/>

    <b><?= CHtml::encode($data->getAttributeLabel('model_id')); ?>:</b>
    <?= CHtml::link(CHtml::encode($data->model->name), ['model/view', 'id' => $data->model_id]); ?>
    <br/>

    <b><?= CHtml::encode($data->getAttributeLabel('ordersMaterials')); ?>:</b>
    <?= CHtml::encode($data->materialsList(', ')); ?>
    <br/>

    <b><?= CHtml::encode($data->getAttributeLabel('author_id')); ?>:</b>
    <?= $data->author->fullName(); ?>
    <br/>

    <b><?= CHtml::encode($data->getAttributeLabel('customer_id')); ?>:</b>
    <?= $data->customer->fullName(); ?>
    <br/>

    <b><?= $data->getAttributeLabel('comment'); ?>:</b>
    <?= $data->comment; ?>
    <br/>

    <b><?= CHtml::encode($data->getAttributeLabel('date_created')); ?>:</b>
    <?= $data->hiddmmyyyy($data->date_created) ?>
    <br/>
</div>

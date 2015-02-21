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

<!--    <b>--><?//= CHtml::encode($data->getAttributeLabel('material_id')); ?><!--:</b>-->
<!--    --><?//= CHtml::encode($data->material->title); ?>
<!--    <br/>-->

    <b><?= CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
    <?= CHtml::encode($data->user->fullName()); ?>
    <br/>

    <b><?= CHtml::encode($data->getAttributeLabel('customer_id')); ?>:</b>
    <?= CHtml::encode($data->customer->fullName()); ?>
    <br/>

    <b><?= CHtml::encode($data->getAttributeLabel('comment')); ?>:</b>
    <?= CHtml::encode($data->comment); ?>
    <br/>

</div>

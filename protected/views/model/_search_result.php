<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 31.01.15
 * Time: 13:23
 */
?>

<div class="view">

    <b><?= CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
    <?= CHtml::link(CHtml::encode($data->name), ['model/view', 'id' => $data->id]); ?>
    <br/>

    <b><?= CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
    <?= CHtml::encode($data->description); ?>
    <br/>

    <b><?= CHtml::encode($data->getAttributeLabel('comment')); ?>:</b>
    <?= CHtml::encode($data->comment); ?>
    <br/>

</div>
<hr>

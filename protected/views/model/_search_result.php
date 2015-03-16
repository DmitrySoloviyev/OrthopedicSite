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
    <?= $data->description; ?>
    <br/>

    <b><?= CHtml::encode($data->getAttributeLabel('comment')); ?>:</b>
    <?= $data->comment; ?>
    <br/>

</div>
<hr>

<?php
/* @var $model Models */

$this->widget('ext.fancybox.EFancyBox', [
    'target' => '#picture_resource',
    'config' => [
        'enableEscapeButton' => true,
    ],
]);

$isModel = is_object($model);
$picture = Models::MODEL_IMAGE_PATH . ($isModel ? $model->picture : 'ortho.jpg');
?>

<div id="modelContent" style="text-align: left;">
    <div style="font-style: italic; font-size: 1.1em; text-align: center;" id="name">
        <?= $isModel ? 'Модель № ' . CHtml::link($model->name, ['model/view', 'id' => $model->id], ['target' => '_blank']) : 'Выберите модель' ?>
    </div>

    <div id="picture">
        <img src="<?= $picture ?>" href="<?= $picture ?>" id="picture_resource" alt='изображение модели'/>
    </div>

    <?= Models::model()->getAttributeLabel('description') ?>:
    <spam id="description"><?= (is_object($model) ? $model->description : ''); ?></spam>
    <br>
    <?= Models::model()->getAttributeLabel('date_created') ?>:
    <spam id="date_created"><?= (is_object($model) ? $model->date_created : ''); ?></spam>
    <br>
    <?= Models::model()->getAttributeLabel('date_modified') ?>:
    <spam id="date_modified"><?= $isModel ? $model->date_modified : ''; ?></spam>
</div>

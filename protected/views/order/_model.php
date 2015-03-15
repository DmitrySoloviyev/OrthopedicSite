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

<div style="font-style: italic; font-size: 1.1em; text-align: center;" id="name" class="span12">
    <?= $isModel ? 'Модель № ' . CHtml::link($model->name, ['model/view', 'id' => $model->id], ['target' => '_blank']) : 'Модель не выбрана' ?>
</div>

<div class="span12">
    <?= TbHtml::imagePolaroid($picture, 'изображение модели', [
        'href' => $picture,
        'id' => 'picture_resource',
        'style' => 'cursor:pointer',
    ]); ?>
</div>

<div class="span12 well">
    <p id="description" style="text-align: justify"><?= is_object($model) ? $model->description : ''; ?></p>
    <p id="date_created">
        <?= is_object($model) ? Models::model()->getAttributeLabel('date_created') . ' : ' . $model->date_created : ''; ?>
    </p>
</div>

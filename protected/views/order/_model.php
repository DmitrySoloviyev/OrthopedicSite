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

<!--    <div id="picture">-->
        <?= TbHtml::imagePolaroid($picture, 'изображение модели', [
            'href' => $picture,
            'id' => 'picture_resource',
        ]); ?>
<!--    </div>-->

    <?= Models::model()->getAttributeLabel('description') ?>:
    <span id="description"><?= (is_object($model) ? $model->description : ''); ?></span>
    <br>
    <?= Models::model()->getAttributeLabel('date_created') ?>:
    <span id="date_created"><?= (is_object($model) ? $model->date_created : ''); ?></span>
    <br>
    <?= Models::model()->getAttributeLabel('date_modified') ?>:
    <span id="date_modified"><?= $isModel ? $model->date_modified : ''; ?></span>
</div>

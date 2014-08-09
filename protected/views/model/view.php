<?php
/* @var $this ModelController */
/* @var $model Models */
?>

<h1>Просмотр модели <?= $model->name; ?></h1>

<?php
$this->widget('ext.fancybox.EFancyBox', [
    'target' => '#'.$model->id,
    'config' => [
        'enableEscapeButton' => true,
    ],
]);

$this->widget('zii.widgets.CDetailView', [
    'data' => $model,
    'htmlOptions' => ['class' => ''],
    'attributes' => [
        'name',
        'description',
        'date_created',
        'date_modified',
        'picture' => [
            'name' => 'picture',
            'type' => 'raw',
            'value' => CHtml::image(Yii::app()->baseUrl . '/upload/OrthopedicGallery/' . $model->picture, $model->name, [
                    'width' => '350px',
                    'id' => $model->id,
                    'href' => Yii::app()->baseUrl . '/upload/OrthopedicGallery/' . $model->picture,
                ]),
        ],
    ],
]); ?>

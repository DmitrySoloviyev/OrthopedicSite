<?php
/* @var $this ModelController */
/* @var $model Models */
$this->pageTitle = Yii::app()->name . ' -  Просмотр модели №' . $model->name;
$this->widget('bootstrap.widgets.TbBreadcrumb', [
    'links' => [
        'Модели' => ['model/index'],
        'Страница модели №' . $model->name,
    ],
]);
$this->widget('ext.fancybox.EFancyBox', [
    'target' => '#' . $model->id,
    'config' => [
        'enableEscapeButton' => true,
    ],
]);
$src = Models::MODEL_IMAGE_PATH . $model->picture;
?>

<div class="row-fluid">
    <div class="span7">
        <?php $this->widget('bootstrap.widgets.TbDetailView', [
            'data' => $model,
            'htmlOptions' => ['class' => ''],
            'attributes' => [
                'name',
                'description',
                'comment',
                'date_created',
                'date_modified',
            ],
        ]); ?>
    </div>
    <div class="span5">
        <?= TbHtml::imagePolaroid($src, 'изображение модели', [
            'href' => $src,
            'id' => $model->id,
        ]); ?>
    </div>
</div>

<?= TbHtml::formActions([
    TbHtml::submitButton('Редактировать', [
        'color' => TbHtml::BUTTON_COLOR_PRIMARY,
        'submit' => [
            'model/update',
            'id' => $model->id,
        ],
        'params' => [
            Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
        ],
    ]),
    TbHtml::submitButton('Удалить', [
        'color' => TbHtml::BUTTON_COLOR_DANGER,
        'submit' => [
            'model/delete',
            'id' => $model->id,
        ],
        'params' => [
            Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
        ],
        'confirm' => 'Вы действительно хотите удалить эту модель?',
        'class' => 'pull-right',
    ]),
]); ?>

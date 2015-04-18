<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 18.04.15
 * Time: 18:48
 */
/* @var $model Models */

$this->widget('ext.fancybox.EFancyBox', [
    'target' => '#' . $model->id,
    'config' => [
        'enableEscapeButton' => true,
    ],
]);
$src = Models::MODEL_IMAGE_PATH . $model->picture;
?>

<div class="span7">
    <?php $this->widget('bootstrap.widgets.TbDetailView', [
        'data' => $model,
        'htmlOptions' => ['class' => ''],
        'attributes' => [
            'name',
            [
                'name' => 'description',
                'type' => 'html',
                'value' => $model->description,
            ],
            [
                'name' => 'comment',
                'type' => 'html',
                'value' => $model->comment,
            ],
            [
                'name' => 'author_id',
                'value' => $model->author->fullName(),
            ],
            [
                'name' => 'modified_by',
                'value' => $model->editor->fullName(),
            ],
            [
                'name' => 'date_created',
                'type' => 'raw',
                'value' => $this->widget('ext.timeago.TimeAgo', [
                    'date' => $model->date_created,
                ]),
            ],
            [
                'name' => 'date_modified',
                'type' => 'raw',
                'value' => $this->widget('ext.timeago.TimeAgo', [
                    'date' => $model->date_modified,
                ]),
            ],
        ],
    ]);

    echo TbHtml::formActions([
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
            'data-toggle' => 'modal',
            'data-target' => '#modalDelete',
            'class' => 'pull-right',
        ]),
    ]);

    $this->widget('bootstrap.widgets.TbModal', [
        'id' => 'modalDelete',
        'header' => 'Подтверждение действий',
        'content' => '<p>Вы действительно хотите удалить эту модель?</p>',
        'footer' => [
            TbHtml::submitButton('Да', [
                'data-dismiss' => 'modal', 'color' => TbHtml::BUTTON_COLOR_DANGER,
                'submit' => [
                    'model/delete',
                    'id' => $model->id,
                ],
                'params' => [
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                ],
                'class' => 'pull-left',
            ]),
            TbHtml::button('Отмена', ['data-dismiss' => 'modal']),
        ],
    ]); ?>
</div>
<div class="span5">
    <?= TbHtml::imagePolaroid($src, 'изображение модели', [
        'href' => $src,
        'id' => $model->id,
    ]); ?>
</div>

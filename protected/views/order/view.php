<?php
/* @var $this OrderController */
/* @var $order Order */
?>

<h1>Заказ № <?= $order->order_id; ?></h1>

<?php
$this->widget('ext.fancybox.EFancyBox', [
    'target' => '#' . $order->id,
    'config' => [
        'enableEscapeButton' => true,
    ],
]);

$this->widget('zii.widgets.CDetailView', [
    'data' => $order,
    'htmlOptions' => ['class' => ''],
    'attributes' => [
        'order_id',
        [
            'name' => 'model_id',
            'value' => $order->model->name,
        ],
        [
            'name' => 'Размеры',
            'value' => $order->sizeLeft->size . ' левый, ' . $order->sizeRight->size . ' правый',
        ],
        [
            'name' => 'Урк',
            'value' => $order->urkLeft->urk . ' левый, ' . $order->urkRight->urk . ' правый',
        ],
        [
            'name' => 'material_id',
            'value' => $order->material->material_name,
        ],
        [
            'name' => 'Высота',
            'value' => $order->heightLeft->height . ' левый, ' . $order->heightRight->height . ' правый',
        ],
        [
            'name' => 'Объем верха',
            'value' => $order->topVolumeLeft->volume . ' левый, ' . $order->topVolumeRight->volume . ' правый',
        ],
        [
            'name' => 'Объем лодыжки',
            'value' => $order->ankleVolumeLeft->volume . ' левый, ' . $order->ankleVolumeRight->volume . ' правый',
        ],
        [
            'name' => 'Объем КВ',
            'value' => $order->kvVolumeLeft->volume . ' левый, ' . $order->kvVolumeRight->volume . ' правый',
        ],
        [
            'name' => 'customer_id',
            'value' => $order->customer->fullName(),
        ],
        [
            'name' => 'employee_id',
            'value' => $order->employee->fullName(),
        ],
        'comment',
        'date_created',
        'date_modified',/*
        'picture' => [
            'name' => 'picture',
            'type' => 'raw',
            'value' => CHtml::image(Yii::app()->baseUrl . '/upload/OrthopedicGallery/' . $order->picture, $order->name, [
                    'width' => '350px',
                    'id' => $order->id,
                    'href' => Yii::app()->baseUrl . '/upload/OrthopedicGallery/' . $order->picture,
                ]),
        ],*/
    ],
]);

$model = Models::model()->findByPk($order->model_id);
$this->widget('zii.widgets.CDetailView', [
    'data' => $model,
    'htmlOptions' => ['class' => ''],
    'attributes' => [
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
    ],
]); ?>

<!--<div id="modelForm">-->
<!--    --><?php //$this->renderPartial('_model', null, false, false); ?>
<!--</div>-->

<div class="row submit actions_button">
    <?=
    CHtml::submitButton('Редактировать', [
        'class' => 'button',
        'submit' => [
            'order/update',
            'id' => $order->id,
        ],
        'params' => [
            Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
        ],
    ]); ?>
    <?=
    CHtml::submitButton('Удалить', [
        'class' => 'button_delete',
        'submit' => [
            'order/delete',
            'id' => $order->id,
        ],
        'params' => [
            Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
        ],
        'confirm' => 'Вы действительно хотите удалить этот заказ?',
    ]);?>
</div>

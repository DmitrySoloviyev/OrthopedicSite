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
]); ?>

<div class="row submit">
    <?=
    CHtml::submitButton('Редактировать', [
        'class' => 'button',
        'style' => 'margin-left: 6%;',
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
        'style' => 'margin-left: 6%;',
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

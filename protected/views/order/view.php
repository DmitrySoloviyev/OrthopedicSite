<?php
/* @var $this OrderController */
/* @var $order Order */
$this->pageTitle = Yii::app()->name . ' - Заказ №' . $order->order_name;

$this->widget('bootstrap.widgets.TbBreadcrumb', [
    'links' => [
        'Заказы' => ['order/index'],
        $order->order_name,
    ],
]);

$this->widget('ext.yii-flash.Flash', [
    'keys' => ['success', 'error'],
]);

$this->widget('ext.fancybox.EFancyBox', [
    'target' => '#' . $order->id,
    'config' => [
        'enableEscapeButton' => true,
    ],
]); ?>

    <div class="row-fluid">
        <div class="span6">
            <h1>Заказ № <?= $order->order_name; ?></h1>
            <?php $this->widget('bootstrap.widgets.TbDetailView', [
                'data' => $order,
                'attributes' => [
                    'order_name',
                    [
                        'name' => 'model_id',
                        'value' => $order->model->name,
                    ],
                    [
                        'name' => 'sizes',
                        'value' => $order->size_left . ' левый, ' . $order->size_right . ' правый',
                    ],
                    [
                        'name' => 'urks',
                        'value' => $order->urk_left . ' левый, ' . $order->urk_right . ' правый',
                    ],
                    [
                        'name' => 'materials_ids',
                        'type' => 'raw',
                        'value' => $order->materialsList(),
                    ],
                    [
                        'name' => 'heights',
                        'value' => $order->height_left . ' левый, ' . $order->height_right . ' правый',
                    ],
                    [
                        'name' => 'top_volumes',
                        'value' => $order->top_volume_left . ' левый, ' . $order->top_volume_right . ' правый',
                    ],
                    [
                        'name' => 'ankle_volumes',
                        'value' => $order->ankle_volume_left . ' левый, ' . $order->ankle_volume_right . ' правый',
                    ],
                    [
                        'name' => 'kv_volumes',
                        'value' => $order->kv_volume_left . ' левый, ' . $order->kv_volume_right . ' правый',
                    ],
                    [
                        'name' => 'customer_id',
                        'value' => $order->customer->fullName(),
                    ],
                    [
                        'name' => 'author_id',
                        'value' => $order->author->fullName(),
                    ],
                    [
                        'name' => 'modified_by',
                        'value' => $order->editor->fullName(),
                    ],
                    'date_created',
                    'date_modified',
                    'comment',
                ],
            ]);
            ?>
        </div>

        <div class="span6" id="modelForm">
            <?php $this->renderPartial('_model', ['model' => $order->model]); ?>
        </div>
    </div>

<?= TbHtml::formActions([
    TbHtml::submitButton('Редактировать', [
        'color' => TbHtml::BUTTON_COLOR_PRIMARY,
        'submit' => [
            'order/update',
            'id' => $order->id,
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
    'content' => '<p>Вы действительно хотите удалить этот заказ?</p>',
    'footer' => [
        TbHtml::submitButton('Да', [
            'data-dismiss' => 'modal', 'color' => TbHtml::BUTTON_COLOR_DANGER,
            'submit' => [
                'order/delete',
                'id' => $order->id,
            ],
            'params' => [
                Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
            ],
            'class' => 'pull-left',
        ]),
        TbHtml::button('Отмена', ['data-dismiss' => 'modal']),
    ],
]);

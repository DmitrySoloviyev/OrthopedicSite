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
                        'value' => $order->sizesValues(),
                    ],
                    [
                        'name' => 'urks',
                        'value' => $order->urksValues(),
                    ],
                    [
                        'name' => 'ordersMaterials',
                        'type' => 'raw',
                        'value' => $order->materialsList(),
                    ],
                    [
                        'name' => 'heights',
                        'value' => $order->heightsValues(),
                    ],
                    [
                        'name' => 'top_volumes',
                        'value' => $order->topVolumesValues(),
                    ],
                    [
                        'name' => 'ankle_volumes',
                        'value' => $order->ankleVolumesValues(),
                    ],
                    [
                        'name' => 'kv_volumes',
                        'value' => $order->kvVolumesValues(),
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
                    [
                        'name' => 'date_created',
                        'type' => 'raw',
                        'value' => $this->widget('ext.timeago.TimeAgo', [
                            'date' => $order->date_created,
                        ]),
                    ],
                    [
                        'name' => 'date_modified',
                        'type' => 'raw',
                        'value' => $this->widget('ext.timeago.TimeAgo', [
                            'date' => $order->date_modified,
                        ]),
                    ],
                    [
                        'name' => 'comment',
                        'type' => 'html',
                        'value' => $order->comment,
                    ],
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

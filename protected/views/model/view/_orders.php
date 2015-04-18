<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 18.04.15
 * Time: 18:48
 */
?>

<?php foreach ($model->orders as $key => $order) : ?>
    <div class="span6" style="margin: 1em 0.2em; padding: 1em; border: 1px solid rgb(216, 216, 216);   box-shadow: 1px 1px 6px #868686;">
        <?php $this->widget('bootstrap.widgets.TbDetailView', [
            'data' => $order,
            'htmlOptions' => ['class' => ''],
            'attributes' => [
                [
                    'name' => 'order_name',
                    'type' => 'raw',
                    'value' => CHtml::link($order->order_name, ['order/view', 'id' => $order->id], ['target' => '_blank']),
                ],
                [
                    'name' => 'ordersMaterials',
                    'type' => 'raw',
                    'value' => $order->materialsList(),
                ],
                [
                    'name' => 'comment',
                    'type' => 'html',
                    'value' => $order->comment,
                ],
                [
                    'name' => 'author_id',
                    'value' => $order->author->fullName(),
                ],
                [
                    'name' => 'date_created',
                    'type' => 'raw',
                    'value' => $this->widget('ext.timeago.TimeAgo', [
                        'date' => $order->date_created,
                    ]),
                ],
            ],
        ]); ?>
    </div>
<?php endforeach; ?>

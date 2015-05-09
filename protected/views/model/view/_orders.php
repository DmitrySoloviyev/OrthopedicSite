<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 18.04.15
 * Time: 18:48
 */
Yii::app()->clientScript->registerScript('scrollOrders', "
    var loading = false;
    $(window).scroll(function () {
        if ((($(window).scrollTop() + $(window).height()) + 250) >= $(document).height()) {
            if (loading == false) {
                loading = true;
                var last_order_id = $('#tab_2').children('div:last').attr('id');
                $.get('/model/feedOrders?model_id=". $model_id . "&start_order_id=' + last_order_id, function (loaded) {
                    $('#tab_2').append(loaded);
                    loading = false;
                });
            }
        }
    });
", CClientScript::POS_END);
?>

<?php foreach ($orders as $key => $order) : ?>
    <div id="<?= $order->id?>" class="span6" style="margin: 1em 0.2em; padding: 1em; border: 1px solid rgb(216, 216, 216); box-shadow: 1px 1px 6px #868686;">
        <?php $this->widget('bootstrap.widgets.TbDetailView', [
            'id' => 'modelOrders',
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

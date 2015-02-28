<?php
$this->pageTitle = Yii::app()->name . ' - Статистика';

if (Order::hasOrders() == 0) {
    echo 'Заказов не обнаружено.';
    return;
}

$this->widget('ext.UsersOrdersWidget.UsersOrders', []);

Yii::app()->clientScript->registerScript('loadStatistic', "
    $(window).load(function () {
        $.ajax({
            url: '".$this->createUrl('statistic/ordersPerDay')."',
            success: function (data) {
                $('#orders_per_day').html(data);
            }
        });

        $.ajax({
            url: '".$this->createUrl('statistic/usersByOrdersPerDay')."',
            success: function (data) {
                $('#users_by_orders_per_day').html(data);
            }
        });

        $.ajax({
            url: '".$this->createUrl('statistic/ordersPie')."',
            success: function (data) {
                $('#orders_pie').html(data);
            }
        });
    });
", CClientScript::POS_END);
?>
<style>
    .progress {
        margin-bottom: 0;
    }
</style>

<div id="orders_per_day">
    <?= TbHtml::well('Общая оценка производительности: количество заказов по дням недели' . TbHtml::animatedProgressBar(100)); ?>
</div>

<div id="users_by_orders_per_day">
    <?= TbHtml::well('Оценка производительности модельеров по дням недели' . TbHtml::animatedProgressBar(100)); ?>
</div>

<div id="orders_pie">
    <?= TbHtml::well('Объем реализованных заказов по модельерам за последние 3 месяца' . TbHtml::animatedProgressBar(100)); ?>
</div>
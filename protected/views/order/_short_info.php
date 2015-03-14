<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 14.03.15
 * Time: 15:50
 * @var $order Order
 */
?>

<div>
    <div><?= 'Автор: ' . $order->author->fullName() ?></div>
    <div><?= 'Дата создания: ' . $order->hiddmmyyyy($order->date_created) ?></div>
</div>

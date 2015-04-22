<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app()->name . ' - О сайте';
?>

<div>
    <h3>Общая информация</h3>
    <p>
        Прежче чем приступать к работе и дабавлять новые заказы, убедитесь, что зарегистрированы все сотрудники, которые
        будут непосредственно работать с базой данных. В противном случае они не смогут войти в систему создать
        какой-либо новый заказ или модель.
    </p>

    <h3>Корректный ввод данных - залог верного ответа</h3>
    <p>
        При добавлении нового заказа, дробные числа следует вводить через точку "<b>.</b>"!
        В строке фильтров, под названием столбцов таблиц можно использовать операторы сравнения (<b>&lt;</b>,
        <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> или <b>=</b>) в начале каждого из ваших значений
        поиска, чтобы задать диапазон значений по определенному столбцу.
    </p>

    <h3>Рекомендации</h3>
    <p>
        Настоятельно рекомендуется пользоваться сайтом при помощи браузера
        <a href="https://www.google.com/intl/ru/chrome/">Google Chrome</a> или другим браузером последней версии.
    </p>
</div>

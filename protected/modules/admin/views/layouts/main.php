<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0, width=device-width"/>
    <meta name="language" content="ru"/>
    <link rel='shortcut icon' href="<?= Yii::app()->request->baseUrl ?>images/shoes.png" type='image/png'>
    <?php Yii::app()->getModule('admin')->bootstrap->register(); ?>
    <title>Администрирование базы данных ортопедической обуви</title>
    <?php Yii::app()->clientScript->registerCssFile('/css/admin.css'); ?>
</head>

<body>
<div class="container">
    <?php $this->widget('bootstrap.widgets.TbNavbar', [
        'brandLabel' => 'Администрирование базы данных ортопедической обуви',
        'display' => TbHtml::NAVBAR_DISPLAY_FIXEDTOP,
        'items' => [
            [
                'class' => 'bootstrap.widgets.TbNav',
                'items' => [
                    ['label' => 'На сайт', 'url' => '/', 'icon' => 'home'],
                ],
            ],
        ],
    ]); ?>
    <div style="padding-top: 50px;">
        <?php
        $this->widget('bootstrap.widgets.TbNav', [
            'type' => TbHtml::NAV_TYPE_LIST,
            'htmlOptions' => ['class' => 'span2 well mynav'],
            'items' => [
                ['label' => 'Модельеры'],
                ['label' => 'Новый модельер', 'url' => '/admin/employee/create', 'class' => 'nav nav-list'],
                ['label' => 'Все модельеры', 'url' => '/admin/employee/index', 'class' => 'nav nav-list'],

                ['label' => 'Материалы'],
                ['label' => 'Новый материал', 'url' => '/admin/material/create', 'class' => 'nav nav-list'],
                ['label' => 'Все материалы', 'url' => '/admin/material/index', 'class' => 'nav nav-list'],

                ['label' => 'Модели'],
                ['label' => 'Новая модель', 'url' => '/admin/model/create', 'class' => 'nav nav-list'],
                ['label' => 'Все модели', 'url' => '/admin/model/index', 'class' => 'nav nav-list'],

                ['label' => 'База данных'],
                ['label' => 'Резервирование', 'url' => '/admin/db/backup', 'class' => 'nav nav-list'],
                ['label' => 'Восстановление', 'url' => '/admin/db/restore', 'class' => 'nav nav-list'],
                TbHtml::menuDivider(),
                ['label' => 'Отчеты'],
                ['label' => 'Все заказы', 'url' => '/admin/report/index', 'class' => 'nav nav-list'],
            ]
        ]);?>
    </div>
    <div class="span10 content"><?= $content ?></div>
</div>

<div class="footer">
    <hr/>
    Copyright &copy; 2013 - <?= date('Y') ?>
    by <?= CHtml::mailto('Dmitry Soloviyev', 'dmitry.soloviyev@gmail.com') ?>.<br/>
    г. Москва. All Rights Reserved.<br/>
    <?= Yii::powered() ?>
</div>
</body>
</html>

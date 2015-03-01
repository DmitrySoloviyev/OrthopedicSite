<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0, width=device-width"/>
    <meta name="language" content="ru"/>
    <title><?= CHtml::encode($this->pageTitle) ?></title>
    <?= Yii::app()->bootstrap->register(); ?>
    <?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript
        ->registerCssFile('/css/main.css')
        ->registerCssFile('/css/form.css')
        ->registerCssFile('/css/style.css')
        ->registerCssFile('/css/bootstrap-override.css')
        ->registerCssFile('/css/jquery.fancybox.css')
        ->registerScriptFile('/js/main.js', CClientScript::POS_END);
    ?>
</head>

<body id="top">
<div class="container-fluid">
    <code class="version"><?= Yii::app()->params['version'] ?></code>

    <div id="header">
        <div id="logo"><?= CHtml::encode(Yii::app()->name) ?></div>
    </div>

    <?php $this->widget('bootstrap.widgets.TbNavbar', [
        'brandLabel' => false,
        'display' => TbHtml::NAVBAR_DISPLAY_STATICTOP,
        'collapse' => true,
        'fluid' => true,
        'items' => [
            [
                'class' => 'bootstrap.widgets.TbNav',
                'items' => [
                    ['label' => 'Главная', 'url' => ['/site/index']],
                    ['label' => 'Заказы',
                        'items' => [
                            ['label' => 'Новый заказ', 'url' => ['/order/create']],
                            ['label' => 'Все заказы', 'url' => ['/order/index']],
                        ]
                    ],
                    ['label' => 'Модели',
                        'items' => [
                            ['label' => 'Новая модель', 'url' => ['/model/create']],
                            ['label' => 'Все модели', 'url' => ['/model/index']],
                        ]
                    ],
                    ['label' => 'Статистика', 'url' => ['/statistic/index']],
                    ['label' => 'Администрирование', 'url' => ['/admin'], 'visible' => !Yii::app()->user->isGuest],
                    ['label' => 'О сайте', 'url' => ['/site/about']],
                    ['label' => 'Войти', 'url' => ['/user/login'], 'visible' => Yii::app()->user->isGuest],
                    ['label' => 'Выйти (' . Yii::app()->user->login . ')', 'url' => ['/user/logout'], 'visible' => !Yii::app()->user->isGuest]
                ]
            ],
            TbHtml::navbarSearchForm(['site/search'], 'post', [
                'class' => 'pull-right',
                'autocomplete' => 'off',
            ]),
        ]
    ]); ?>


    <div class="row-fluid" id="center">
        <?= $content ?>
    </div>

    <div id="footer">
        <hr/>
        Copyright &copy; 2013 - <?= date('Y') ?>
        by <?= CHtml::mailto('Dmitry Soloviyev', 'dmitry.soloviyev@gmail.com') ?>.<br/>
        г. Москва. All Rights Reserved.<br/>
        <?= Yii::powered() ?>
    </div>
</div>
<p id='back-top' style="z-index:2">
    <a href='#top'><img width='84' height='84' src='<?= Yii::app()->request->baseUrl ?>/images/arrow_up_84.png'/></a>
</p>
</body>
</html>

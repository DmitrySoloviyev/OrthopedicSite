<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0, width=device-width"/>
    <meta name="language" content="ru"/>
    <!--[if lt IE 8]>
    <link rel='stylesheet' type='text/css' href="<?= Yii::app()->request->baseUrl ?>/css/ie.css"
          media="screen, projection"/>
    <![endif]-->
    <link rel='shortcut icon' href="<?= Yii::app()->request->baseUrl ?>images/shoes.png" type='image/png'>
    <link
        href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic&subset=latin,cyrillic-ext,greek-ext,cyrillic,latin-ext,greek'
        rel='stylesheet' type='text/css'>
    <title><?= CHtml::encode($this->pageTitle) ?></title>
    <?php
    Yii::app()->clientScript
        ->registerCssFile('/css/screen.css', 'screen, projection')
        ->registerCssFile('/css/print.css', 'print')
        ->registerCssFile('/css/main.css')
        ->registerCssFile('/css/form.css')
        ->registerCssFile('/css/style.css')
        ->registerCssFile('/css/jquery.fancybox.css')
        ->registerScriptFile('/js/main.js', CClientScript::POS_HEAD);
    ?>
</head>

<body id="top">
<div class="container" id="page">
    <a href="https://github.com/DmitrySoloviyev/OrthopedicSite">
        <img width="149px" height="149px" id="forkme" src=<?= Yii::app()->request->baseUrl ?>"/images/forkme_left_red.png" alt="Fork me on GitHub"/>
    </a>
    <div id="header">
        <code class="version">Версия 0.3-dev</code>
        <div id="logo"><?= CHtml::encode(Yii::app()->name)?></div>
        <div id="navigation">
            <?php $this->widget('zii.widgets.CMenu', [
                'items' => [
                    ['label' => 'Главная', 'url' => ['order/index']],
                    ['label' => 'Новый заказ', 'url' => ['order/new']],
                    ['label' => 'Все заказы', 'url' => ['order/view']],
                    ['label' => 'Поиск', 'url' => ['order/search']],
                    ['label' => 'Статистика', 'url' => ['statistic/show']],
                    ['label' => 'Администрирование', 'url' => ['admin/index'], 'visible' => !Yii::app()->user->isGuest],
                    ['label' => 'О сайте', 'url' => ['order/page', 'view' => 'about']],
                    ['label' => 'Войти', 'url' => ['user/login'], 'visible' => Yii::app()->user->isGuest],
                    ['label' => 'Выйти (' . Yii::app()->user->name . ')', 'url' => ['user/logout'], 'visible' => !Yii::app()->user->isGuest]
                ],
            ]); ?>
        </div><!-- mainmenu -->

        <?php $form = $this->beginWidget('CActiveForm', [
            'method' => 'GET',
            'action' => 'index.php?r=site/view&quickSearch=',
            'id' => 'quickSearchForm',
            ]); ?>
            <input type="text" id='quickSearchVal'
                <?= (isset($_GET['quickSearchValue'])) ? "value='" . $_GET['quickSearchValue'] . "'" : "" ?>
                    name="quickSearchValue" autocomplete='Off' placeholder='Поиск по ключевому слову'/>
        <?php $this->endWidget(); ?>
    </div>
    <!-- header -->

    <div id="center"><?= $content ?></div>
    <div class="clear"></div>

    <div id="footer"><hr/>
        Copyright &copy; 2013 - <?= date('Y') ?>
        by <?= CHtml::mailto('Dmitry Soloviyev', 'dmitry.soloviyev@gmail.com') ?>.<br/>
        г. Москва. All Rights Reserved.<br/>
        <?= Yii::powered() ?>
    </div><!-- footer -->
</div><!-- page -->
<p id='back-top' style="z-index:2">
    <a href='#top'><img width='78' height='78' src='../../images/arrow_up_84.png'/></a>
</p>
</body>
</html>

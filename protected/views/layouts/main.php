<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0, width=device-width"/>
    <meta name="language" content="ru"/>
    <link rel='shortcut icon' href="<?= Yii::app()->request->baseUrl ?>images/shoes.png" type='image/png'>
    <title><?= CHtml::encode($this->pageTitle) ?></title>
    <?php Yii::app()->clientScript
        ->registerCssFile('/css/screen.css', 'screen, projection')
        ->registerCssFile('/css/main.css')
        ->registerCssFile('/css/form.css')
        ->registerCssFile('/css/style.css')
        ->registerCssFile('/css/jquery.fancybox.css')
        ->registerScriptFile('/js/main.js', CClientScript::POS_END);
    ?>
</head>

<body id="top">
<div class="container" id="page">
    <code class="version"><?= Yii::app()->params['version'] ?></code>
    <div id="header">
        <div id="logo"><?= CHtml::encode(Yii::app()->name) ?></div>
        <div id="navigation">
            <?php $this->widget('zii.widgets.CMenu', [
                'items' => [
                    ['label' => 'Главная', 'url' => ['site/index']],
                    ['label' => 'Новый заказ', 'url' => ['order/create']],
                    ['label' => 'Новая модель', 'url' => ['model/create']],
                    ['label' => 'Все заказы', 'url' => ['order/index']],
                    ['label' => 'Все модели', 'url' => ['model/index']],
                    ['label' => 'Статистика', 'url' => ['statistic/index']],
                    ['label' => 'Администрирование', 'url' => ['/admin'], 'visible' => !Yii::app()->user->isGuest],
                    ['label' => 'О сайте', 'url' => ['site/about']],
                    ['label' => 'Войти', 'url' => ['user/login'], 'visible' => Yii::app()->user->isGuest],
                    ['label' => 'Выйти (' . Yii::app()->user->name . ')', 'url' => ['user/logout'], 'visible' => !Yii::app()->user->isGuest]
                ],
            ]); ?>
        </div>
        <!-- mainmenu -->

        <?php $form = $this->beginWidget('CActiveForm', [
            'method' => 'GET',
            'id' => 'quickSearchForm',
        ]); ?>
        <input type="text" id='quickSearch'
            <?= (isset($_GET['quickSearch'])) ? "value='" . $_GET['quickSearch'] . "'" : "" ?>
               name="quickSearch" autocomplete='Off' placeholder='Поиск заказа по ключевому слову'/>
        <?php $this->endWidget(); ?>
    </div>
    <!-- header -->

    <div id="center"><?= $content ?></div>
    <div class="clear"></div>

    <div id="footer">
        <hr/>
        Copyright &copy; 2013 - <?= date('Y') ?>
        by <?= CHtml::mailto('Dmitry Soloviyev', 'dmitry.soloviyev@gmail.com') ?>.<br/>
        г. Москва. All Rights Reserved.<br/>
        <?= Yii::powered() ?>
    </div>
    <!-- footer -->
</div>
<!-- page -->
<p id='back-top' style="z-index:2">
    <a href='#top'><img width='84' height='84' src='<?= Yii::app()->request->baseUrl ?>/images/arrow_up_84.png'/></a>
</p>
</body>
</html>

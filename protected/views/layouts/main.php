<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="ru"/>

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl ?>/css/screen.css"
          media="screen, projection"/>
    <link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl ?>/css/print.css" media="print"/>

    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css"
          media="screen, projection"/>
    <![endif]-->

    <link
        href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic&subset=latin,cyrillic-ext,greek-ext,cyrillic,latin-ext,greek'
        rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl ?>/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl ?>/css/form.css"/>
    <meta name="viewport" content="initial-scale=1.0, width=device-width"/>

    <!-- <meta name="viewport" content="initial-scale=1.0, width=device-width" /> -->
    <link rel="shortcut icon" href="<?= Yii::app()->request->baseUrl ?>images/shoes.png" type="image/png">
    <link rel="stylesheet" href="<?= Yii::app()->request->baseUrl ?>/css/style.css" type="text/css"/>
    <link rel="stylesheet" href="<?= Yii::app()->request->baseUrl ?>/css/jquery.fancybox.css" type="text/css"/>
    <title><?= CHtml::encode($this->pageTitle) ?></title>
    <?php
    Yii::app()->clientScript->registerScript('display', "
		$('#center').hide().fadeIn(800);

		//перемотка вверх
	    $('#back-top').hide();
	    	// fade in #back-top
	      	$(function () {
		  	$(window).scroll(function () {
		    	if ($(this).scrollTop() >= 400) {
			  		$('#back-top').fadeIn();
		      	} else {
			  		$('#back-top').fadeOut();
		      	}
		  });
		  // scroll body to 0px on click
		  $('#back-top a').click(function () {
		      $('body,html').animate({
			  scrollTop: 0
		      }, 700);
		      return false;
		  });
	      });//конец перемотка вверх

		$('#quickSearchVal').focus(function(){
			$('#quickSearchForm').css({
				'background-color': '#f7f7f7',
				'border-color': 'black'
			});
		});
		$('#quickSearchVal').focusout(function(){
			$('#quickSearchForm').css({
				'border-color': '',
				'background-color': '#E4E4E4',
			});
		});

		//пункты меню
		$('#navigation ul li a').mouseup(function(event) {
			if(event.which == 1 )
		    	$(this).parent().addClass('active');
		});
	", CClientScript::POS_READY);
    ?>
</head>

<body id="top">
<div class="container" id="page">
    <a href="https://github.com/DmitrySoloviyev/OrthopedicSite">
        <img width="149px" height="149px" style="position: absolute; top: 0; left: 0; border: 0; float:left"
             src=<?= Yii::app()->request->baseUrl ?>"/images/forkme_left_red.png" alt="Fork me on GitHub"/>
    </a>
    <div id="header">
        <code class="version">Версия 0.3-dev</code>
        <div id="logo"><?= CHtml::encode(Yii::app()->name)?></div>
        <div id="navigation">
            <?php $this->widget('zii.widgets.CMenu', [
                'items' => [
                    ['label' => 'Главная', 'url' => ['site/index']],
                    ['label' => 'Новый заказ', 'url' => ['site/new']],
                    ['label' => 'Все заказы', 'url' => ['site/view']],
                    ['label' => 'Поиск', 'url' => ['site/search']],
                    ['label' => 'Статистика', 'url' => ['statistic/show']],
                    ['label' => 'Администрирование', 'url' => ['site/admin'], 'visible' => !Yii::app()->user->isGuest],
                    ['label' => 'О сайте', 'url' => ['site/page', 'view' => 'about']],
                    ['label' => 'Войти', 'url' => ['site/login'], 'visible' => Yii::app()->user->isGuest],
                    ['label' => 'Выйти (' . Yii::app()->user->name . ')', 'url' => ['site/logout'], 'visible' => !Yii::app()->user->isGuest]
                ],
            ]); ?>
        </div>
        <!-- mainmenu -->

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
<p id="back-top" style="z-index:2">
    <a href="#top"><img width="78px" height="78px" src="../../images/arrow_up_84.png"/></a>
</p>
</body>
</html>

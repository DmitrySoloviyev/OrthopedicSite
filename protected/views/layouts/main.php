<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />

	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic&subset=latin,cyrillic-ext,greek-ext,cyrillic,latin-ext,greek' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<meta name="viewport" content="initial-scale=1.0, width=device-width" />

	<!-- <meta name="viewport" content="initial-scale=1.0, width=device-width" /> -->
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>images/shoes.png" type="image/png">
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.fancybox.css" type="text/css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<?php 
	Yii::app()->clientScript->registerScript('display',"
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
	<div class="container" id="page" >
		<a href="https://github.com/DmitrySoloviyev/OrthopedicSite">
		   	<img width="149px" height="149px" style="position: absolute; top: 0; left: 0; border: 0; float:left" src=<?php echo Yii::app()->request->baseUrl; ?>"/images/forkme_left_red.png" alt="Fork me on GitHub" />
		</a>
		<div id="header">
			<code style="position:absolute; font-style: italic; font-size: 12px; color:black; left:120px; top:0px;text-shadow:1px 1px 1px rgba(255,255,255,1.0)">Версия 0.2.3</code>
			<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>

			<div id="navigation">
				<?php $this->widget('zii.widgets.CMenu',array(
					'items'=>array(
						array('label'=>'Главная', 'url'=>array('/site/index')),
						array('label'=>'Новый заказ', 'url'=>array('/site/new')),
						array('label'=>'Все заказы', 'url'=>array('/site/view')),
						array('label'=>'Поиск', 'url'=>array('site/search')),
						array('label'=>'Статистика', 'url'=>array('site/statistics')),
						array('label'=>'Администрирование', 'url'=>array('/site/admin'), 'visible'=>!Yii::app()->user->isGuest),
					//	array('label'=>'Контакты', 'url'=>array('/site/contact')),
						array('label'=>'О сайте', 'url'=>array('/site/page', 'view'=>'about')),
						array('label'=>'Войти', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
						array('label'=>'Выйти ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
					),
				)); ?>
			</div><!-- mainmenu -->

			<div class="form" style="margin:0 100px 4px 100px">
				<?php $form=$this->beginWidget('CActiveForm', array(
							'method'=>'GET', 
							'action'=>'index.php?r=site/view&quickSearch=',
							'id'=>'quickSearchForm',
				)); ?>
				<input type="text" id='quickSearchVal' 
					<?php if(isset($_GET['quickSearchValue'])) echo "value='".$_GET['quickSearchValue']."'"; else echo ""; ?> 
					name="quickSearchValue" autocomplete='Off' placeholder='Поиск по ключевому слову'/>
				<?php $this->endWidget(); ?>
			</div>
		</div><!-- header -->

		<div id="center"><?php echo $content; ?></div>
		<div class="clear"></div>
		<div id="footer"><hr/>
			Copyright &copy; <?php echo date('Y'); ?> by <?php echo CHtml::mailto('Dmitry Soloviyev', 'dmitry.soloviyev@gmail.com')?>.<br/>
			г. Москва. All Rights Reserved.<br/>
			<?php echo Yii::powered(); ?>
		</div><!-- footer -->
	</div><!-- page -->
	<p id="back-top" style="z-index:2"><a href="#top"><img width="78px" height="78px" src="../../images/arrow_up_84.png"></img></a></p>
</body>
</html>
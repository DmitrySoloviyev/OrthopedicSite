<?php
/*
 * Copyright (C) 2012 Dmitry Soloviyev
 *
 * This file is part of Orthopedic website.
 *
 * Orthopedic website is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * Orthopedic website is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Orthopedic website.  If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * Этот файл — часть Orthopedic website.
 *
 * Это свободная программа: вы можете перераспространять ее и/или изменять
 * ее на условиях Стандартной общественной лицензии GNU в том виде, в каком
 * она была опубликована Фондом свободного программного обеспечения; либо
 * версии 3 лицензии, либо (по вашему выбору) любой более поздней версии.
 *
 * Эта программа распространяется в надежде, что она будет полезной,
 * но БЕЗО ВСЯКИХ ГАРАНТИЙ; даже без неявной гарантии ТОВАРНОГО ВИДА
 * или ПРИГОДНОСТИ ДЛЯ ОПРЕДЕЛЕННЫХ ЦЕЛЕЙ. Подробнее см. в Стандартной
 * общественной лицензии GNU.
 *
 * Вы должны были получить копию Стандартной общественной лицензии GNU
 * вместе с этой программой. Если это не так, см. <http://www.gnu.org/licenses/>.
 */
    require_once "m.dblogin.php";
    require_once "m.lib.php";
    ini_set('display_errors',1);
    error_reporting(E_ALL);
    header("Content-Type: text/html; charset=UTF-8");

    if($_SERVER["REQUEST_METHOD"] == 'POST'){
	if($_POST['form'] == 'newempl')
	  new_employee($db, $host, $user, $passwd);
      header("Location: m.index.php");
      exit;
    }
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
	<title>Ортопедическая обувь</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0, width=device-width" />
	<link rel="shortcut icon" href="../images/shoes.png" type="image/png">
	<link rel="stylesheet" href="../css/jquery.fancybox.css" type="text/css" />
	<link rel="stylesheet" href="../css/jquery.mobile-1.3.0.css" type="text/css" />
	
	<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="../js/jquery.jeditable.mini.js"></script>
	<script type="text/javascript" src="../js/jquery.ajaxfileupload.js"></script>
	<script type="text/javascript" src="../js/jquery.jeditable.ajaxupload.js"></script>
	<script type="text/javascript" src="../js/jquery.fancybox.pack.js"></script>
	
	<script type="text/javascript">
	  $(document).bind("pageinit", function(){
	    $("button").bind("tap", function(e){
	      var target = this.id;
	      switch(target){
		case "new":
		  $.mobile.changePage("m.new.php", {
		    transition:"slide"
		  });
		  break;
		case "view":
		  $.mobile.changePage("m.view.php", {
		  transition:"slide"
		  });
		  break;
		case "search":
		  $.mobile.changePage("m.search.php", {
		    transition:"slide"
		  });
		  break;
		case "newdb":
		  $.mobile.changePage("m.newdb.php", {
		    transition:"slide"
		  });
		  break;
		case "delempl":
		  $.mobile.changePage("m.deletemployee.php", {
		    transition:"slide"
		  });
		  break;
		case "about":
		  $.mobile.changePage("m.about.php", {
		    transition:"slide"
		  });
		  break;
	      }
	    });
	  });
	</script>
	<script type="text/javascript" src="../js/jquery.mobile-1.3.1.min.js"></script>
    </head>    
    
    <body>
      <div data-role="page" id="main_page">
	<div data-role="header"><font size="2" >Version 0.1.6.2-beta</font><br>
	  <h1>База данных<br /> ортопедической <br /> обуви</h1>
	</div>

	<div data-role="content">
	
	  <div data-role="controlgroup" >
	    <button id="new">Новая запись</button>
	    <button id="view">Просмотреть базу</button>
	    <button id="search">Поиск</button>
	    <button id="newdb">Работа с БД</button>
	    <button id="delempl">Удалить сотрудника</button>
	    <button id="about">О сайте</button>
	  </div>
	
	  <p><a href="#new_employee" data-role="button" data-rel="dialog">Регистрация</a></p>
	  
	  <p><a href="#employee_list" data-role="button" data-rel="dialog">Наши сотрудники</a></p>
	  
	</div><!--end content-->
      
      <div data-role="footer">
	<?php
	  echo "Москва ".date('Y')."г.<br />&copy;Все права защищены / <a href='mailto:sd_dima@mail.ru'>Обратная связь</a>";
	?><a href="https://github.com/DmitrySoloviyev/OrthopedicSite" >Fork me on GitHub</a>
      </div>
      </div><!--end page-->
      
	    <!-- страница 2 -->
	    <div id="new_employee" data-role="page">
	      <div data-role="header">
		<h1>Окно регистрации</h1>
	      </div>
	      <div data-role="content">
		<form action="m.index.php" method='POST' data-ajax="false">
		    <h3>Представьтесь, пожалуйста</h3>
		    <div>Фамилия</div>
			<input type='text' name='sn' required autocomplete="Off" maxlength="29" autofocus />
		    <div>Имя</div>
			<input type='text' name='fn' required autocomplete="Off" maxlength="29" />
		    <div>Отчество</div>
			<input type='text' name='patr' required autocomplete="Off" maxlength="29" />
		    <input type='hidden' name='form' value='newempl' /><br />
		    <input type='submit' data-role='button' value='Отправить'/>
		</form><br />
		<a href='#' data-icon='back' data-theme='a' data-role='button' data-rel='back'>Назад</a>
	      </div>
	    </div>
      
      <!-- страница 3 -->
	    <div id="employee_list" data-role="page">
	      <div data-role="header">
		<h1>Наши сотрудники</h1>
	      </div>
	      <div data-role="content">
		<ul data-role="listview">
		  <?=get_employee_list($db, $host, $user, $passwd)?>
		</ul><br />
		<p><a href='#' data-icon='back' data-theme='a' data-role='button' data-rel='back'>Назад</a></p>
	      </div>
	    </div>

    </body>
</html>
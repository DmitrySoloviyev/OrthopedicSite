<?
/***
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
 **/
 require_once "m.dblogin.php";
 require_once "m.lib.php";
 header("Content-Type: text/html; charset=UTF-8");
 
 if($_SERVER["REQUEST_METHOD"] == 'POST'){
   switch($_POST['form']){
     case "backupdb": backup_db($db, $host, $user, $passwd);
       break;
     case "recoverydb": recovery_db($db, $host, $user, $passwd);
       break;
     case "optimizedb": optimizedb($db, $host, $user, $passwd);
       break;
   }
  header("Location: m.newdb.php");
  exit;
 }
?>
 <!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, width=device-width" />
    <link rel="stylesheet" href="../css/jquery.mobile-1.3.0.css" type="text/css" />
    <script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="../js/jquery.mobile-1.3.1.min.js"></script>
    <script type="text/javascript">
      $(document).bind("pageinit", function(){
	$(".nav").bind("tap", function(e){
	  var target = this.id == 'next' ? 'm.deletemployee.php':'m.search.php';
	  $.mobile.changePage(target, {
	    revers: (target == 'm.search.php')
	  });
	});
      });
    </script>
  </head>
  <body>
      <div data-role="page" id="page_new_db">
	  <div data-role="header">
	    <h1>Работа с БД</h1>
	    <a href="m.index.php" data-icon="home" data-role='button'>Домой</a>
	  </div>
	  
	  <div data-role="content">
	      <br/>
	      Сделать резервную копию Базы Данных и сохранить к себе на компьютер:
	      <form action="m.newdb.php" method="POST" data-ajax="false">
		  <input type="submit" class="button" value="Сделать резервную копию" />
		  <input type="hidden" name="form" value="backupdb" />
	      </form><br />
	      </p>
	      <p>
	      Восстановить Базу Данных из сохраненной ранее резервной копии:
	      <form action="m.newdb.php" method="POST" enctype="multipart/form-data" data-ajax="false">
		  <input type="file" class="button" name="new_db" />
		  <input type="submit" class="button" value="Восстановить" name="new_db" />
		  <input type="hidden" name="form" value="recoverydb" />
	      </form>
	      </p><br />
	      Оптимизировать базу данных:
	      <form action="m.newdb.php" method="POST" data-ajax="false">
		  <input type="submit" class="button" value="Оптимизация" />
		  <input type="hidden" name="form" value="optimizedb" />
	      </form>
	      <br />
	      <div>
		<i><a href="m.index.php?id=about#3">Подробности...</a></i>
	      </div>
	  <div>
      <div>
  </body>
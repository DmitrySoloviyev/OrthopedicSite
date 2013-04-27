<?
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
 header("Content-Type: text/html; charset=UTF-8");
 session_start();
 $search = serialize($_POST);
 $_SESSION['search_query'] = $search;
 if(!empty($_SESSION['search_query']))
    $search_query = unserialize($_SESSION['search_query']);
    
 if($_SERVER["REQUEST_METHOD"] == 'POST'){
    if($_POST['form'] == 'search'){
      echo "<!DOCTYPE html>
	    <html>
	      <head>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
		<meta name='viewport' content='initial-scale=1.0, width=device-width' />
		<link rel='stylesheet' href='../css/jquery.mobile-1.3.0.css' type='text/css' />
		<script type='text/javascript' src='../js/jquery-1.9.1.min.js'></script>
		<script type='text/javascript' src='../js/jquery.mobile-1.3.1.min.js'></script>
	      </head>
	    <body>
	      <div data-role='page' id='search_result'>
		<div data-role='header'>
		  <h1>Результаты поиска</h1>
		</div>
		<div data-role='content'>
		  <a href='#' data-icon='back' data-theme='b' data-role='button' data-rel='back' data-inline='true'>Назад</a>";
	search($db, $host, $user, $passwd);
      echo "</div></div></body></html>";
    }
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
	  var target = this.id == 'next' ? 'm.newdb.php':'m.view.php';
	  $.mobile.changePage(target, {
	    revers: (target == 'm.view.php')
	  });
	});
      });
    </script>
  </head>
<body>
<div data-role="page" id="search">
  <div data-role="header">
    <h1>Поиск</h1>
    <a href="m.index.php" data-icon="home" data-role='button'>Домой</a>
  </div>
    <div data-role="content">
    <form action="m.search.php" method="POST" id="search" data-ajax="false">
	    № заказа:
	    <input type="text" name="orderID" autocomplete="Off" value="<?php if(!empty($search_query['orderID'])) echo $search_query['orderID'];?>" />

	    Модель:
	    <input type="text" name="model" value="<?php if(!empty($search_query['model'])) echo $search_query['model']?>" autocomplete="Off" id="model" />

	    Размер:
	    <input type="text" name="size" value="<?php if(!empty($search_query['size'])) echo $search_query['size']?>" autocomplete="Off"/>

	    УРК:
	    <input type="text" name="urk" value="<?php if(!empty($search_query['urk'])) echo $search_query['urk']?>" autocomplete="Off"/>

	    Материал:
	      <fieldset data-role="controlgroup">
		<label><input type="checkbox" value="mk" name="material[]" <?php if(isset($search_query['material']) and in_array('mk',$search_query['material'])) echo "checked";?> />К/П</label>
		<label><input type="checkbox" value="mt" name="material[]" <?php if(isset($search_query['material']) and in_array('mt',$search_query['material'])) echo "checked";?> />Траспира</label>
		<label><input type="checkbox" value="mn" name="material[]" <?php if(isset($search_query['material']) and in_array('mn',$search_query['material'])) echo "checked";?> />Мех Натуральный</label>
		<label><input type="checkbox" value="ma" name="material[]" <?php if(isset($search_query['material']) and in_array('ma',$search_query['material'])) echo "checked";?> />Мех Искусственный</label>
		<label><input type="checkbox" value="mw" name="material[]" <?php if(isset($search_query['material']) and in_array('mw',$search_query['material'])) echo "checked";?> />Мех Полушерстяной</label>
	      </fieldset>

	    Высота:
	    <input type="text" name="height" value="<?php if(!empty($search_query['height'])) echo $search_query['height']?>" autocomplete="Off" />

	    Объем верха:
	    <input type="text" name="top_volume" value="<?php if(!empty($search_query['top_volume'])) echo $search_query['top_volume']?>" autocomplete="Off" />

	    Объем лодыжки:
	    <input type="text" name="ankle_volume" value="<?php if(!empty($search_query['ankle_volume'])) echo $search_query['ankle_volume']?>" autocomplete="Off" />

	    Объем КВ:
	    <input type="text" name="kv_volume" value="<?php if(!empty($search_query['kv_volume'])) echo $search_query['kv_volume']?>" autocomplete="Off" />

	    Заказчик:
	    <table>
		<tr>
		  <td>Фамилия</td>
		  <td><input type='text'  name="CustomerSN" maxlength="25" value="<?php if(!empty($search_query['CustomerSN'])) echo $search_query['CustomerSN']?>" autocomplete="Off" /></td>
		</tr>
		<tr>
		  <td>Имя</td>
		  <td><input type='text'  name="CustomerFN" maxlength="25" value="<?php if(!empty($search_query['CustomerFN'])) echo $search_query['CustomerFN']?>" autocomplete="Off" /></td>
		</tr>
		<tr>
		  <td>Отчество</td>
		  <td><input type='text'  name="CustomerP"  maxlength="25" value="<?php if(!empty($search_query['CustomerP'])) echo $search_query['CustomerP']?>" autocomplete="Off" /></td>
		</tr>
	    </table>
	    Модельер:
	      <select name="designer">
		<option disabled='disabled' selected='selected'>Ф.И.О Модельера</option>
		<?=get_employee_list($db, $host, $user, $passwd, "search")?>
	      </select>
		<input type="submit" class="button" value="Искать!" data-icon='search'/>
		<input type="reset" class="button" value="Сброс" />
		<input type="hidden" name="form" value="search" />
    </form>
    </div>
  </div>
</body>
</html>
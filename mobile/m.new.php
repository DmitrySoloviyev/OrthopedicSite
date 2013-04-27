<?php
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
    if($_POST['form'] == 'neworder')
      new_order($db, $host, $user, $passwd);
  header("Location: m.new.php");
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
	  var target = this.id == 'next' ? 'm.view.php':'m.index.php';
	  $.mobile.changePage(target, {
	    revers: (target == 'm.index.php')
	  });
	});
	
      });
    </script>
  </head>

<body>
<div data-role="page" id="new_order">
  <div data-role="header">
    <h1>Новый заказ</h1>
    <a href="m.index.php" data-icon="home" data-role='button'>Домой</a>
  </div>
  <div data-role="content">
    <form action="m.new.php" method="POST" id="neworder" data-ajax="false">
      <fieldset>
	    № заказа:
	    <input type="text" name="orderID" maxlength="10" autofocus required autocomplete="Off" id="orderID" />

	    Модель:
	    <input type="text" name="model" maxlength="6" autocomplete="Off" required id="model" pattern="[^ ].{1,6}" />

	    Размер:
	    <input type="text" name="size" maxlength="5" required autocomplete="Off" pattern="\d\d(\s\d\d)?" />

	    УРК
	    <input type="text" name="urk" maxlength="7" min="100" max="400" required autocomplete="Off" pattern="[1-4]\d\d(\s[1-4]\d\d)?" />

	    Материал:
	      <select name="material">
		<option value="mk">К/П</option>
		<option value="mt">Траспира</option>
		<option value="mn">Мех Натуральный</option>
		<option value="ma">Мех Искусственный</option>
		<option value="mw">Мех Полушерстяной</option>
	      </select>  

	    Высота:
	    <input type="text" name="height" maxlength="5" required autocomplete="Off" />

	    Объем верха:
	    <input type="text" name="top_volume" maxlength="9" required autocomplete="Off" pattern="[1-5][0-9](\.[50])?(\s[1-5][0-9](\.[50])?)?" />

	    Объем лодыжки:
	    <input type="text" name="ankle_volume" maxlength="9" required autocomplete="Off" pattern="[1-5][0-9](\.[50])?(\s[1-5][0-9](\.[50])?)?" />

	  
	    Объем КВ:
	    <input type="text" name="kv_volume" maxlength="9" required autocomplete="Off" pattern="[1-7][0-9](\.[50])?(\s[1-7][0-9](\.[50])?)?" />

	  
	    Заказчик:
	      <table>
		<tr>
		  <td>Фамилия</td>
		  <td><input type="text" name="customerSN" maxlength="29" required autocomplete="Off" /></td>
		</tr>
		  <td>Имя</td>
		  <td><input type="text" name="customerFN" maxlength="29" required autocomplete="Off" /></td>
		</tr>
		<tr>
		  <td>Отчество</td>
		  <td><input type="text" name="customerP" maxlength="29" required autocomplete="Off" /></td>
		</tr>
	      </table>
	  
	    Модельер:
	      <select name="designer" required>
		<option disabled='disabled' selected='selected'>Ф.И.О Модельера</option>
		<?=get_employee_list($db, $host, $user, $passwd, "option")?>
	      </select>
	  
	    Комментарий:
	    <textarea name="comment" maxlength="99"></textarea>
		<input type="submit" class="button" value="Отправить" />
		<input type="reset" class="button" value="Сброс"/>
		<input type="hidden" name="form" value="neworder" />
      </fieldset>
    </form>
  </div>
</div>
<div id="hint">
  <i>Дробные числа обязательно<br />вводить через точку.</i>
</div>

<!-- всплывающее окно описания модели -->
<div id="model_info" type="hidden">
  <a href="#" id="close_model_info"></a>
  <div id="nav" >
    <span id="new_picture"><img src="../images/image.png" /></span>
    <span id="previous"><img src="../images/previous.png" /></span>
    <span id="next"><img src="../images/next.png" /></span>
  </div>

    <img src="../images/ortho.jpg" id="picture"></img>
  
  <p id="description_model">Описание модели №</p>
  <p id="description" maxlength="199">
    Размерный ряд
    Фасон колодки
    Фасон подошвы
  </p>
  
  <div id="metainfo">
<!--     <a href="#" id="readmore">Читать далее</a> -->
    <span id="author">Автор: </span><br />
    <span id="date">Изменен: </span>
  </div>
</div><!--64Кбайта-->
</body>
</html>
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

  require_once "dblogin.php";
  require_once "lib.php";

//   $q = strtolower($_GET["q"]);
  $q = $_GET["term"];
  if (!$q) return;
  
  $connection = mysql_connect($host, $user, $passwd) or die ("Возникла непредвиденная ошибка.<br />
							      Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							      Спасибо.".reporting_log("Не удалось установить соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
  mysql_select_db($db) or die ("Возникла непредвиденная ошибка.<br />
				Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				Спасибо.".reporting_log("Не удалось подключиться к базе данных $db.",mysql_error(),__FILE__,__LINE__));
  $query = "SELECT ModelID FROM Model WHERE ModelID LIKE '%".$q."%'";
  $result = mysql_query($query)or die ("Возникла непредвиденная ошибка.<br />
					Ваш запрос не может быть выполнен.<br />
					Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
					Спасибо.".reporting_log("Не удалось выполнить автозаполение для модели.",mysql_error(),__FILE__,__LINE__));
//   mysql_close($connection) or die ("Возникла непредвиденная ошибка.<br />
// 				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
// 				    Спасибо.".reporting_log("Не удалось закрыть соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));

$res_arr = array();  

  while($search_array = mysql_fetch_assoc($result)){
    array_push($res_arr, $search_array['ModelID']);
  }
  echo json_encode($res_arr);

?>
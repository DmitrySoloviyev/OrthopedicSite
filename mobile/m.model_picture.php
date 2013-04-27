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
  $model_id = $_GET['id'];
  $cause = $_GET['cause'];
  
switch($cause){
  case "upload_file":
      if(!empty($model_id)){
      //вытаскиваем изображение из временной директории
      if(!empty($_FILES['value']['name'])) {// Проверяем пришел ли файл
	if($_FILES['value']['size'] > 65536){//проверяем размер файла
	  echo "Размер файла превышает 64 Кбайта";
	  break;
	}
	if($_FILES['value']['error'] == 0) {// Проверяем, что при загрузке не произошло ошибок
	  if(substr($_FILES['value']['type'], 0, 5)=='image') {// Если файл загружен успешно, то проверяем - графический ли он 
	    $tmp = $_FILES['value']['tmp_name'];
	    $name = $_FILES['value']['name'];
	    move_uploaded_file($tmp, $name);
	  }else{
	    echo "Ошибка загрузки файла 1. Попробуйте еще раз!";
	    reporting_log("Ошибка загрузки изображения.","",__FILE__,__LINE__);
	    return;
	  }
	}else{
	  echo "Ошибка загрузки файла 2. Попробуйте еще раз!";
	  reporting_log("Ошибка загрузки изображения.","",__FILE__,__LINE__);
	  return;
	}
      }else{
	echo "<img src='../images/image.png' />";
	reporting_log("Ошибка загрузки изображения.","",__FILE__,__LINE__);
	return;
      }
      $connection = mysql_connect($host, $user, $passwd) or die ("Возникла непредвиденная ошибка.<br />
								  Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
								  Спасибо.".reporting_log("Не удалось установить соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
      mysql_select_db($db) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Не удалось подключиться к базе данных $db.",mysql_error(),__FILE__,__LINE__));
      //сначала необходимо узнать какой идентификатор к нам пришел, есть ли соответствующая ему модель в базе
      $check_id = "SELECT ModelID FROM Model WHERE ModelID='".$model_id."'";
      $result_id = mysql_query($check_id) or die ("Возникла непредвиденная ошибка.<br /> Ваш запрос не может быть выполнен.<br />
						  Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
						  Спасибо.".reporting_log("Не удалось узнать id модели.",mysql_error(),__FILE__,__LINE__));
      $num = mysql_num_rows($result_id);     
      $picture = file_get_contents($name);
      $picture = mysql_real_escape_string($picture);
      unlink("$name");//удаляем картинку из временного каталога
      
      if($num == 1){//если такая модель есть то мы просто помещаем изображение к ней
	$query_edit_author = "UPDATE Model SET ModelPicture='".$picture."' WHERE ModelID='".$model_id."'";
	$status = mysql_query($query_edit_author) or die ("Возникла непредвиденная ошибка.<br /> Ваш запрос не может быть выполнен.<br />
							    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							    Спасибо.".reporting_log("Не удалось обновить описание модели.",mysql_error(),__FILE__,__LINE__));
	if($status){
	  echo "Загружено";
	}else{
	  echo "Возникла ошибка...";
	}
      }else{
	$query_new_author = "INSERT INTO Model(ModelID, ModelPicture) VALUES('".$model_id."', '".$picture."')";
	$status = mysql_query($query_new_author) or die ("Возникла непредвиденная ошибка.<br /> Ваш запрос не может быть выполнен.<br />
							  Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							  Спасибо.".reporting_log("Не удалось записать новую модель с описанием.",mysql_error(),__FILE__,__LINE__));
	if($status){
	  echo "Загружено";
	}else{
	  echo "Возникла ошибка...";
	}
      }
    }else{
      echo "<script>alert(К какой моделе добавить изображение? Заполните поле \"Модель\")</alert>";
    }
    break;
  case "show_picture":
    if(!empty($model_id)){
	//для начала необходимо узнать есть ли модель с таким id в базе
	//если есть то выводим ее изображение
	//если нет, то выводим изображение по умолчанию
	  $connection = mysql_connect($host, $user, $passwd) or die ("Возникла непредвиденная ошибка.<br />
								      Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
								      Спасибо.".reporting_log("Не удалось установить соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
	  mysql_select_db($db) or die ("Возникла непредвиденная ошибка.<br />
					Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
					Спасибо.".reporting_log("Не удалось подключиться к базе данных $db.",mysql_error(),__FILE__,__LINE__));

	  //сначала необходимо узнать какой идентификатор к нам пришел, есть ли соответствующая ему модель в базе
	  $check_id = "SELECT ModelID FROM Model WHERE ModelID='".$model_id."'";
	  $result_id = mysql_query($check_id) or die ("Возникла непредвиденная ошибка.<br /> Ваш запрос не может быть выполнен.<br />
						      Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
						      Спасибо.".reporting_log("Не удалось узнать id модели.",mysql_error(),__FILE__,__LINE__));
	  $num = mysql_num_rows($result_id);      
	  if($num == 1){
	    $query_pic = "SELECT ModelPicture FROM Model WHERE ModelID='".$model_id."'";
	    $resimg = mysql_query($query_pic) or die ("Возникла непредвиденная ошибка.<br /> Ваш запрос не может быть выполнен.<br />
							Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							Спасибо.".reporting_log("Не удалось обновить описание модели.",mysql_error(),__FILE__,__LINE__));
	    if($resimg){
	      $arr_img = mysql_fetch_assoc($resimg);
	      header("Content-type: image/gif");
	      echo $arr_img['ModelPicture'];
	    }else{
	      echo 0;
	    }
	  }else{
	    echo 0;
	  }
	}else{
	  echo 0;
	}
    break;
  }
?>
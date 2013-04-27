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
  $model_id = $_POST['id'];
  $cause = $_POST['cause'];
  switch($cause){
    case "watch"://просмотр информации о модели
    
      $connection = mysql_connect($host, $user, $passwd) or die ("Возникла непредвиденная ошибка.<br /> Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
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
      if($num == 1){//такая модель есть, извлекаем информацию
	$query_get_info = "SELECT ModelID, ModelDescription, Author, DateModified
			   FROM Model
			   WHERE ModelID='".$model_id."'";
	$result_info = mysql_query($query_get_info) or die ("Возникла непредвиденная ошибка.<br /> Ваш запрос не может быть выполнен.<br />
							    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							    Спасибо.".reporting_log("Не удалось вывести информацию о модели.",mysql_error(),__FILE__,__LINE__));
	$result_info_array = mysql_fetch_assoc($result_info);
	echo json_encode($result_info_array);
      }else{
	echo '{"empty": "Такой модели еще нет в базе. Вы можете добавить к ней описание..."}';
      }
      mysql_close($connection) or die ("Возникла непредвиденная ошибка.<br />
					Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
					Спасибо.".reporting_log("Не удалось закрыть соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
      break;
    case "next":
	$connection = mysql_connect($host, $user, $passwd) or die ("Возникла непредвиденная ошибка.<br /> Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
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
	  //если есть такая модель с таким ID, то считываем ее дату, и...
	  $get_date = "SELECT DateModified
		       FROM Model
		       WHERE ModelID='".$model_id."'";
	  $result_date = mysql_query($get_date) or die ("Возникла непредвиденная ошибка.<br /> Ваш запрос не может быть выполнен.<br />
							Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							Спасибо.".reporting_log("Не удалось считать дату текущей модели.",mysql_error(),__FILE__,__LINE__));
	  $arr_date = mysql_fetch_assoc($result_date);
	  $date = $arr_date['DateModified'];
	  //...выбираем модель с датой, следующей за выбранной и отдаем идентификатор этой модели
	  $query_next = "SELECT ModelID
			 FROM Model 
		         WHERE DateModified > '".$date."' ORDER BY DateModified LIMIT 1";
	  $result = mysql_query($query_next) or die ("Возникла непредвиденная ошибка.<br /> Ваш запрос не может быть выполнен.<br />
						    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
						    Спасибо.".reporting_log("Не удалось загрузить следующую модель.",mysql_error(),__FILE__,__LINE__));
	  $is_end = mysql_num_rows($result);
	  if($is_end){//выводим id следующей модели
	    $arr_id_next = mysql_fetch_assoc($result);
	    echo $arr_id_next['ModelID'];
	  }else{
	    //если следующей модели нет, то надобы начать с первой и вернуть ее id
	    $query_again = "SELECT ModelID FROM Model ORDER BY DateModified ASC LIMIT 1";
	    $result_again = mysql_query($query_again) or die ("Возникла непредвиденная ошибка.<br /> Ваш запрос не может быть выполнен.<br />
							      Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							      Спасибо.".reporting_log("Не удалось загрузить следующую модель в новой итерации.",mysql_error(),__FILE__,__LINE__));
	    $arr_again = mysql_fetch_assoc($result_again);
	    echo $arr_again['ModelID'];
	  }
	}else{
	  //иначе, если такой модели с таким идентификатором нет в базе, ищем ближайшую модель к введенному идентификатору, считываем ее дату, и...
	  $query_near_id = "SELECT ModelID FROM Model WHERE ModelID > '".$model_id."' LIMIT 1";
	  $result_near_id = mysql_query($query_near_id) or die ("Возникла непредвиденная ошибка.<br /> Ваш запрос не может быть выполнен.<br />
								Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
								Спасибо.".reporting_log("Не удалось определить ближайший ID модели.",mysql_error(),__FILE__,__LINE__));
	  $num_near = mysql_num_rows($result_near_id);
	  if($num_near){//выводим id следующей ближайшей модели
	    $arr_near = mysql_fetch_assoc($result_near_id);
	    echo $arr_near['ModelID'];
	  }else{
	    //если следующей модели нет, то надобы начать с первой и вернуть ее id
	    $query_again = "SELECT ModelID FROM Model ORDER BY DateModified ASC LIMIT 1";
	    $result_again = mysql_query($query_again) or die ("Возникла непредвиденная ошибка.<br /> Ваш запрос не может быть выполнен.<br />
							      Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							      Спасибо.".reporting_log("Не удалось загрузить следующую модель в новой итерации.",mysql_error(),__FILE__,__LINE__));
	    $arr_again = mysql_fetch_assoc($result_again);
	    echo $arr_again['ModelID'];
	  }
	}
	mysql_close($connection) or die ("Возникла непредвиденная ошибка.<br />
					  Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
					  Спасибо.".reporting_log("Не удалось закрыть соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
	break;
    case "previous":
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
	  //если есть такая модель с таким ID, то считываем ее дату, и...
	  $get_date = "SELECT DateModified
		       FROM Model
		       WHERE ModelID='".$model_id."'";
	  $result_date = mysql_query($get_date) or die ("Возникла непредвиденная ошибка.<br /> Ваш запрос не может быть выполнен.<br />
							Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							Спасибо.".reporting_log("Не удалось считать дату текущей модели.",mysql_error(),__FILE__,__LINE__));
	  $arr_date = mysql_fetch_assoc($result_date);
	  $date = $arr_date['DateModified'];
	  //...выбираем модель с датой, предшествующей перед выбранной и отдаем идентификатор этой модели
	  $query_previous = "SELECT ModelID
			     FROM Model 
			     WHERE DateModified < '".$date."' ORDER BY DateModified DESC LIMIT 1";
	  $result = mysql_query($query_previous) or die ("Возникла непредвиденная ошибка.<br /> Ваш запрос не может быть выполнен.<br />
							  Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							  Спасибо.".reporting_log("Не удалось загрузить следующую модель.",mysql_error(),__FILE__,__LINE__));
	  $is_end = mysql_num_rows($result);
	  if($is_end){//выводим id предыдущей модели
	    $arr_id_previous = mysql_fetch_assoc($result);
	    echo $arr_id_previous['ModelID'];
	  }else{
	    //если предыдущей модели нет, то надобы начать с последней и вернуть ее id
	    $query_again = "SELECT ModelID FROM Model ORDER BY DateModified DESC LIMIT 1";
	    $result_again = mysql_query($query_again) or die ("Возникла непредвиденная ошибка.<br /> Ваш запрос не может быть выполнен.<br />
							      Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							      Спасибо.".reporting_log("Не удалось загрузить следующую модель в новой итерации.",mysql_error(),__FILE__,__LINE__));
	    $arr_again = mysql_fetch_assoc($result_again);
	    echo $arr_again['ModelID'];
	  }
	}else{
	  //иначе, если такой модели с таким идентификатором нет в базе, ищем ближайшую модель к введенному идентификатору, считываем ее дату, и...
	  $query_near_id = "SELECT ModelID FROM Model WHERE ModelID < '".$model_id."' LIMIT 1";
	  $result_near_id = mysql_query($query_near_id) or die ("Возникла непредвиденная ошибка.<br /> Ваш запрос не может быть выполнен.<br />
								Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
								Спасибо.".reporting_log("Не удалось определить ближайший ID модели.",mysql_error(),__FILE__,__LINE__));
	  $num_near = mysql_num_rows($result_near_id);
	  if($num_near){//выводим id следующей ближайшей модели
	    $arr_near = mysql_fetch_assoc($result_near_id);
	    echo $arr_near['ModelID'];
	  }else{
	    //если предыдущей модели нет, то надобы начать с первой и вернуть ее id
	    $query_again = "SELECT ModelID FROM Model ORDER BY DateModified DESC LIMIT 1";
	    $result_again = mysql_query($query_again) or die ("Возникла непредвиденная ошибка.<br /> Ваш запрос не может быть выполнен.<br />
							      Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							      Спасибо.".reporting_log("Не удалось загрузить следующую модель в новой итерации.",mysql_error(),__FILE__,__LINE__));
	    $arr_again = mysql_fetch_assoc($result_again);
	    echo $arr_again['ModelID'];
	  }
	}						
	mysql_close($connection) or die ("Возникла непредвиденная ошибка.<br />
					  Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
					  Спасибо.".reporting_log("Не удалось закрыть соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
      break;
    case "edit_description":
	if(!empty($model_id)){
	  $description = $_POST['value'];
	//для начала необходимо узнать есть ли модель с таким id в базе
	//если есть то обновляем ее описание
	//если нет, то сначала добавляем модель в базу с описанием
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
	    $query_edit = "UPDATE Model SET ModelDescription='".$description."' WHERE ModelID='".$model_id."'";
	    $status = mysql_query($query_edit) or die ("Возникла непредвиденная ошибка.<br /> Ваш запрос не может быть выполнен.<br />
							Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							Спасибо.".reporting_log("Не удалось обновить описание модели.",mysql_error(),__FILE__,__LINE__));
	    if($status){
	      echo $description;
	    }else{
	      echo "Возникла ошибка...";
	    }
	  }else{
	    $query_new_model = "INSERT INTO Model(ModelID, ModelDescription) VALUES('".$model_id."', '".$description."')";
	    $status = mysql_query($query_new_model) or die ("Возникла непредвиденная ошибка.<br /> Ваш запрос не может быть выполнен.<br />
							    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							    Спасибо.".reporting_log("Не удалось записать новую модель с описанием.",mysql_error(),__FILE__,__LINE__));
	    if($status){
	      echo $description;
	    }else{
	      echo "Возникла ошибка...";
	    }
	  }
	}else{
	  echo "К какой моделе добавить описание? Заполните поле \"Модель\"";
	}
      break;//end edit_description
    case "edit_author":
	if(!empty($model_id)){
	  $description = $_POST['value'];
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
	    $query_edit_author = "UPDATE Model SET Author='".$description."' WHERE ModelID='".$model_id."'";
	    $status = mysql_query($query_edit_author) or die ("Возникла непредвиденная ошибка.<br /> Ваш запрос не может быть выполнен.<br />
								Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
								Спасибо.".reporting_log("Не удалось обновить описание модели.",mysql_error(),__FILE__,__LINE__));
	    if($status){
	      echo $description;
	    }else{
	      echo "Возникла ошибка...";
	    }
	  }else{
	    $query_new_author = "INSERT INTO Model(ModelID, Author) VALUES('".$model_id."', '".$description."')";
	    $status = mysql_query($query_new_author) or die ("Возникла непредвиденная ошибка.<br /> Ваш запрос не может быть выполнен.<br />
							      Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							      Спасибо.".reporting_log("Не удалось записать новую модель с описанием.",mysql_error(),__FILE__,__LINE__));
	    if($status){
	      echo "Автор: ".$description;
	    }else{
	      echo "Возникла ошибка...";
	    }
	  }
	}else{
	  echo "К какой моделе добавить автора? Заполните поле \"Модель\"";
	}
      break;//end edit_author
  }//end switch
?>

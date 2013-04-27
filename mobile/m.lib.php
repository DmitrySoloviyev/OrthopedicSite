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
 
  /*
   *SN - second name - фамилия
   *FN - first name - имя
   *P - patronymic - отчество
   */

/************************************функция проверки существования и создания БД и таблиц в случае их отсутствия******************/
function is_db_set($db, $host, $user, $passwd){
  //проверка существования Базы Данных
  $connection = mysql_connect($host, $user, $passwd) or die ("Возникла непредвиденная ошибка.<br />
							      Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							      Спасибо.".reporting_log("Не удалось установить соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
    if(!mysql_select_db($db)){
	$query = "CREATE DATABASE IF NOT EXISTS $db DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";//создаем БД
	mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Не удается создать базу $db!",mysql_error(),__FILE__,__LINE__));
	reporting_log("Базы $db не было, но мы ее создали!","",__FILE__,__LINE__);
		
	mysql_select_db($db) or die ("Возникла непредвиденная ошибка.<br />
				      Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				      Спасибо.".reporting_log("Не удалось подключиться к базе данных $db.",mysql_error(),__FILE__,__LINE__));
      /*
       *создаем таблицы в базе
       *сначала создаются ссылочные (родительские) таблицы - не содержащие внешних ключей, они должны быть созданы до того,
       *как будут созданы таблицы, ссылающиеся на них (дочерние)
       *затем, последними, создаются таблицы, содержащие внешние ключи (Orders - дочерняя таблица)
       */

//таблица Модель
	$query = "CREATE TABLE IF NOT EXISTS Model
		(
		  ModelID VARCHAR(6) NOT NULL PRIMARY KEY,
		  ModelDescription VARCHAR(200) NOT NULL DEFAULT 'нет описания',
		  Author VARCHAR(30) NOT NULL DEFAULT 'неизвестный',
		  ModelPicture BLOB,
		  DateModified TIMESTAMP
		)ENGINE=INNODB";
	mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Ошибка при создании таблицы Model!",mysql_error(),__FILE__,__LINE__));
	reporting_log("Создана таблица Model!","",__FILE__,__LINE__);
       
//таблица Размеров
	$query = "CREATE TABLE IF NOT EXISTS Sizes
		(
		  SizeID CHAR(3) NOT NULL PRIMARY KEY,
		  SizeValue TINYINT(2) UNSIGNED NOT NULL,
		  INDEX (SizeValue)
		)ENGINE=INNODB";
	mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Ошибка при создании таблицы Sizes!",mysql_error(),__FILE__,__LINE__));
	reporting_log("Создана таблица Sizes!","",__FILE__,__LINE__);
	
//таблица УРК
	$query = "CREATE TABLE IF NOT EXISTS Urk
		(
		  UrkID CHAR(4) NOT NULL PRIMARY KEY,
		  UrkValue SMALLINT(3) UNSIGNED NOT NULL,
		  INDEX (UrkValue)
		)ENGINE=INNODB";
	mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Ошибка при создании таблицы Urk!",mysql_error(),__FILE__,__LINE__));
	reporting_log("Создана таблица Urk!","",__FILE__,__LINE__);

//таблица Материалов
	$query = "CREATE TABLE IF NOT EXISTS Materials
		(
		  MaterialID CHAR(2) NOT NULL PRIMARY KEY,
		  MaterialValue ENUM('КП', 'Траспира', 'Мех Натуральный', 'Мех Искусственный', 'Мех Полушерстяной') NOT NULL,
		  INDEX (MaterialValue)
		)ENGINE=INNODB";
	mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Ошибка при создании таблицы Materials!",mysql_error(),__FILE__,__LINE__));
	reporting_log("Создана таблица Materials!","",__FILE__,__LINE__);

//таблица высоты
	$query = "CREATE TABLE IF NOT EXISTS Height
		(
		  HeightID CHAR(3) NOT NULL PRIMARY KEY,
		  HeightValue TINYINT(2) UNSIGNED NOT NULL,
		  INDEX (HeightValue)
		)ENGINE=INNODB";
	mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Ошибка при создании таблицы Height!",mysql_error(),__FILE__,__LINE__));
	reporting_log("Создана таблица Height!","",__FILE__,__LINE__);

//таблица Объем Верха
	$query = "CREATE TABLE IF NOT EXISTS TopVolume
		(
		  TopVolumeID CHAR(4) NOT NULL PRIMARY KEY,
		  TopVolumeValue FLOAT(3,1) UNSIGNED NOT NULL,
		  INDEX (TopVolumeValue)
		)ENGINE=INNODB";
	mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Ошибка при создании таблицы TopVolume!",mysql_error(),__FILE__,__LINE__));
	reporting_log("Создана таблица TopVolume!","",__FILE__,__LINE__);

//таблица Объем Лодыжки
	$query = "CREATE TABLE IF NOT EXISTS AnkleVolume
		(
		  AnkleVolumeID CHAR(4) NOT NULL PRIMARY KEY,
		  AnkleVolumeValue FLOAT(3,1) UNSIGNED NOT NULL,
		  INDEX (AnkleVolumeValue)
		)ENGINE=INNODB";
	mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Ошибка при создании таблицы AnkleVolume!",mysql_error(),__FILE__,__LINE__));
	reporting_log("Создана таблица AnkleVolume!","",__FILE__,__LINE__);

//таблица Объем КВ
	$query = "CREATE TABLE IF NOT EXISTS KvVolume
		(
		  KvVolumeID CHAR(4) NOT NULL PRIMARY KEY,
		  KvVolumeValue FLOAT(3,1) UNSIGNED NOT NULL,
		  INDEX (KvVolumeValue)
		)ENGINE=INNODB";
	mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Ошибка при создании таблицы KvVolume!",mysql_error(),__FILE__,__LINE__));
	reporting_log("Создана таблица KvVolume!","",__FILE__,__LINE__);

//таблица Сотрудников фирмы
	$query = "CREATE TABLE IF NOT EXISTS Employees
		(
		  EmployeeID TINYINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  EmployeeSN VARCHAR(30) NOT NULL,
		  EmployeeFN VARCHAR(30) NOT NULL,
		  EmployeeP VARCHAR(30) NOT NULL,
		  STATUS ENUM('Работает', 'Уволен') NOT NULL DEFAULT 'Работает'
		)ENGINE=INNODB";
	mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Ошибка при создании таблицы Employees!",mysql_error(),__FILE__,__LINE__));
	reporting_log("Создана таблица Employees!","",__FILE__,__LINE__);
	
//таблица Заказчиков
	$query = "CREATE TABLE IF NOT EXISTS Customers
		(
		  CustomerID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  CustomerSN VARCHAR(30) NOT NULL,
		  CustomerFN VARCHAR(30) NOT NULL,
		  CustomerP VARCHAR(30) NOT NULL
		)ENGINE=INNODB";
	mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Ошибка при создании таблицы Customers!",mysql_error(),__FILE__,__LINE__));
	reporting_log("Создана таблица Customers!","",__FILE__,__LINE__);
	
//таблица Заказов
	$query = "CREATE TABLE IF NOT EXISTS Orders
		(
		  OrderID VARCHAR(10) NOT NULL PRIMARY KEY,
		  ModelID VARCHAR(6) NOT NULL,
		  SizeLEFT CHAR(3) NOT NULL,
		  SizeRIGHT CHAR(3) NOT NULL,
		  UrkLEFT CHAR(4) NOT NULL,
		  UrkRIGHT CHAR(4) NOT NULL,
		  MaterialID CHAR(2) NOT NULL,
		  HeightLEFT CHAR(3) NOT NULL,
		  HeightRIGHT CHAR(3) NOT NULL,
		  TopVolumeLEFT CHAR(4) NOT NULL,
		  TopVolumeRIGHT CHAR(4) NOT NULL,
		  AnkleVolumeLEFT CHAR(4) NOT NULL,
		  AnkleVolumeRIGHT CHAR(4) NOT NULL,
		  KvVolumeLEFT CHAR(4) NOT NULL,
		  KvVolumeRIGHT CHAR(4) NOT NULL,
		  CustomerID INT UNSIGNED NOT NULL,
		  EmployeeID TINYINT UNSIGNED NOT NULL,
		  Date DATETIME NOT NULL,
		  Comment VARCHAR(99) NOT NULL DEFAULT 'нет',
		  FOREIGN KEY (ModelID) REFERENCES Model (ModelID),
		  FOREIGN KEY (SizeLEFT) REFERENCES Sizes (SizeID),
		  FOREIGN KEY (SizeRIGHT) REFERENCES Sizes (SizeID),
		  FOREIGN KEY (UrkLEFT) REFERENCES Urk (UrkID),
		  FOREIGN KEY (UrkRIGHT) REFERENCES Urk (UrkID),
		  FOREIGN KEY (MaterialID) REFERENCES Materials (MaterialID),
		  FOREIGN KEY (HeightLEFT) REFERENCES Height (HeightID),
		  FOREIGN KEY (HeightRIGHT) REFERENCES Height (HeightID),
		  FOREIGN KEY (TopVolumeLEFT) REFERENCES TopVolume (TopVolumeID),
		  FOREIGN KEY (TopVolumeRIGHT) REFERENCES TopVolume (TopVolumeID),
		  FOREIGN KEY (AnkleVolumeLEFT) REFERENCES AnkleVolume (AnkleVolumeID),
		  FOREIGN KEY (AnkleVolumeRIGHT) REFERENCES AnkleVolume (AnkleVolumeID),
		  FOREIGN KEY (KvVolumeLEFT) REFERENCES KvVolume (KvVolumeID),
		  FOREIGN KEY (KvVolumeRIGHT) REFERENCES KvVolume (KvVolumeID),
		  FOREIGN KEY (CustomerID) REFERENCES Customers (CustomerID),
		  FOREIGN KEY (EmployeeID) REFERENCES Employees (EmployeeID)
		)ENGINE=INNODB";
	mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Ошибка при создании таблицы Orders!",mysql_error(),__FILE__,__LINE__));
	reporting_log("Создана таблица Orders!","",__FILE__,__LINE__);
	
  /***Заполняем таблицы, содержащие значения по умолчанию***/
  
	//заполняем таблицу Материалов
	$query = "INSERT INTO Materials (MaterialID, MaterialValue)
				  VALUES('mk', 'КП'),
					('mt', 'Траспира'),
					('mn', 'Мех Натуральный'),
					('ma', 'Мех Искусственный'),
					('mw', 'Мех Полушерстяной')";
	mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Ошибка при добавлении значений в таблицу Materials!",mysql_error(),__FILE__,__LINE__));
	//заполняем таблицу Размеров
	$query = "INSERT INTO Sizes (SizeID, SizeValue)
			      VALUES('s15', 15),
				    ('s16', 16),
				    ('s17', 17),
				    ('s18', 18),
				    ('s19', 19),
				    ('s20', 20),
				    ('s21', 21),
				    ('s22', 22),
				    ('s23', 23),
				    ('s24', 24),
				    ('s25', 25),
				    ('s26', 26),
				    ('s27', 27),
				    ('s28', 28),
				    ('s29', 29),
				    ('s30', 30),
				    ('s31', 31),
				    ('s32', 32),
				    ('s33', 33),
				    ('s34', 34),
				    ('s35', 35),
				    ('s36', 36),
				    ('s37', 37),
				    ('s38', 38),
				    ('s39', 39),
				    ('s40', 40),
				    ('s41', 41),
				    ('s42', 42),
				    ('s43', 43),
				    ('s44', 44),
				    ('s45', 45),
				    ('s46', 46),
				    ('s47', 47),
				    ('s48', 48)";
	mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Ошибка при добавлении значений в таблицу Sizes!",mysql_error(),__FILE__,__LINE__));
	//заполняем таблицу УРК
	$urk_val = fill_table(100, 400, 'u', 1);
	$query = "INSERT INTO Urk(UrkID, UrkValue)
			      VALUES $urk_val('u400', 400)";
	mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Ошибка при добавлении значений в таблицу Urk!",mysql_error(),__FILE__,__LINE__));    
	
	//заполняем таблицу Высоты
	$height_val = fill_table(7, 40, 'h', 1);
	$query = "INSERT INTO Height(HeightID, HeightValue)
			      VALUES ('not', 0),$height_val('h40', 40)";
	mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Ошибка при добавлении значений в таблицу Height!",mysql_error(),__FILE__,__LINE__));    
	
	//заполняем таблицу Объем Верха
	$top_volume_val = fill_table(10, 50, 't', 0.5);
	$query = "INSERT INTO TopVolume(TopVolumeID, TopVolumeValue)
			      VALUES $top_volume_val('t500', 50)";
	mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Ошибка при добавлении значений в таблицу TopVolume!",mysql_error(),__FILE__,__LINE__));
	
	//заполняем таблицу Объем Лодыжки
	$ankle_volume_val = fill_table(10, 50, 'a', 0.5);
	$query = "INSERT INTO AnkleVolume(AnkleVolumeID, AnkleVolumeValue)
			      VALUES $ankle_volume_val('a500', 50)";
	mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Ошибка при добавлении значений в таблицу AnkleVolume!",mysql_error(),__FILE__,__LINE__));
	
	//заполняем таблицу Объем КВ
	$kv_volume_val = fill_table(15, 70, 'k', 0.5);
	$query = "INSERT INTO KvVolume(KvVolumeID, KvVolumeValue)
			      VALUES $kv_volume_val('k700', 70)";
	mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Ошибка при добавлении значений в таблицу KvVolume!",mysql_error(),__FILE__,__LINE__));
	
	//оптимизируем таблицы
	$query = "OPTIMIZE TABLE Orders, Employees, Customers, Materials, Sizes, Urk, Height, TopVolume, AnkleVolume, KvVolume, Model";
	mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Ошибка при оптимизации таблиц!",mysql_error(),__FILE__,__LINE__));
    }
  mysql_close($connection) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Не удалось закрыть соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
}


/********************************************функция новой записи в Базу Данных************************************************/
function new_order($db, $host, $user, $passwd){
    $orderID      = trim(strip_tags($_POST['orderID']));
    $model        = trim(strip_tags($_POST['model']));
    $size         = trim(strip_tags($_POST['size']));
    $urk	  = trim(strip_tags($_POST['urk']));
    $material     = trim(strip_tags($_POST['material']));
    $height       = trim(strip_tags($_POST['height']));
    $top_volume   = trim(strip_tags($_POST['top_volume']));
    $ankle_volume = trim(strip_tags($_POST['ankle_volume']));
    $kv_volume    = trim(strip_tags($_POST['kv_volume']));
    $customerSN = ucfirst(trim(strip_tags($_POST['customerSN'])));
    $customerFN = ucfirst(trim(strip_tags($_POST['customerFN'])));
    $customerP  = ucfirst(trim(strip_tags($_POST['customerP'])));  
    $employeeid = $_POST['designer'];//ID модельера
    $now = date("Y-m-d H:i:s");
    $comment = trim(strip_tags($_POST['comment']));
    
//сначала следует добавить данные в ссылочные (родительские) таблицы и только потом в ссылающиеся дочерние таблицы
//за исключением тех таблиц, в которых значения уже определены по умолчанию
    //узнаем каков ID размера      
    $sizelen = strlen($size);
    if($sizelen > 2){//если длина введеной строки больше 2х цифр, значит для каждой ноги свой размер
      $array_size = explode(" ", $size);
      $size_left = get_size($array_size[0], "new");
      $size_right = get_size($array_size[1], "new");
    }else{//иначе размер ног одинаковые
      $size_left = get_size($size, "new");
      $size_right = $size_left;
    }
    
    //аналогично поступаем с УРК, высотой и всеми объемами
    //узнаем каков УРК
    $urklen = strlen($urk);
    if($urklen > 3){
      $array_urk = explode(" ", $urk);
      $urk_left = get_urk($array_urk[0], "new");
      $urk_right = get_urk($array_urk[1], "new");
    }else{
      $urk_left = get_urk($urk, "new");
      $urk_right = $urk_left;
    }
    
    //узнаем какова высота
    $heightlen = strlen($height);
    if($heightlen > 2){
      $array_height = explode(" ", $height);
      $height_left = get_height($array_height[0], "new");
      $height_right = get_height($array_height[1], "new");
    }else{
      $height_left = get_height($height, "new");
      $height_right = $height_left;
    }

    //узнаем каков объем верха
    $top_volumelen = strlen($top_volume);
    if($top_volumelen > 4){
      $array_top_volume = explode(" ", $top_volume);
      $top_volume_left = get_top_volume($array_top_volume[0], "new");
      $top_volume_right = get_top_volume($array_top_volume[1], "new");
    }else{
      $top_volume_left = get_top_volume($top_volume, "new");
      $top_volume_right = $top_volume_left;
    }
    
    //узнаем каков объем лодыжки
    $ankle_volumelen = strlen($ankle_volume);
    if($ankle_volumelen > 4){
      $array_ankle_volume = explode(" ", $ankle_volume);
      $ankle_volume_left = get_ankle_volume($array_ankle_volume[0], "new");
      $ankle_volume_right = get_ankle_volume($array_ankle_volume[1], "new");
    }else{
      $ankle_volume_left = get_ankle_volume($ankle_volume, "new");
      $ankle_volume_right = $ankle_volume_left;
    }

    //узнаем каков КВ
    $kv_volumelen = strlen($kv_volume);
    if($kv_volumelen > 4){
      $array_kv_volume = explode(" ", $kv_volume);
      $kv_volume_left = get_kv_volume($array_kv_volume[0], "new");
      $kv_volume_right = get_kv_volume($array_kv_volume[1], "new");
    }else{
      $kv_volume_left = get_kv_volume($kv_volume, "new");
      $kv_volume_right = $kv_volume_left;
    }

    if(empty($comment)){
	$comment = "DEFAULT";
    }else{
	$comment = "'$comment'";
    }
    
    $connection = mysql_connect($host, $user, $passwd) or die ("Возникла непредвиденная ошибка.<br />
								Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
								Спасибо.".reporting_log("Не удалось установить соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
    mysql_select_db($db) or die ("Возникла непредвиденная ошибка.<br />
				 Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				 Спасибо.".reporting_log("Не удалось подключиться к базе данных $db.",mysql_error(),__FILE__,__LINE__));

    //ведем проверку что введенный новый идентификатор заказа является уникальным (необходимо если отключен javascript в браузере)
    $result = mysql_query("SELECT OrderID FROM Orders WHERE OrderID='$orderID'");
    $ordersid = mysql_fetch_assoc($result);
    if($ordersid){
	header("Refresh: 2; index.php?id=new");
	echo "<h2>Ошибка! В базе уже есть заказ с таким идентификатором!</h2>";
	exit;
    }
// echo $orderID." ".$model." ".$size_left." ".$size_right." ".$urk_left." ".$urk_right." ".$material." ".$height_left." ".$height_right." ".$top_volume_left." ".$top_volume_right." ".$ankle_volume_left." ".$ankle_volume_right." ".$kv_volume_left." ".$kv_volume_right." ".$customerid." ".$employeeid." ".$now." ".$comment;
/***НАЧАЛО ТРАНЗАКЦИИ***/
    mysql_query("START TRANSACTION") or die("Возникла непредвиденная ошибка.<br />
					      Ваш запрос не может быть выполнен.<br />
					      Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
					      Спасибо.".reporting_log("Не могу начать транзакцию при записи данных в таблицу Orders",mysql_error(),__FILE__,__LINE__));
    //проверяем, есть ли такая модель уже в базе, если нет, то добавляем ее в соответствующую таблицу и ссылаемся на нее
    //иначе, просто ссылаемся на нее)
    $model_result = mysql_query("SELECT ModelID FROM Model WHERE ModelID='$model'") or die ("Возникла непредвиденная ошибка.<br /> Ваш запрос не может быть выполнен.<br />
											     Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
									      Спасибо.".reporting_log("Ошибка проверки модели в таблице Model!",mysql_error(),__FILE__,__LINE__));
    $modnum = mysql_num_rows($model_result);
    if($modnum == 0){
      $query = "INSERT INTO Model (ModelID) VALUE('$model')";
      mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
				  Ваш запрос не может быть выполнен.<br />
				  Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				  Спасибо.".reporting_log("Ошибка добавления новой модели в таблицу Model!",mysql_error(),__FILE__,__LINE__));
    }      
      
    //добавляем заказчика в соответствующую таблицу, запоминаем ID заказчика на который ссылаемся позже
    //при добавлении данных в таблицу Orders    
    $query = "INSERT INTO Customers (CustomerFN, CustomerSN, CustomerP)
			      VALUES('$customerFN', '$customerSN', '$customerP')";
    mysql_query($query) or die (mysql_query("ROLLBACK")."Возникла непредвиденная ошибка.<br />
				Ваш запрос не может быть выполнен.<br />
				Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				Спасибо.".reporting_log("Ошибка добавления нового заказчика в таблицу Customers!",mysql_error(),__FILE__,__LINE__));
    $customerid = mysql_insert_id();   

    //добавляем данные в таблицу Orders
    $query = "INSERT INTO Orders (
				  OrderID,
				  ModelID,
				  SizeLEFT,
				  SizeRIGHT,
				  UrkLEFT,
				  UrkRIGHT,
				  MaterialID,
				  HeightLEFT,
				  HeightRIGHT,
				  TopVolumeLEFT,
				  TopVolumeRIGHT,
				  AnkleVolumeLEFT,
				  AnkleVolumeRIGHT,
				  KvVolumeLEFT,
				  KvVolumeRIGHT,
				  CustomerID,
				  EmployeeID,
				  Date,
				  Comment
				 )
			  VALUES(
				 '$orderID',
				 '$model',
				 '$size_left',
				 '$size_right',
				 '$urk_left',
				 '$urk_right',
				 '$material',
				 '$height_left',
				 '$height_right',
				 '$top_volume_left',
				 '$top_volume_right',
				 '$ankle_volume_left',
				 '$ankle_volume_right',
				 '$kv_volume_left',
				 '$kv_volume_right',
				 '$customerid',
				 '$employeeid',
				 '$now',
				  $comment
				)";
    
    mysql_query($query) or die(mysql_query("ROLLBACK")."Возникла непредвиденная ошибка.<br />
				Ваш запрос не может быть выполнен.<br />
				Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				Спасибо.".reporting_log("Не могу записать данные в таблицу Orders",mysql_error(),__FILE__,__LINE__));
/***окончание транзакции***/
    mysql_query("COMMIT") or die("Возникла непредвиденная ошибка.<br />
				  Ваш запрос не может быть выполнен.<br />
				  Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				  Спасибо.".reporting_log("Не могу завершить транзакцию при записи данных в таблицу Orders",mysql_error(),__FILE__,__LINE__));
mysql_close($connection) or die ("Возникла непредвиденная ошибка.<br />
				  Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				  Спасибо.".reporting_log("Не удалось закрыть соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
}

/*******************************************************************функция сохранения таблицы в файл**************************************************/
function save_tbl($db, $host, $user, $passwd, $exp='xls'){
if($exp == "xls")
  $mime = "application/x-msexcel";
if($exp == "txt")
  $mime = "text/plain";
if($exp == "sql")
  $mime = "text/plain";
  
  switch(php_uname('s')){
    case "Linux":
	$way = "/tmp/";
	break;
    case "Windows NT":
	$way = 'C://WINDOWS//Temp//';
	break;
  }
  $now = date("_Y-n-d__H-i-s");
  $filename = "orthopedic".$now.".".$exp;

  $query = "SELECT SQL_BIG_RESULT
		   OrderID, 
		   ModelID,
		   s.SizeValue as SizeLEFT,
		   s1.SizeValue as SizeRIGHT,
		   u.UrkValue as UrkLEFT,
		   u1.UrkValue as UrkRIGHT,
		   MaterialValue,
		   h.HeightValue as HeightLEFT,
		   h1.HeightValue as HeightRIGHT,
		   t.TopVolumeValue as TopVolumeLEFT,
		   t1.TopVolumeValue as TopVolumeRIGHT,
		   a.AnkleVolumeValue as AnkleVolumeLEFT,
		   a1.AnkleVolumeValue as AnkleVolumeRIGHT,
		   k.KvVolumeValue as KvVolumeLEFT,
		   k1.KvVolumeValue as KvVolumeRIGHT,
		   CONCAT(CustomerSN, ' ', LEFT(CustomerFN, 1), '.', LEFT(CustomerP, 1), '.') AS Customer,
		   CONCAT(EmployeeSN, ' ', LEFT(EmployeeFN, 1), '.', LEFT(EmployeeP, 1), '.') AS Employee,
		   Date,
		   Comment	   
	    INTO OUTFILE '$way.$filename'
	    FROM Orders AS o INNER JOIN Sizes AS s ON o.SizeLEFT=s.SizeID JOIN Sizes s1 ON o.SizeRIGHT=s1.SizeID
			     INNER JOIN Model USING (ModelID)
			     INNER JOIN Urk AS u ON o.UrkLEFT=u.UrkID JOIN Urk u1 ON o.UrkRIGHT=u1.UrkID
			     INNER JOIN Materials USING (MaterialID)
			     INNER JOIN Height AS h ON o.HeightLEFT=h.HeightID JOIN Height h1 ON o.HeightRIGHT=h1.HeightID
			     INNER JOIN TopVolume AS t ON o.TopVolumeLEFT=t.TopVolumeID JOIN TopVolume t1 ON o.TopVolumeRIGHT=t1.TopVolumeID
			     INNER JOIN AnkleVolume AS a ON o.AnkleVolumeLEFT=a.AnkleVolumeID JOIN AnkleVolume a1 ON o.AnkleVolumeRIGHT=a1.AnkleVolumeID
			     INNER JOIN KvVolume AS k ON o.KvVolumeLEFT=k.KvVolumeID JOIN KvVolume k1 ON o.KvVolumeRIGHT=k1.KvVolumeID
			     INNER JOIN Customers USING (CustomerID)
			     INNER JOIN Employees USING (EmployeeID)
	    ORDER BY Date DESC";

  $connection = mysql_connect($host, $user, $passwd) or die ("Возникла непредвиденная ошибка.<br />
							      Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							      Спасибо.".reporting_log("Не удалось установить соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
  mysql_select_db($db) or die ("Возникла непредвиденная ошибка.<br />
				Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				Спасибо.".reporting_log("Не удалось подключиться к базе данных $db.",mysql_error(),__FILE__,__LINE__));
  mysql_query($query) or die ("Возникла непредвиденная ошибка.<br /> 
				Ваш запрос не может быть выполнен.<br />
				Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				Спасибо.".reporting_log("Не удалось сохранить БД в файл!",mysql_error(),__FILE__,__LINE__));

  mysql_close($connection) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Не удалось закрыть соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
  ob_clean();
  header("Content-Type: $mime;");
  header("Content-Disposition: attachment; filename='$filename'");
  echo file_get_contents("$way.$filename");
  unlink("$way.$filename");
  exit;
}
/**************************************************************функция сохранения БД в файл (BACKUP)***********************************************/
function backup_db($db, $host, $user, $passwd){
  $now = date("_Y-n-d__H-i-s");
  $filename = "BACKUP_DB_".$db."_".$now.".sql";
  $command = "mysqldump --flush-logs --databases -u$user -p$passwd -h$host $db > $filename";
  $result = system($command);
  if(!$result){
  ob_clean();
  header("Content-Type: text/plain;");
  header("Content-Disposition: attachment; filename='".$filename."'");
  echo file_get_contents($filename);
  unlink($filename);
  exit;
  echo "Резервная копия успешно создана по адресу $filename !";
  reporting_log("Создана резервная копия БД in $filename !","",__FILE__,__LINE__);
  }else{
    echo "Возникла ошибка создания резервной копии.<br /> Пожалуйста, обратитесь к вашему системному администратору за помощью!<br /> Спасибо.";
    reporting_log("Не могу создать резервную копию БД $db!","",__FILE__,__LINE__);
  }
}

/***********************************************************************функция восстановления БД из бэкапа**************************************************/

function recovery_db($db, $host, $user, $passwd){
  if($_FILES['new_db']['type'] == 'text/x-sql' AND $_FILES['new_db']['error'] == 0){
    $tmp = $_FILES['new_db']['tmp_name'];
    $name = $_FILES['new_db']['name'];
    move_uploaded_file($tmp, $name);
  }else{
      echo "Ошибка загрузки файла. Попробуйте еще раз!";
      reporting_log("Ошибка загрузки файла.","",__FILE__,__LINE__);
      return;
  }
  $command = "mysql -u$user -p$passwd -h$host < $name";
  $result = system($command);
  unlink("$name");
  if(!$result){
  echo "База Данных успешно восстановлена из резервной копии $name !";
  reporting_log("База Данных $db успешно восстановлена из резервной копии $name !","",__FILE__,__LINE__);
  }else{
    echo "Возникла ошибка создания резервной копии.<br /> Пожалуйста, обратитесь к вашему системному администратору за помощью!<br /> Спасибо.";
    reporting_log("Не удалось восстановиться из резервной копии $name.","",__FILE__,__LINE__);
    }
}

/***********************************************************************функция удаления всех заказов**************************************************/
function delete_all_orders($db, $host, $user, $passwd){
  $query = "DELETE Orders, Customers
	    FROM Orders INNER JOIN Customers
	    USING (CustomerID)";
  $connection = mysql_connect($host, $user, $passwd) or die ("Возникла непредвиденная ошибка.<br />
							      Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							      Спасибо.".reporting_log("Не удалось установить соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
  mysql_select_db($db) or die ("Возникла непредвиденная ошибка.<br />
				Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				Спасибо.".reporting_log("Не удалось подключиться к базе данных $db.",mysql_error(),__FILE__,__LINE__));
  mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
			       Ваш запрос не может быть выполнен.<br />
			       Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
			       Спасибо.".reporting_log("Не удалось удалить все записи заказы.",mysql_error(),__FILE__,__LINE__));
  mysql_close($connection) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Не удалось закрыть соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
  header("Location: index.php?id=view");
}

/***********************************************************************функция поиска по базе данных*************************************/
function search($db, $host, $user, $passwd){
//выводим результаты в яваскрипт код для подсветки слов, для этого оформляем текст как яваскрипт код
echo "<script type='text/javascript' src='js/jquery.highlight.js'></script><script type='text/javascript'>$(document).ready(function(){"; 

$where = "";
if(!empty($_POST['orderID'])){
  $orderID  = trim(strip_tags($_POST['orderID']));
  jquery_highlight_create($orderID, 1);
  create_where_id($orderID, "OrderID", $where);
}

if(!empty($_POST['model'])){
  $model  = trim(strip_tags($_POST['model']));
  jquery_highlight_create($model, 2);
  create_where_model($model, "ModelID", $where);
//   if(empty($where)){
//     $where .= "Model='".$model."'";
//   }else{
//     $where .= " AND Model='".$model."'";
//   }
}
  
if(!empty($_POST['size'])){
  $size = trim(strip_tags($_POST['size']));
  jquery_highlight_create($size, 3);
  create_where($size, "SizeLEFT", "SizeRIGHT", "get_size", $where);
}

if(!empty($_POST['urk'])){
  $urk   = trim(strip_tags($_POST['urk']));
  jquery_highlight_create($urk, 4);
  create_where($urk, "UrkLEFT", "UrkRIGHT", "get_urk", $where);
}

if(!empty($_POST['material'])){
  $material = $_POST['material'];
  if(is_array($material)){
    switch(count($material)){
      case 1:
	if(empty($where)){
	  $where .= "MaterialID='".$material[0]."'";
	  break;
	}else{
	  $where .= " AND MaterialID='".$material[0]."'";
	  break;
	}
      case 2:
	if(empty($where)){
	  $where .= "(MaterialID='".$material[0]."' OR MaterialID='".$material[1]."')";
	  break;
	}else{
	  $where .= " AND (MaterialID='".$material[0]."' OR MaterialID='".$material[1]."')";
	  break;
	}
      case 3:
	if(empty($where)){
	  $where .= "(MaterialID='".$material[0]."' OR MaterialID='".$material[1]."' OR MaterialID='".$material[2]."')";
	  break;
	}else{
	  $where .= " AND (MaterialID='".$material[0]."' OR MaterialID='".$material[1]."' OR MaterialID='".$material[2]."')";
	  break;
	}
      case 4:
	if(empty($where)){
	  $where .= "(MaterialID='".$material[0]."' OR MaterialID='".$material[1]."' OR MaterialID='".$material[2]."' OR MaterialID='".$material[3]."')";
	  break;
	}else{
	  $where .= " AND (MaterialID='".$material[0]."' OR MaterialID='".$material[1]."' OR MaterialID='".$material[2]."' OR MaterialID='".$material[3]."')";
	  break;
	}
      case 5:
	if(empty($where)){
	  $where .= "(MaterialID='".$material[0]."' OR MaterialID='".$material[1]."' OR MaterialID='".$material[2]."' OR MaterialID='".$material[3]."' OR MaterialID='".$material[4]."')";
	  break;
	}else{
	  $where .= " AND (MaterialID='".$material[0]."' OR MaterialID='".$material[1]."' OR MaterialID='".$material[2]."' OR MaterialID='".$material[3]."' OR MaterialID='".$material[4]."')";
	  break;
	}
    }
  }
}
  
if(!empty($_POST['height'])){
  $height = trim(strip_tags($_POST['height']));
  jquery_highlight_create($height, 6);
  create_where($height, "HeightLEFT", "HeightRIGHT", "get_height", $where);
}
  
if(!empty($_POST['top_volume'])){
  $top_volume = trim(strip_tags($_POST['top_volume']));
  jquery_highlight_create($top_volume, 7);
  create_where($top_volume, "TopVolumeLEFT", "TopVolumeRIGHT", "get_top_volume", $where);
}
  
if(!empty($_POST['ankle_volume'])){
  $ankle_volume = trim(strip_tags($_POST['ankle_volume']));
  jquery_highlight_create($ankle_volume, 8);
  create_where($ankle_volume, "AnkleVolumeLEFT", "AnkleVolumeRIGHT", "get_ankle_volume", $where);
}
  
if(!empty($_POST['kv_volume'])){
  $kv_volume = trim(strip_tags($_POST['kv_volume']));
  jquery_highlight_create($kv_volume, 9);
  create_where($kv_volume, "KvVolumeLEFT", "KvVolumeRIGHT", "get_kv_volume", $where);
}

if(!empty($_POST['CustomerSN'])){
  $customersn  = trim(strip_tags($_POST['CustomerSN']));
  if(empty($where)){
    $where .= "CustomerSN='".$customersn."'";
  }else{
    $where .= " AND CustomerSN='".$customersn."'";
  }
}

if(!empty($_POST['CustomerFN'])){
  $customerfn = trim(strip_tags($_POST['CustomerFN']));
  if(empty($where)){
     $where = "CustomerFN='".$customerfn."'";
  }else{
     $where = " AND CustomerFN='".$customerfn."'";
  }
}

if(!empty($_POST['CustomerP'])){
  $customerp = trim(strip_tags($_POST['CustomerP']));
  if(empty($where)){
    $where .= "CustomerP='".$customerp."'";
  }else{
    $where .= " AND CustomerP='".$customerp."'";
  }
}
  
if(!empty($_POST['designer'])){
  $employeeid = (int)$_POST['designer'];
  if(empty($where)){
    $where .= "EmployeeID='".$employeeid."'";
  }else{
    $where .= " AND EmployeeID='".$employeeid."'";
  }
}
// echo $where."<hr>";
//очищаем запрос от избыточного излика AND
$where = preg_replace("/OR +AND/", "OR", $where);
// echo $where;

if(empty($where)){
  header("Refresh: 2; index.php?id=search");
  echo "Заполните хотя бы одно поле!";
  return;
}

  $query_search = "SELECT SQL_BIG_RESULT 
		      OrderID, 
		      ModelID,
		      s.SizeValue as SizeLEFT,
		      s1.SizeValue as SizeRIGHT,
		      u.UrkValue as UrkLEFT,
		      u1.UrkValue as UrkRIGHT,
		      MaterialValue,
		      h.HeightValue as HeightLEFT,
		      h1.HeightValue as HeightRIGHT,
		      t.TopVolumeValue as TopVolumeLEFT,
		      t1.TopVolumeValue as TopVolumeRIGHT,
		      a.AnkleVolumeValue as AnkleVolumeLEFT,
		      a1.AnkleVolumeValue as AnkleVolumeRIGHT,
		      k.KvVolumeValue as KvVolumeLEFT,
		      k1.KvVolumeValue as KvVolumeRIGHT,
		      CONCAT(CustomerSN, ' ', CustomerFN, ' ', CustomerP) AS Customer,
		      CONCAT(EmployeeSN, ' ', LEFT(EmployeeFN, 1), '.', LEFT(EmployeeP, 1), '.') AS Employee,
		      Date,
		      Comment
		  FROM Orders AS o INNER JOIN Sizes AS s ON o.SizeLEFT=s.SizeID JOIN Sizes s1 ON o.SizeRIGHT=s1.SizeID
				   INNER JOIN Model USING (ModelID)
				   INNER JOIN Urk AS u ON o.UrkLEFT=u.UrkID JOIN Urk u1 ON o.UrkRIGHT=u1.UrkID
				   INNER JOIN Materials USING (MaterialID)
				   INNER JOIN Height AS h ON o.HeightLEFT=h.HeightID JOIN Height h1 ON o.HeightRIGHT=h1.HeightID
				   INNER JOIN TopVolume AS t ON o.TopVolumeLEFT=t.TopVolumeID JOIN TopVolume t1 ON o.TopVolumeRIGHT=t1.TopVolumeID
				   INNER JOIN AnkleVolume AS a ON o.AnkleVolumeLEFT=a.AnkleVolumeID JOIN AnkleVolume a1 ON o.AnkleVolumeRIGHT=a1.AnkleVolumeID
				   INNER JOIN KvVolume AS k ON o.KvVolumeLEFT=k.KvVolumeID JOIN KvVolume k1 ON o.KvVolumeRIGHT=k1.KvVolumeID
				   INNER JOIN Customers USING (CustomerID)
				   INNER JOIN Employees USING (EmployeeID)
		  WHERE $where
		  ORDER BY Date DESC";

  $connection = mysql_connect($host, $user, $passwd) or die ("Возникла непредвиденная ошибка.<br />
							      Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							      Спасибо.".reporting_log("Не удалось установить соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
  mysql_select_db($db) or die ("Возникла непредвиденная ошибка.<br />
				Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				Спасибо.".reporting_log("Не удалось подключиться к базе данных $db.",mysql_error(),__FILE__,__LINE__));
  $result_search = mysql_query($query_search) or die ("Возникла непредвиденная ошибка.<br />
						      Ваш запрос на поиск не может быть выполнен.<br />
						      Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
						      Спасибо.".reporting_log("Поиск заверщился неудачей!",mysql_error(),__FILE__,__LINE__));
  if(!empty($employeeid)){//если установлен ID дизайнера, значит ведем поиск по дизайнеру, в этом случае найдем его ФИО
    $query_employeeFIO = "SELECT EmployeeSN, EmployeeFN, EmployeeP
			FROM Employees 
			WHERE EmployeeID=$employeeid";
    $result_employeeFIO = mysql_query($query_employeeFIO) or die ("Возникла непредвиденная ошибка.<br />
								  Ваш запрос на поиск не может быть выполнен.<br />
								  Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
								  Спасибо.".reporting_log("Поиск заверщился неудачей!",mysql_error(),__FILE__,__LINE__));
    $array_fio = mysql_fetch_assoc($result_employeeFIO);
    $fio = "";
    $fio .= $array_fio['EmployeeSN']." ";
    $fio .= mb_substr($array_fio['EmployeeFN'], 0,1,'UTF8').".";
    $fio .= mb_substr($array_fio['EmployeeP'], 0,1, 'UTF8').".";
  }
  mysql_close($connection) or die ("Возникла непредвиденная ошибка.<br />
				  Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				  Спасибо.".reporting_log("Не удалось закрыть соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));

	/************************************Подсветка слов поиска*******************/
  if(!empty($fio))
    echo "$('td:nth-child(11)').highlight('".$fio."');";
  if(!empty($customersn))
    echo "$('td:nth-child(10)').highlight('".$customersn."');";
  if(!empty($customerfn))
    echo "$('td:nth-child(10)').highlight('".$customerfn."');";
  if(!empty($customerp))
    echo "$('td:nth-child(10)').highlight('".$customerp."');";  

  function create_array_where($matches){
    foreach($matches as $k => $m){
      if($k==0)
	continue;
      switch($matches[2]){
	case "mk": $matches[2] = "КП"; break;
	case "mt": $matches[2] = "Траспира"; break;
	case "mn": $matches[2] = "Мех Натуральный"; break;
	case "ma": $matches[2] = "Мех Искусственный"; break;
	case "mw": $matches[2] = "Мех Полушерстяной"; break;
      }
      echo "$('td:nth-child(5)').highlight('".$matches[2]."');";
//       echo "$('.highlight_".$m."').highlight('".$matches[2]."');";
// 	break;
    }
  }
  preg_replace_callback("/(MaterialID)\s?=?'(\w+)'/", "create_array_where", $where);//поиск по шаблону
  
  echo "\$('tr').dblclick(function(){\$(this).toggleClass('tr_selected');});";//переключатель-выделятель строки
  echo "});</script>";

  if(!$result_search){
    return "По вашему запросу ничего не найдено.";
  }
  $rows = mysql_num_rows($result_search);//число строк в массиве
  echo "<p>Всего по Вашему запросу найдено строк: ".$rows."</p>";
   if($rows == 0){
     echo "Ничего не найдено. Попробуйте уточнить поиск.";
   }else{
      echo "<table border='1' class='dboutput'>
	    <tr>
	      <th>№ заказа</th>
	      <th>Модель</th>
	      <th>Размер</th>
	      <th>Длина УРК</th>
	      <th>Материал</th>
	      <th>Высота</th>
	      <th>Объем верха</th>
	      <th>Объем лодыжки</th>
	      <th>Объем КВ</th>
	      <th>Заказчик</th>
	      <th>Модельер</th>
	      <th>Дата заказа</th>
	      <th>Комментарий</th>
	      <th>Правка</th>
	      <th>Удалить</th>
	    </tr>";
      for($i = 0; $i<$rows; ++$i){
	echo "<tr>";
	$row = mysql_fetch_assoc($result_search);//ассоциативний массив базы
	$pri_key = $row['OrderID'];
	  echo "<td>".$row['OrderID']."</td>";
	  echo "<td>".$row['ModelID']."</td>";
	  echo "<td>".$row['SizeLEFT']." л<br />".$row['SizeRIGHT']." п</td>";
	  echo "<td>".$row['UrkLEFT']." л<br />".$row['UrkRIGHT']." п</td>";
	  echo "<td>".$row['MaterialValue']."</td>";
	  echo "<td>".$row['HeightLEFT']." л<br />".$row['HeightRIGHT']." п</td>";
	  echo "<td>".$row['TopVolumeLEFT']." л<br />".$row['TopVolumeRIGHT']." п</td>";
	  echo "<td>".$row['AnkleVolumeLEFT']." л<br />".$row['AnkleVolumeRIGHT']." п</td>";
	  echo "<td>".$row['KvVolumeLEFT']." л<br />".$row['KvVolumeRIGHT']." п</td>";
	  echo "<td>".$row['Customer']."</td>";
	  echo "<td>".$row['Employee']."</td>";
	  echo "<td>".$row['Date']."</td>";
	  echo "<td>".$row['Comment']."</td>";
	echo "<td><a class='editrow' href='index.php?edit=$pri_key'></a></td>";
	echo "<td><a class='delrow' href='view.php?del=$pri_key'></a></td>";
	echo "</tr>";
      }
      echo "</table>";
  }
}

/**********************************************функция добавления нового сотрудника фабрики********************************************************/
function new_employee($db, $host, $user, $passwd){
  $emplFN = ucfirst(trim(strip_tags($_POST['fn'])));
  $emplSN = ucfirst(trim(strip_tags($_POST['sn'])));
  $emplP  = ucfirst(trim(strip_tags($_POST['patr'])));
  
  if(!empty($emplFN) AND !empty($emplSN) AND !empty($emplP)){
      $connection = mysql_connect($host, $user, $passwd) or die ("Возникла непредвиденная ошибка.<br />
								  Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
								  Спасибо.".reporting_log("Не удалось установить соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
      mysql_select_db($db) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Не удалось подключиться к базе данных $db.",mysql_error(),__FILE__,__LINE__));
      //проверяем есть ли такой сотрудник уже в базе
      $query_check = "SELECT EmployeeID, STATUS
		      FROM Employees
		      WHERE EmployeeFN='$emplFN' AND EmployeeSN='$emplSN' AND EmployeeP='$emplP'";
      $result_check = mysql_query($query_check) or die ("Возникла непредвиденная ошибка.<br />
							Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							Спасибо.".reporting_log("Нет такого сотрудника!",mysql_error(),__FILE__,__LINE__));
      $rows = mysql_num_rows($result_check);
      $array_check = mysql_fetch_assoc($result_check);
      if($rows == 0){
	$query = "INSERT INTO Employees (EmployeeFN, EmployeeSN, EmployeeP)
				  VALUES('$emplFN', '$emplSN', '$emplP')";

	mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
				    Ваш запрос не может быть выполнен.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Ошибка добавления нового сотрудника.",mysql_error(),__FILE__,__LINE__));
	mysql_close($connection) or die ("Возникла непредвиденная ошибка.<br />
					  Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
					  Спасибо.".reporting_log("Не удалось закрыть соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
	reporting_log("Добавлен новый сотрудник $emplSN $emplFN $emplP!","",__FILE__,__LINE__);
	header("Refresh: 3; index.php");
	echo "<h3>Добавлен новый сотрудник. Добро пожаловать, ".$emplSN." ".$emplFN." ".$emplP."!</h3>";
      }elseif($array_check['STATUS'] == 'Уволен'){
	$query_recovery_employee = "UPDATE Employees
				    SET STATUS='Работает'
				    WHERE EmployeeID='$array_check[EmployeeID]'";
	mysql_query($query_recovery_employee) or die ("Возникла непредвиденная ошибка.<br />
						      Ваш запрос не может быть выполнен.<br />
						      Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
						      Спасибо.".reporting_log("Ошибка восстановления сотрудника.",mysql_error(),__FILE__,__LINE__));
	mysql_close($connection) or die ("Возникла непредвиденная ошибка.<br />
					  Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
					  Спасибо.".reporting_log("Не удалось закрыть соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
	reporting_log("Восстановлен уволенный сотрудник: $emplSN $emplFN $emplP!","",__FILE__,__LINE__);
	echo "Восстановлен уволенный сотрудник: $emplSN $emplFN $emplP!";
      }else{
	header("Refresh: 2; index.php");
	echo "Ошибка! Такой сотрудник уже зарегистрирован!";
	reporting_log("Попытка добавить уже зарегистрированного сотрудника!","",__FILE__,__LINE__);
      }
  }else{
    echo "Заполните все поля.";
  }
}

/**********************************************функция удаления сотрудника фабрики из базы********************************************************/
function delete_employee($db, $host, $user, $passwd){
@ $employeeid = (int)$_POST['designer'];
  if(!empty($employeeid)){
    $connection = mysql_connect($host, $user, $passwd) or die ("Возникла непредвиденная ошибка.<br />
								Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
								Спасибо.".reporting_log("Не удалось установить соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
    mysql_select_db($db) or die ("Возникла непредвиденная ошибка.<br />
				  Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				  Спасибо.".reporting_log("Не удалось подключиться к базе данных $db.",mysql_error(),__FILE__,__LINE__));
    //для вывода значений в лог, но по идее не нужно
    $query = "SELECT EmployeeFN, EmployeeSN, EmployeeP
		FROM Employees 
		WHERE EmployeeID=$employeeid";
    $result = mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
					   Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
					   Спасибо.".reporting_log("Нет такого сотрудника!",mysql_error(),__FILE__,__LINE__));
    $array_result = mysql_fetch_assoc($result);
    $query_delete = "UPDATE Employees
		     SET STATUS='Уволен'
		     WHERE EmployeeID='$employeeid'";
    mysql_query($query_delete) or die ("Ошибка удаления сотрудника.<br />
					Пожалуйста попробуйте еще раз, в случае повторения этой ошибки обратитесь к вашему системному администратору за помощью!<br />
					Спасибо".reporting_log("Ошибка удаления сотрудника!",mysql_error(),__FILE__,__LINE__));
    mysql_close($connection) or die ("Возникла непредвиденная ошибка.<br />
					Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
					Спасибо.".reporting_log("Не удалось закрыть соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
    reporting_log("Уволен сотрудник".$array_result['EmployeeSN']." ".$array_result['EmployeeFN']." ".$array_result['EmployeeP']."!","",__FILE__,__LINE__);
    echo $array_result['EmployeeSN']." ".$array_result['EmployeeFN']." ".$array_result['EmployeeP']." был(а) удален(а) из базы данных!";
  }else{
    echo "<h2>Выберите сотрудника!</h2>";
    header("Refresh: 2; index.php?id=delempl");
  }
}

/**********************************************функция просмотра всех сотрудников фабрики********************************************************/
function get_employee_list($db, $host, $user, $passwd, $type='summary'){
  $query = "SELECT EmployeeID, EmployeeFN, EmployeeSN, EmployeeP, STATUS
	    FROM Employees
	    ORDER BY STATUS";
  $connection = mysql_connect($host, $user, $passwd) or die ("Возникла непредвиденная ошибка.<br />
							      Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							      Спасибо.".reporting_log("Не удалось установить соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
  mysql_select_db($db) or die ("Возникла непредвиденная ошибка.<br />
				Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				Спасибо.".reporting_log("Не удалось подключиться к базе данных $db.",mysql_error(),__FILE__,__LINE__));
  $result = mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
					 Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
					 Спасибо.".reporting_log("Ошибка вывода сотрудников!",mysql_error(),__FILE__,__LINE__));
  mysql_close($connection) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Не удалось закрыть соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
  while($row=mysql_fetch_assoc($result)){
    if($type == 'summary'){
      echo "<li>".$row['EmployeeSN']." ".$row['EmployeeFN']." ".$row['EmployeeP']." (".$row['STATUS'].")"."</li>";
    }elseif($type == 'option' AND $row['STATUS'] == 'Работает'){
      echo "<option value='$row[EmployeeID]'>".$row['EmployeeSN']." ".$row['EmployeeFN']." ".$row['EmployeeP']."</option>";
    }elseif($type == 'search'){
      echo "<option value='$row[EmployeeID]'>".$row['EmployeeSN']." ".$row['EmployeeFN']." ".$row['EmployeeP']." (".$row['STATUS'].")"."</option>";
    }
  }
}


/**************************************************************функция оптимизации БД**************************************/
function optimizedb($db, $host, $user, $passwd){
  $connection = mysql_connect($host, $user, $passwd) or die ("Возникла непредвиденная ошибка.<br />
							      Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							      Спасибо.".reporting_log("Не удалось установить соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
  mysql_select_db($db) or die ("Возникла непредвиденная ошибка.<br />
				Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				Спасибо.".reporting_log("Не удалось подключиться к базе данных $db.",mysql_error(),__FILE__,__LINE__));
  mysql_query("OPTIMIZE TABLE Orders, Employees, Customers, Materials, Sizes, Urk, Height, TopVolume, AnkleVolume, KvVolume, Model") or die ("Возникла непредвиденная ошибка.<br />
													      Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
													      Спасибо.".reporting_log("Ошибка оптимизации БД $db!",mysql_error(),__FILE__,__LINE__));
  mysql_close($connection) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Не удалось закрыть соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
  reporting_log("Произведена оптимизация БД $db.","",__FILE__,__LINE__);
}

/**********************************************************функция-генератор условия WHERE*********************************************************/
function create_where($from_post, $fieldLEFT, $fieldRIGHT, $func, &$where){
/*
 *принимаем данные отфильтрованные из массива POST, поле поиска и условие mysql поиска
 *необходимо обработать все поля запроса, кроме материала, заказчико и модельера
 *эти поля имеют левую и правую составляющие, при поиске ищем и по левой и по правой вместе, без разделения только на 
 *левую и только на правую.
 *PHP поддерживает концепцию переменных функций. Это означает, что если к имени переменной присоединены круглые скобки,
 *PHP ищет функцию с тем же именем, что и результат вычисления переменной, и пытается ее выполнить. Эту возможность 
 *и используем здесь, приминительно к полю $func.
 */
  $array_field= explode(" ", $from_post);//разбиваем по пробелам в массив полученные данные
  $count = count($array_field);//количество элементов массива

  if(empty($where)){//если до этого пустой sql-запрос, 
    if($count == 1){//и в массиве 1 элемент, значит там либо одно число
      if(strpbrk($array_field[0], "-"))//либо диапазон чисел, проверяем
	$where .= interval_to_query($array_field[0], $fieldLEFT, $fieldRIGHT, $func,"last");//если есть дефис, значит это интервал, передаем это дело другой функции
      else
	$where .= "($fieldLEFT='".$func($array_field[0], "search")."' OR "."$fieldRIGHT='".$func($array_field[0], "search")."')";//иначе там просто число
    }else{
      if($count == 1){
	if(strpbrk($array_field[0], "-"))
	  $where .= interval_to_query($array_field[0], $fieldLEFT, $fieldRIGHT, $func,"last");
	else
	  $where .= "($fieldLEFT='".$func($array_field[0], "search")."' OR "."$fieldRIGHT='".$func($array_field[0], "search")."')";
      }else{//если в массиве не один элемент а больше, то обходим каждый в цикле и проверяем на наличие диапазона
	foreach($array_field as $k => $field_value){
	  if(($k+=1) == $count){//если ключ равен последнему элемкнту массива, то это послежний элемент, необходимо отследить это для корректного составления запроса к БД
	    if(strpbrk($field_value, "-"))//проверяем, содержит ли этот последний элемент в себе интервал чисел
	      $where .= interval_to_query($field_value, $fieldLEFT, $fieldRIGHT, $func,"last");
	    else
	      $where .= " ($fieldLEFT='".$func($field_value, "search")."' OR "."$fieldRIGHT='".$func($field_value, "search")."')";
	  }else{
	    if(strpbrk($field_value, "-"))
	      $where .= interval_to_query($field_value, $fieldLEFT, $fieldRIGHT, $func,"");
	    else
	      $where .= " ($fieldLEFT='".$func($field_value, "search")."' OR "."$fieldRIGHT='".$func($field_value, "search")."') OR ";
	  }
	}
      }
    }
  }else{
   //если запрос where уже чтото содержит
    if($count == 1){
      if(strpbrk($array_field[0], "-"))
	$where .= " AND ".interval_to_query($array_field[0], $fieldLEFT, $fieldRIGHT, $func,"last");
      else
	$where .= " AND ($fieldLEFT='".$func($array_field[0], "search")."' OR "."$fieldRIGHT='".$func($array_field[0], "search")."')";
    }else{
      if($count == 1){
	if(strpbrk($array_field[0], "-"))
	  $where .= interval_to_query($array_field[0], $fieldLEFT, $fieldRIGHT, $func,"last");
	else
	  $where .= "($fieldLEFT='".$func($array_field[0], "search")."' OR "."$fieldRIGHT='".$func($array_field[0], "search")."')";
      }else{
	foreach($array_field as $k => $field_value){
	  if(($k+=1) == $count){
	    if(strpbrk($field_value, "-"))
	      $where .= interval_to_query($field_value, $fieldLEFT, $fieldRIGHT, $func,"last");
	    else
	      $where .= " ($fieldLEFT='".$func($field_value, "search")."' OR "."$fieldRIGHT='".$func($field_value, "search")."')";
	  }else{
	    if(strpbrk($field_value, "-"))
	      $where .= " AND ".interval_to_query($field_value, $fieldLEFT, $fieldRIGHT, $func,"");
	    else
	      $where .= " AND ($fieldLEFT='".$func($field_value, "search")."' OR "."$fieldRIGHT='".$func($field_value, "search")."') OR ";
	  }
	}
      }
    }
  } 
}

function interval_to_query($interval, $fieldLEFT, $fieldRIGHT, $func, $which){
  $array_interval = explode("-", $interval);
  if($which == "last")
    return "(".$fieldLEFT.">='".$func($array_interval['0'], "search")."' AND ".$fieldLEFT."<='".$func($array_interval['1'], "search")."') OR ".
	   "(".$fieldRIGHT.">='".$func($array_interval['0'], "search")."' AND ".$fieldRIGHT."<='".$func($array_interval['1'], "search")."')";
  else
    return "(".$fieldLEFT.">='".$func($array_interval['0'], "search")."' AND ".$fieldLEFT."<='".$func($array_interval['1'], "search")."') OR ".
	   "(".$fieldRIGHT.">='".$func($array_interval['0'], "search")."' AND ".$fieldRIGHT."<='".$func($array_interval['1'], "search")."') OR ";
//   if($which == "last")
//     return $field." BETWEEN ".$array_interval['0']." AND ".$array_interval['1'];
//   else
//     return $field." BETWEEN ".$array_interval['0']." AND ".$array_interval['1']." OR "; 
}

function create_where_id($from_post, $field, &$where){
  $array_field= explode(" ", $from_post);
  $count = count($array_field);

  if(empty($where)){
    if($count == 1){
      if(strpbrk($array_field[0], "-"))
	$where .= interval_to_query_id($array_field[0], $field, "last");
      else
	$where .= "$field='".$array_field[0]."'";
    }else{
      if($count == 1){
	if(strpbrk($array_field[0], "-"))
	  $where .= interval_to_query_id($array_field[0], $field, "last");
	else
	  $where .= "$field='".$array_field[0]."'";
      }else{
	foreach($array_field as $k => $field_value){
	  if(($k+=1) == $count){
	    if(strpbrk($field_value, "-"))
	      $where .= interval_to_query_id($field_value, $field, "last");
	    else
	      $where .= " $field='".$field_value."'";
	  }else{
	    if(strpbrk($field_value, "-"))
	      $where .= interval_to_query_id($field_value, $field, "");
	    else
	      $where .= " $field='".$field_value."' OR ";
	  }
	}
      }
    }
  }else{
    //если запрос where уже чтото содержит
    if($count == 1){
      if(strpbrk($array_field[0], "-"))
	$where .= " AND ".interval_to_query_id($array_field[0], $field, "last");
      else
	$where .= " AND $field='".$array_field[0]."'";
    }else{
      if($count == 1){
	if(strpbrk($array_field[0], "-"))
	  $where .= interval_to_query_id($array_field[0], $field, "last");
	else
	  $where .= "$field='".$array_field[0]."'";
      }else{
	foreach($array_field as $k => $field_value){
	  if(($k+=1) == $count){
	    if(strpbrk($field_value, "-"))
	      $where .= interval_to_query_id($field_value, $field, "last");
	    else
	      $where .= " $field='".$field_value."'";
	  }else{
	    if(strpbrk($field_value, "-"))
	      $where .= " AND ".interval_to_query_id($field_value, $field, "");
	    else
	      $where .= " AND $field='".$field_value."' OR ";
	  }
	}
      }
    }
  } 
}//end create_where()

function interval_to_query_id($interval, $field, $which){
  $array_interval = explode("-", $interval);
  if($which == "last")
    return "(".$field.">='".$array_interval['0']."' AND ".$field."<='".$array_interval['1']."')";
  else
    return "(".$field.">='".$array_interval['0']."' AND ".$field."<='".$array_interval['1']."') OR ";
//   if($which == "last")
//     return $field." BETWEEN ".$array_interval['0']." AND ".$array_interval['1'];
//   else
//     return $field." BETWEEN ".$array_interval['0']." AND ".$array_interval['1']." OR "; 
}

function create_where_model($from_post, $field, &$where){
  $array_field= explode(" ", $from_post);
  $count = count($array_field);

  if(empty($where)){
    if($count == 1){
      if(strpbrk($array_field[0], "-"))
	$where .= interval_to_query_model($array_field[0], $field, "last");
      else
	$where .= "$field='".$array_field[0]."'";
    }else{
      if($count == 1){
	if(strpbrk($array_field[0], "-"))
	  $where .= interval_to_query_model($array_field[0], $field, "last");
	else
	  $where .= "$field='".$array_field[0]."'";
      }else{
	foreach($array_field as $k => $field_value){
	  if(($k+=1) == $count){
	    if(strpbrk($field_value, "-"))
	      $where .= interval_to_query_model($field_value, $field, "last");
	    else
	      $where .= " $field='".$field_value."'";
	  }else{
	    if(strpbrk($field_value, "-"))
	      $where .= interval_to_query_model($field_value, $field, "");
	    else
	      $where .= " $field='".$field_value."' OR ";
	  }
	}
      }
    }
  }else{
    //если запрос where уже чтото содержит
    if($count == 1){
      if(strpbrk($array_field[0], "-"))
	$where .= " AND ".interval_to_query_model($array_field[0], $field, "last");
      else
	$where .= " AND $field='".$array_field[0]."'";
    }else{
      if($count == 1){
	if(strpbrk($array_field[0], "-"))
	  $where .= interval_to_query_model($array_field[0], $field, "last");
	else
	  $where .= "$field='".$array_field[0]."'";
      }else{
	foreach($array_field as $k => $field_value){
	  if(($k+=1) == $count){
	    if(strpbrk($field_value, "-"))
	      $where .= interval_to_query_model($field_value, $field, "last");
	    else
	      $where .= " $field='".$field_value."'";
	  }else{
	    if(strpbrk($field_value, "-"))
	      $where .= " AND ".interval_to_query_model($field_value, $field, "");
	    else
	      $where .= " AND $field='".$field_value."' OR ";
	  }
	}
      }
    }
  } 
}//end create_where()

function interval_to_query_model($interval, $field, $which){
  $array_interval = explode("-", $interval);
  if($which == "last")
    return "(".$field.">='".$array_interval['0']."' AND ".$field."<='".$array_interval['1']."')";
  else
    return "(".$field.">='".$array_interval['0']."' AND ".$field."<='".$array_interval['1']."') OR ";
//   if($which == "last")
//     return $field." BETWEEN ".$array_interval['0']." AND ".$array_interval['1'];
//   else
//     return $field." BETWEEN ".$array_interval['0']." AND ".$array_interval['1']." OR "; 
}

/*************************************************еще один способ подсветки слов поиска (ресурсоемкий но подсвечивает все!!!)***************/
function jquery_highlight_create($from_post, $num_child){
  $array_field = explode(" ", $from_post);
    foreach($array_field as $num){
      if(strpbrk($num, "-")){
	$num_interval = explode("-", $num);
	for($i = $num_interval[0]; $i <= $num_interval[1]; ++$i)
	  echo "$('td:nth-child($num_child)').highlight('".$i."');";
      }else{
	echo "$('td:nth-child($num_child)').highlight('".$num."');";
      }
    }
}

/**************************************************************функция-заполнитель подготовленных таблиц************/
function fill_table($from, $to, $char, $increment){
  $array = array();
  for($i=$from; $i<$to; $i=$i+$increment){   
    if($increment == 1)
      $j=$i;
    else
      $j=$i*10;

    $array["$i"] = "('$char".$j."', $i),";
  }
  $values="";
  foreach($array as $val){
    $values .= $val;
  }
  return $values;
}

/*****************************************************************************************/
function get_size($size, $w){
    switch($size){
      case 15: return 's15';break;
      case 16: return 's16';break;
      case 17: return 's17';break;
      case 18: return 's18';break;
      case 19: return 's19';break;
      case 20: return 's20';break;
      case 21: return 's21';break;
      case 22: return 's22';break;
      case 23: return 's23';break;
      case 24: return 's24';break;
      case 25: return 's25';break;
      case 26: return 's26';break;
      case 27: return 's27';break;
      case 28: return 's28';break;
      case 29: return 's29';break;
      case 30: return 's30';break;
      case 31: return 's31';break;
      case 32: return 's32';break;
      case 33: return 's33';break;
      case 34: return 's34';break;
      case 35: return 's35';break;
      case 36: return 's36';break;
      case 37: return 's37';break;
      case 38: return 's38';break;
      case 39: return 's39';break;
      case 40: return 's40';break;
      case 41: return 's41';break;
      case 42: return 's42';break;
      case 43: return 's43';break;
      case 44: return 's44';break;
      case 45: return 's45';break;
      case 46: return 's46';break;
      case 47: return 's47';break;
      case 48: return 's48';break;
      default:
	header("Refresh: 2; index.php?id=$w");
	echo "<h2>Ошибка!</h2> Размер должен быть числом в интервале от 15 до 48.<br />";
	return;
    }
}
/********************************************************************************************************************/
function get_urk($urk, $w){
  for($i=100; $i<=400; $i++){
    if($urk == $i){
      return "u".$urk;
    }
  }
  header("Refresh: 2; index.php?id=$w");
  echo "<h2>Ошибка!</h2> Значение УРК должно быть числом и находиться в интервале от 100 до 400.<br />";
  return;
}

//узнаем какова высота
function get_height($height, $w){
  for($i=7; $i<=40; $i++){
    if($height == $i){
      return "h".$height;
    }
  }
  header("Refresh: 2; index.php?id=$w");
  echo "<h2>Ошибка!</h2> Значение Высоты должно быть числом и находиться в интервале от 7 до 40.<br />";
  return;
}
//узнаем каков объем верха
function get_top_volume($top_volume, $w){
  for($i=10; $i<=50; $i+=0.5){
    if($top_volume == $i){
      return "t".$top_volume*10;
    }
  }
  header("Refresh: 2; index.php?id=$w");
  echo "<h2>Ошибка!</h2> Значение Обхема Верха должно быть числом и находиться в интервале от 10 до 50.<br />";
  return;
}
//узнаем каков объем лодыжки
function get_ankle_volume($ankle_volume, $w){
  for($i=10; $i<=50; $i+=0.5){
    if($ankle_volume == $i){
      return "a".$ankle_volume*10;
    }
  }
  header("Refresh: 2; index.php?id=$w");
  echo "<h2>Ошибка!</h2> Значение Обхема Лодыжки должно быть числом и находиться в интервале от 10 до 50.<br />";
  return;
}
//узнаем каков КВ
function get_kv_volume($kv_volume, $w){
  for($i=15; $i<=70; $i+=0.5){
    if($kv_volume == $i){
      return "k".$kv_volume*10;
    }
  }
  header("Refresh: 2; index.php?id=$w");
  echo "<h2>Ошибка!</h2> Значение Обхема КВ должно быть числом и находиться в интервале от 15 до 70.<br />";
  return;
}

/**********************************************репорт ошибок********************************************************/
function reporting_log($error_str, $error_sql,$file,$line){
  $f = fopen("log.txt","a+") or die("Ошибка открытия лога");
  $error = $error_str." ".$error_sql." ".date('Y:M:d H:i:s')." in ".$file." on line ".$line."\r\n";
  fwrite($f,$error);
}
?>
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
  $connection = mysql_connect($host, $user, $passwd) or die ("Возникла непредвиденная ошибка.<br />
							      Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							      Приносим извинения за неудобства.".reporting_log("Не удалось установить соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
  mysql_select_db($db) or die ("Возникла непредвиденная ошибка.<br />
				Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				Приносим извинения за неудобства.".reporting_log("Не удалось подключиться к базе данных $db.",mysql_error(),__FILE__,__LINE__));

/*********************Отслеживаем нажатие "удалить"*************************/
  if(!empty($_GET['del'])){
    $pri_key = $_GET['del'];
    $query = "DELETE Orders, Customers
		FROM Orders INNER JOIN Customers
		USING (CustomerID)
		WHERE OrderID='".$pri_key."'";
    mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
				 Ваш запрос не может быть выполнен.<br />
				 Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				 Приносим извинения за неудобства.".reporting_log("Запрос на удаление строки провален!",mysql_error(),__FILE__,__LINE__));
    mysql_close($connection);
    header("Location: m.index.php?id=view");
    exit;
  }

/*******************Выводим таблицу из базы***********************************/
//   $limit = "LIMIT ".$rows;
//   if($rows == 'ALL'){
//     $limit = "";
//   }
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
	    
  $result = mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
					 Ваш запрос не может быть выполнен.<br />
					 Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
					 Приносим извинения за неудобства.".reporting_log("Запрос на вывод таблицы провален!",mysql_error(),__FILE__,__LINE__));
  mysql_close($connection) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Не удалось закрыть соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
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
	  var target = this.id == 'next' ? 'm.search.php':'m.new.php';
	  $.mobile.changePage(target, {
	    revers: (target == 'm.new.php')
	  });
	});
      });
    </script>
  </head>
  <body>
      <div data-role="page" id="delete_employee">
	  <div data-role="header">
	    <h1>Просмотр базы</h1>
	    <a href="m.index.php" data-icon="home" data-role='button'>Домой</a>
	  </div>
	  <div data-role="content">
	    <?php
	      $rows = mysql_num_rows($result);//число строк в массиве
	      echo "<p>Всего заказов: ".$rows."</p>";
	      if($rows == 0){
		echo "<h2>База данных пуста.</h2>";
	      }else{
		  echo "<table cols='15' border='2' class='dboutput'>
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
		    $row = mysql_fetch_assoc($result);//ассоциативний массив базы
		    $pri_key = $row['OrderID'];
		    echo "<tr>";
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
		      echo "<td><a href='m.index.php?edit=$pri_key'><img src='../images/edit_24px.png'/></a></td>";
		      echo "<td><a href='m.view.php?del=$pri_key'><img src='../images/delete_16px.png'/></a></a></td>";
		    echo "</tr>";
		  }
		echo "</table>";
	      }
	    ?>
	  </div>
	</div>
    </body>
</html>
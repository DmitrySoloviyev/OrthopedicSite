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
    
if($_SERVER["REQUEST_METHOD"] == 'POST'){
  $orderID            = trim(strip_tags($_POST['orderID']));
  $model 	      = trim(strip_tags($_POST['model']));
  $size_left 	      = (int)trim(strip_tags($_POST['size_left']));
  $size_right 	      = (int)trim(strip_tags($_POST['size_right']));
  
  $urk_left	      = (int)trim(strip_tags($_POST['urk_left']));
  $urk_right	      = (int)trim(strip_tags($_POST['urk_right']));
  
  $material	      = trim(strip_tags($_POST['material']));
  
  $height_left	      = trim(strip_tags($_POST['height_left']));
  $height_right	      = trim(strip_tags($_POST['height_right']));
  
  $top_volume_left    = (float)trim(strip_tags($_POST['top_volume_left']));
  $top_volume_right   = (float)trim(strip_tags($_POST['top_volume_right']));
  
  $ankle_volume_left  = trim(strip_tags($_POST['ankle_volume_left']));
  $ankle_volume_right = trim(strip_tags($_POST['ankle_volume_right']));
  
  $kv_volume_left     = (float)trim(strip_tags($_POST['kv_volume_left']));
  $kv_volume_right    = (float)trim(strip_tags($_POST['kv_volume_right']));
  
  $customersn	  = ucfirst(trim(strip_tags($_POST['CustomerSN'])));
  $customerfn	  = ucfirst(trim(strip_tags($_POST['CustomerFN'])));
  $customerp	  = ucfirst(trim(strip_tags($_POST['CustomerP'])));
  $customerid	  = trim(strip_tags($_POST['CustomerID']));
  
  $employeeid	  = (int)trim(strip_tags($_POST['designer']));
  $comment	  = trim(strip_tags($_POST['Comment']));
  $pri_key	  = $_POST['id'];
  
  //узнаем какой размер соответствует нашему в базе
  $size_left = get_size($size_left, "edit");
  $size_right = get_size($size_right, "edit");
  
  $urk_left = get_urk($urk_left, "edit");
  $urk_right = get_urk($urk_right, "edit");
  
  $height_left = get_height($height_left, "edit");
  $height_right = get_height($height_right, "edit");
  
  $top_volume_left = get_top_volume($top_volume_left, "edit");
  $top_volume_right = get_top_volume($top_volume_right, "edit");
  
  $ankle_volume_left = get_ankle_volume($ankle_volume_left, "edit");
  $ankle_volume_right = get_ankle_volume($ankle_volume_right, "edit");
  
  $kv_volume_left = get_kv_volume($kv_volume_left, "edit");
  $kv_volume_right = get_kv_volume($kv_volume_right, "edit");
  
  //обрабатываем комменторий
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
  //проверяем, был ли введен новый идентификатор
  if($orderID == $pri_key){
      //запрос на редактирование
      $query = "UPDATE Orders INNER JOIN Customers USING (CustomerID)
		SET ModelID='$model',
		    SizeLEFT='$size_left',
		    SizeRIGHT='$size_right',
		    UrkLEFT='$urk_left',
		    UrkRIGHT='$urk_right',
		    MaterialID='$material',
		    HeightLEFT='$height_left',
		    HeightRIGHT='$height_right',
		    TopVolumeLEFT='$top_volume_left',
		    TopVolumeRIGHT='$top_volume_right',
		    AnkleVolumeLEFT='$ankle_volume_left',
		    AnkleVolumeRIGHT='$ankle_volume_right',
		    KvVolumeLEFT='$kv_volume_left',
		    KvVolumeRIGHT='$kv_volume_right',
		    CustomerFN='$customerfn',
		    CustomerSN='$customersn',
		    CustomerP='$customerp',
		    EmployeeID='$employeeid',
		    Comment=$comment
		WHERE Orders.OrderID='".$pri_key."'";
  }else{
    //ведем проверку что введенный новый идентификатор заказа является уникальным    
    $result = mysql_query("SELECT OrderID FROM Orders");
    $ordersid = mysql_fetch_assoc($result);
    foreach($ordersid as $id){
      if($id == $orderID){
	header("Refresh: 2; index.php?id=view");
	echo "<h1>Ошибка! В базе уже есть заказ с таким идентификатором!</h1>";
	exit;
      }else{
	echo "Данный идентификатор допустим.";
      }
    }
    //запрос на редактирование
    $query = "UPDATE Orders INNER JOIN Customers USING (CustomerID)
		SET OrderID='$orderID',
		    ModelID='$model',
		    SizeLEFT='$size_left',
		    SizeRIGHT='$size_right',
		    UrkLEFT='$urk_left',
		    UrkRIGHT='$urk_right',
		    MaterialID='$material',
		    HeightLEFT='$height_left',
		    HeightRIGHT='$height_right',
		    TopVolumeLEFT='$top_volume_left',
		    TopVolumeRIGHT='$top_volume_right',
		    AnkleVolumeLEFT='$ankle_volume_left',
		    AnkleVolumeRIGHT='$ankle_volume_right',
		    KvVolumeLEFT='$kv_volume_left',
		    KvVolumeRIGHT='$kv_volume_right',
		    CustomerFN='$customerfn',
		    CustomerSN='$customersn',
		    CustomerP='$customerp',
		    EmployeeID='$employeeid',
		    Comment=$comment
		WHERE Orders.OrderID='".$pri_key."'";
    
  }
  mysql_query("START TRANSACTION") or die("Возникла непредвиденная ошибка.<br />
					   Ваш запрос не может быть выполнен.<br />
					   Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
					   Спасибо.".reporting_log("Не могу начать транзакцию при редактировании данных в таблице Orders",mysql_error(),__FILE__,__LINE__));
  mysql_query($query) or die (mysql_query("ROLLBACK")."Возникла непредвиденная ошибка.<br />
			       Ваш запрос не может быть выполнен.<br />
			       Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
			       Спасибо.".reporting_log("Запрос на изменение заказа провален!",mysql_error(),__FILE__,__LINE__));
  mysql_query("COMMIT") or die("Возникла непредвиденная ошибка.<br />
				  Ваш запрос не может быть выполнен.<br />
				  Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				  Спасибо.".reporting_log("Не могу завершить транзакцию при редактировании данных в таблице Orders",mysql_error(),__FILE__,__LINE__));
  
  mysql_close($connection) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Не удалось закрыть соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
  header("Refresh: 1; index.php?id=view");
  echo "<h2>Запись изменена успешно!</h2>";
  exit;
}
/*
 ****************Подключаемся к базе и выводим интересующую нас строку и предоставляем ее сотруднику для редактирования.*********************************************
 ****************После чего отправляем запрос постом (выше)************************************************************************************************************
 ****************для изменения строки в базе и возвращаемся к просмотру таблицы посредством посыла соответствующего заголовка*****************************************
*/
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
		   CustomerID,
		   CustomerSN,
		   CustomerFN,
		   CustomerP,
		   EmployeeID,
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
	    WHERE OrderID='".$pri_key."'";

  $connection = mysql_connect($host, $user, $passwd) or die ("Возникла непредвиденная ошибка.<br />
							      Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
							      Спасибо.".reporting_log("Не удалось установить соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));
  mysql_select_db($db) or die ("Возникла непредвиденная ошибка.<br />
				Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				Спасибо.".reporting_log("Не удалось подключиться к базе данных $db.",mysql_error(),__FILE__,__LINE__));
  $result = mysql_query($query) or die ("Возникла непредвиденная ошибка.<br />
					Ваш запрос не может быть выполнен.<br />
					Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
					Спасибо.".reporting_log("Запрос провален!",mysql_error(),__FILE__,__LINE__));
  $row = mysql_fetch_assoc($result);
  $employeeid = $row['EmployeeID'];
  $result_employee = mysql_query("SELECT * FROM Employees") or die ("Возникла непредвиденная ошибка.<br />Ваш запрос не может быть выполнен.<br />
													  Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
													  Спасибо.".reporting_log("Не удалось !",mysql_error(),__FILE__,__LINE__));
  mysql_close($connection) or die ("Возникла непредвиденная ошибка.<br />
				    Пожалуйста, обратитесь к вашему системному администратору за помощью!<br />
				    Спасибо.".reporting_log("Не удалось закрыть соединение с сервером БД!",mysql_error(),__FILE__,__LINE__));														  
?>
<p>
<script type="text/javascript">
  $(document).ready(function(){
  
    $("#orderID").change(function(){
	var order_id = $("#orderID").val();
	$.post("checkID.php", {id:order_id},function(data){
	  if(data == 0)
	    alert("Внимание! Заказ с номером " + order_id + " уже есть базе.");
	});
    });
    
      
    //автозаполнение модели
    $("#model").autocomplete({
      minLength: 1,
      autofocus:true,
      delay:500,
      source:"get_model_list.php",
//       select: function(event, ui){
// 		get_model_info(ui.item.value);
// 		$("#model").val(ui.item.value);
// 	      }
    });
  });//end ready
</script>
<form action="edit.php" method="POST" id="editOrder">
<table border="5" style="margin:auto; background:url(../images/billie_holiday.png) repeat;"> 
  <tr>
    <td>№ заказа</td>
    <td><input type='text' value="<?=$row['OrderID']?>" name="orderID" required autocomplete="Off" id="orderID" /></td>
  </tr>
  <tr>
    <td>Модель</td>
    <td><input type='text' value="<?=$row['ModelID']?>" name="model" required autocomplete="Off" id="model"/></td>
  </tr>
  <tr>
    <td>Размер</td>
    <td>Левая:
      <input type='number' value="<?=$row['SizeLEFT']?>" name="size_left" min="15" max="48" required autocomplete="Off" />
	Правая:
      <input type='number' value="<?=$row['SizeRIGHT']?>" name="size_right" min="15" max="48" required autocomplete="Off" />
    </td>
  </tr>
  <tr>
    <td>УРК</td>
    <td>Левая:
      <input type='number' value="<?=$row['UrkLEFT']?>" name="urk_left" min="100" max="400" required autocomplete="Off" />
	Правая:
      <input type='number' value="<?=$row['UrkRIGHT']?>" name="urk_right" min="100" max="400" required autocomplete="Off" />
    </td>
  </tr>
  <tr>
    <td>Материал</td>
        <td>
      <select name="material" required>
	<option value="mk" <?php if($row['MaterialValue'] =='КП'){echo "selected='selected'";}?>>КП</option>
	<option value="mt" <?php if($row['MaterialValue'] =='Траспира'){echo "selected='selected'";}?>>Траспира</option>
	<option value="mn" <?php if($row['MaterialValue'] =='Мех Натуральный'){echo "selected='selected'";}?>>Мех Натуральный</option>
	<option value="ma" <?php if($row['MaterialValue'] =='Мех Искусственный'){echo "selected='selected'";}?> >Мех Искусственный</option>
	<option value="mw" <?php if($row['MaterialValue'] =='Мех Полушерстяной'){echo "selected='selected'";}?> >Мех Полушерстяной</option>
      </select>   
    </td>
  </tr>
  <tr>
    <td>Высота</td>
    <td>Левая:
      <input type='number' value="<?=$row['HeightLEFT']?>" name="height_left" required autocomplete="Off" min="0" max="40" />
	Правая:
      <input type='number' value="<?=$row['HeightRIGHT']?>" name="height_right" required autocomplete="Off" min="0" max="40" />
    </td>
  </tr>
  <tr>
    <td>Объем верха</td>
    <td>Левая:
      <input type='number' value="<?=$row['TopVolumeLEFT']?>" name="top_volume_left" required autocomplete="Off" min="10" max="50" step="0.5" />
	Правая:
      <input type='number' value="<?=$row['TopVolumeRIGHT']?>" name="top_volume_right" required autocomplete="Off" min="10" max="50" step="0.5" />
    </td>
  </tr>
  <tr>
    <td>Объем лодыжки</td>
    <td>Левая:
      <input type='number' value="<?=$row['AnkleVolumeLEFT']?>" name="ankle_volume_left" required autocomplete="Off" min="10" max="50" step="0.5" />
	Правая:
      <input type='number' value="<?=$row['AnkleVolumeRIGHT']?>" name="ankle_volume_right" required autocomplete="Off" min="10" max="50" step="0.5" />
    </td>
  </tr>
  <tr>
    <td>Объем КВ</td>
    <td>Левая:
      <input type='number' value="<?=$row['KvVolumeLEFT']?>" name="kv_volume_left" required autocomplete="Off" min="15" max="70" step="0.5" />
	Правая:
      <input type='number' value="<?=$row['KvVolumeRIGHT']?>" name="kv_volume_right" required autocomplete="Off" min="15" max="70" step="0.5" />
    </td>
  </tr>
  <tr>
    <td>Заказчик</td>
    <td>
      Фамилия:<input type='text' value="<?=$row['CustomerSN']?>" name="CustomerSN" maxlength="25" required autocomplete="Off" />
      Имя:<input type='text' value="<?=$row['CustomerFN']?>" name="CustomerFN" maxlength="25" required autocomplete="Off" />
      Отчество:<input type='text' value="<?=$row['CustomerP']?>" name="CustomerP" maxlength="25" required autocomplete="Off" />
    </td>
  </tr>
  <tr>
    <td>Модельер</td>
    <td>
      <select name="designer" required>
	<?php
	  while($array_employee = mysql_fetch_assoc($result_employee)){
////////////////////////////////////////////////////////////////////////////////////////
// 		было как ниже
// 	    if($array_employee['EmployeeID'] == $row['EmployeeID']){
// 	      echo "<option value='".$array_employee["EmployeeID"]."' selected='selected'>".$array_employee['EmployeeSN']." ".$array_employee['EmployeeFN']." ".$array_employee['EmployeeP']." (".$array_employee['STATUS'].")</option>";
// 	    }else{
// 	      echo "<option value='".$array_employee["EmployeeID"]."'>".$array_employee['EmployeeSN']." ".$array_employee['EmployeeFN']." ".$array_employee['EmployeeP']." (".$array_employee['STATUS'].")</option>";
// 	    }
//////////////////////////////////////////////////////////////////////////////////////    
	    if($array_employee['STATUS'] == 'Уволен' && $array_employee['EmployeeID'] == $row['EmployeeID']){
	      echo "<option value='".$array_employee["EmployeeID"]."' selected='selected'>".$array_employee['EmployeeSN']." ".$array_employee['EmployeeFN']." ".$array_employee['EmployeeP']." (".$array_employee['STATUS'].")</option>";
	      continue;
	    }elseif($array_employee['STATUS'] == 'Уволен'){
	      continue;
	    }elseif($array_employee['EmployeeID'] == $row['EmployeeID']){
// 	      if($array_employee['STATUS'] == 'Уволен')
// 		continue;
	      echo "<option value='".$array_employee["EmployeeID"]."' selected='selected'>".$array_employee['EmployeeSN']." ".$array_employee['EmployeeFN']." ".$array_employee['EmployeeP']." (".$array_employee['STATUS'].")</option>";
	    }else{
// 	        if($array_employee['STATUS'] == 'Уволен')
// 		continue;
	      echo "<option value='".$array_employee["EmployeeID"]."'>".$array_employee['EmployeeSN']." ".$array_employee['EmployeeFN']." ".$array_employee['EmployeeP']." (".$array_employee['STATUS'].")</option>";
	    }
	  }
	?>
      </select>
    </td>
  </tr>
  <tr>
    <td>Дата заказа</td>
    <td><?=$row['Date']?></td>
  </tr>
  <tr>
    <td>Комментарий</td>
    <td>
      <textarea type="text" value="<?=$row['Comment']?>" name="Comment" autocomplete="Off" ></textarea>
    </td>
  </tr>
  <tr>    
    <input type='hidden' name="id" value="<?=$pri_key?>" />
    <input type='hidden' name="CustomerID" value="<?=$row['CustomerID']?>" />
  </tr>
  <tr>
    <td colspan="2"><input type="submit" value="Исправить!" class="button" id="edit"/></td>
  </tr>
</table>
</form>
</p>
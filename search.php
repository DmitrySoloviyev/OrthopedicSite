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
?>

<script type="text/javascript">
  $(document).ready(function(){
  
//   $("#model_info").load("model_info.html");
  $("#model_info").hide();
  $("#metainfo").hide();
  
  /*********функция вывода информации о модели**************/
  function get_model_info(id){
    var MODEL_ID = id;
      $.post("model_info.php", {id:MODEL_ID, cause:'watch'}, function(data){
	var info = $.parseJSON(data);
	if(info.empty){
	  $("#description").text(info.empty).css('color','#a30000');
	  $("#description_model").text("Неизвестная модель № " + MODEL_ID).css('color','#a30000');
	  $("#author").text("Автор: неизвестен");
	  $("#date").text("Изменен: модификаций не было");
	}else{
	  $("#description_model").text("Модель № " + info.ModelID).css('color', "");
	  $("#description").text(info.ModelDescription).css('color', "");
	  $("#author").text("Автор: " + info.Author).css('color', "");
	  $("#date").text("Изменен: " + info.DateModified).css('color', "");
	}
      });
      
      $.get("model_picture.php", {id:MODEL_ID, cause:'show_picture'}, function(datapic){
	if(datapic == 0){
	  $("#picture").attr("src", "images/ortho.jpg");
	}else{
	  $("#picture").attr("src", "http://localhost/model_picture.php?id=" + id + "&cause=show_picture");
	  $("#picture").wrap("<a id='linkpic' />");
	  $("#linkpic").addClass('fancybox')
		       .attr("href", "http://127.0.0.1/model_picture.php?id=" + id + "&cause=show_picture")
		       .attr("data-fancybox-type", "iframe");
	  $('.fancybox').fancybox({
	    openEffect  : 'elastic',
	    closeEffect:'elastic',
	    autoSize: false,
	    fitToView: true,
	    width:'100%',
	    height:'100%',
	    margin:50,
	    padding:20,
	    autoCenter:true,
	    closeBtn: true,
            helpers : {
	      overlay : {
		css : {'background' : 'rgba(0, 0, 0, 0.7)'}
	      }
	    }
	  });
	}
      });
      $("#metainfo").show();
      $("#model_info").fadeIn(900);
  }
  
  /*********************/
  $("#model").change(function(e){
    var id = $(this).val();
    get_model_info(id);
  });

  /**********автозаполнение модели***************/
  $("#model").autocomplete({
    minLength: 1,
    autoFocus:true,
    source:"get_model_list.php",
    select: function(event, ui){
	      get_model_info(ui.item.value);
	      $("#model").val(ui.item.value);
	    }
  });
  
  /***********кнопка ДАЛЕЕ**************/
  $("#next").click(function(e){
    var model_id = $("#model").val();
    $("#model_info").hide("drop", {direction: "left"}, 300);
    
    $.post("model_info.php", {id:model_id, cause:'next'}, function(data){
      $("#model").val(data);
      get_model_info(data);
    });
    
    $("#model_info").show("drop", {direction: "right"}, 300);
    e.preventDefault;
  });
  
  /*********кнопка НАЗАД********************/
  $("#previous").click(function(e){
    $("#model_info").hide("drop", {direction: "right"}, 300);
    var model_id = $("#model").val();
    
    $.post("model_info.php", {id:model_id, cause:'previous'}, function(data){
      $("#model").val(data);
      get_model_info(data);
    });
    
    $("#model_info").show("drop", {direction: "left"}, 300);
    e.preventDefault;
  });

  $("#close_model_info").click(function(e){
    $("#model_info").hide("fold");
    e.preventDefault;
  });
  
  });//end ready
</script>

<form action="<?=$_SERVER["PHP_SELF"]?>" method="POST" id="search">
  <fieldset>
  <legend>Поиск</legend>
    <table>      
      <tr>
	<td>№ заказа:</td>
	<td><input type="text" name="orderID" autocomplete="Off"/></td>
      </tr>
      <tr>
	<td>Модель:</td>
	<td><input type="text" name="model" autocomplete="Off" id="model" /></td>
      </tr>
      <tr>
	<td>Размер:</td>
	<td><input type="text" name="size" autocomplete="Off"/></td>
      </tr>
      <tr>
	<td>УРК:</td>
	<td><input type="text" name="urk" autocomplete="Off"/></td>
      </tr>
      <tr>
	<td>Материал:</td>
	<td>
	  <label><input type="checkbox" value="mk" name="material[]" />К/П</label><br />
	  <label><input type="checkbox" value="mt" name="material[]" />Траспира</label><br />
	  <label><input type="checkbox" value="mn" name="material[]" />Мех Натуральный</label><br />
	  <label><input type="checkbox" value="ma" name="material[]" />Мех Искусственный</label><br />
	  <label><input type="checkbox" value="mw" name="material[]" />Мех Полушерстяной</label><br />
	</td>
      </tr>
      <tr>
	<td>Высота:</td>
	<td><input type="text" name="height" autocomplete="Off" /></td>
      </tr>
      <tr>
	<td>Объем верха:</td>
	<td><input type="text" name="top_volume" autocomplete="Off" /></td>
      </tr>
      <tr>
	<td>Объем лодыжки:</td>
	<td><input type="text" name="ankle_volume" autocomplete="Off" /></td>
      </tr>
      <tr>
	<td>Объем КВ:</td>
	<td><input type="text" name="kv_volume" autocomplete="Off" /></td>
      </tr>
      <tr>
	<td>Заказчик:</td>
	<td>
	  Фамилия<input type='text'  name="CustomerSN" maxlength="25" autocomplete="Off" />
	  Имя<input type='text'  name="CustomerFN" maxlength="25" autocomplete="Off" />
	  Отчество<input type='text'  name="CustomerP"  maxlength="25" autocomplete="Off" />
	</td>
      </tr>
      <tr>
	<td>Модельер:</td>
	<td>
	  <select name="designer">
	    <option disabled='disabled' selected='selected'>Ф.И.О Модельера</option>
	    <?=get_employee_list($db, $host, $user, $passwd, "search")?>
	  </select>
	</td>
      </tr>
      <tr>
	<td colspan="2">
	    <input type="submit" class="button" value="Искать!" />
	    <input type="reset" class="button" value="Сброс" />
	    <input type="hidden" name="form" value="search" />
	</td>
      </tr>
    </table>
  </fieldset>
</form>
<div id="hint">
  <i>Поля, оставленные пустыми,<br /> участвовать в поиске не будут.<br />
    Для задания диапазона используйте тире "-". Отделяйте каждое значение пробелом. <a href="index.php?id=about#2">Подробнее...</a>
  </i>
</div><p>

<!-- всплывающее окно описания модели -->
<div id="model_info">
  <a href="#" id="close_model_info"></a>
  <div id="nav" >
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
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
?>
<script type="text/javascript">
  $(document).ready(function(){
  
//   $("#model_info").load("model_info.html");
  $("#model_info").hide();
  $("#metainfo").hide();
  
  /*********функция вывода информации о модели**************/
  function get_model_info(id){

  if($("#linkpic").length>0){
    $("#picture").unwrap();
  }
  
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
  
  /********добавление картинки***********/
  $("#new_picture").editable("model_picture.php", { 
        type      : 'ajaxupload',
        submit    : 'Загрузить',
        cancel    : 'Отмена',
//         method    : 'POST'
        submitdata : {id: function(){
			    var model_id = $("#model").val(); 
			    return model_id;
			  }, 
		      cause:'upload_file'}
  });

  /********редактирование описания************/
  $("#description").editable("model_info.php", {
	submitdata : {id: function(){
			    var model_id = $("#model").val(); 
			    return model_id;
			  }, 
		      cause:'edit_description'},
	type    : 'textarea',
	submit  : 'OK',
	cancel  : 'Cancel',
	callback : function(value, settings) {
	  $(this).effect("highlight");
	}
  });
  
  /************редактирование автора**************/
  $("#author").editable("model_info.php", {
	submitdata : {id: function(){
			    var model_id = $("#model").val(); 
			    return model_id;
			  }, 
		      cause:'edit_author'},
	submit  : 'OK',
	cancel  : 'Cancel',
	style   : 'display:inline',
	width:170,
	callback : function(value, settings) {
	  $(this).effect("highlight");
	}
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
  
//   $("#readmore").toggle(
//     function(){
//       $("#description_model").animate({height: "auto"}, 500 );
//       $('#readmore').text('Свернуть');
//       return false;
//     },  
//     function(){
//       $("#description_model").animate({height: "auto"}, 500 );
//       $("#readmore").text('Читать далее');
//       return false;
//    });
  
  $("#model_info").draggable({
    delay:150,
    start:function(){
	    $(this).css('opacity', 0.5).css('cursor','move')
	  },
    stop:function(){
	    $(this).css('opacity', '').css('cursor','')
	  }
    });
  
  });//end ready
</script>

<form action="<?=$_SERVER['PHP_SELF']?>" method="POST" id="neworder">
  <fieldset>
  <legend>Новый заказ</legend>
    <table>
      <tr>
	<td>№ заказа:</td>
	<td><input type="text" name="orderID" maxlength="10" autofocus required autocomplete="Off" id="orderID" /></td>
      </tr>
      <tr>
	<td>Модель:</td>
	<td><input type="text" name="model" maxlength="6" autocomplete="Off" required id="model" pattern="[^ ].{1,6}" /></td>
      </tr>
      <tr>
	<td>Размер:</td>
	<td><input type="text" name="size" maxlength="5" required autocomplete="Off" pattern="\d\d(\s\d\d)?" /></td>
      </tr>
      <tr>
	<td>УРК</td>
	<td><input type="text" name="urk" maxlength="7" min="100" max="400" required autocomplete="Off" pattern="[1-4]\d\d(\s[1-4]\d\d)?" /></td>
      </tr>
      <tr>
	<td>Материал:</td>
	<td>
	  <select name="material">
	    <option value="mk">К/П</option>
	    <option value="mt">Траспира</option>
	    <option value="mn">Мех Натуральный</option>
	    <option value="ma">Мех Искусственный</option>
	    <option value="mw">Мех Полушерстяной</option>
	  </select>  
	</td>
      </tr>
      <tr>
	<td>Высота:</td>
	<td><input type="text" name="height" maxlength="5" required autocomplete="Off" /></td>
      </tr>
      <tr>
	<td>Объем верха:</td>
	<td><input type="text" name="top_volume" maxlength="9" required autocomplete="Off" pattern="[1-5][0-9](\.[50])?(\s[1-5][0-9](\.[50])?)?" /></td>
      </tr>
      <tr>
	<td>Объем лодыжки:</td>
	<td><input type="text" name="ankle_volume" maxlength="9" required autocomplete="Off" pattern="[1-5][0-9](\.[50])?(\s[1-5][0-9](\.[50])?)?" /></td>
      </tr>
      <tr>
	<td title="косого взъема">Объем КВ:</td>
	<td><input type="text" name="kv_volume" maxlength="9" required autocomplete="Off" pattern="[1-7][0-9](\.[50])?(\s[1-7][0-9](\.[50])?)?" /></td>
      </tr>
      <tr>
	<td>Заказчик:</td>
	<td>
	  <table>
	    <tr>
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
	</td>
      </tr>
      <tr>
	<td>Модельер:</td>
	<td>
	  <select name="designer" required>
	    <option disabled='disabled' selected='selected'>Ф.И.О Модельера</option>
	    <?=get_employee_list($db, $host, $user, $passwd, "option")?>
	  </select>
	</td>
      </tr>
      <tr>
	<td>Комментарий:</td>
	<td><textarea name="comment" maxlength="99"></textarea></td>
      </tr>
      <tr colspan="2">
	<td>
	    <input type="submit" class="button"/>
	    <input type="reset" class="button" value="Сброс"/>
	    <input type="hidden" name="form" value="neworder" />
	</td>
      </tr>
    </table>
  </fieldset>
</form>
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
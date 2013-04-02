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
 **/
?>
<script type="text/javascript">
  $(document).ready(function(){
    $( "#dialog" ).dialog({ 
      height: 220,
      width:400,
      modal: false,
      hide: "explode",
      show:"bounce"
      }).css('box-shadow','5px 5px 20px rgba(0,0,0,0.7)');
  });
</script>


<div id="dialog" title="Удаление сотрудников">
    Кого Вы хотите удалить?<br />
    <form action="<?=$_SERVER["PHP_SELF"]?>" method="POST">
      <select name="designer" required>
	<option disabled='disabled' selected='selected'>Ф.И.О Модельера</option>
	<?=get_employee_list($db, $host, $user, $passwd, "option")?>
      </select><p><br />
	<input type="submit" id="button_delete" value="Удалить!" />
	<input type="hidden" name="form" value="delempl" />
    </form>
</div>

<div id="hint">
  <i>Удаление сотрудника приведет к невозможности делать
  заказы от его имени. <a href="index.php?id=about#1">Подробнее...</a></i>
</div>


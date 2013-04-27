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
	  var target = this.id == 'next' ? 'm.index.php':'m.deletemployee.php';
	  $.mobile.changePage(target, {
	    revers: (target == 'm.deletemployee.php')
	  });
	});
      });
    </script>
  </head>
<body>
<div data-role="page" id="about">
  <div data-role="header">
    <h1>О сайте</h1>
    <a href="m.index.php" data-icon="home" data-role='button'>Домой</a>
  </div>
  
  <div data-role="content">
      <div date-role="collapsible-set" >
      
      <div data-role="collapsible" data-content-theme="b" data-theme="b">
	<h1>Общая информация</h1>
	<p>Прежче чем приступать к работе и дабавлять новые заказы, убедитесь, что зарегистрированы все сотрудники, которые будут непосредственно 
	работать с базой данных. В противном случае Вы не сможете создать какой-либо новый заказ, модельером которого является 
	незарегистрированныый сотрудник. Однако просматривать базу данных (БД), удалять, сохранять ее и редактировать отдельные заказы 
	такому сотруднику не возбраняется. <del>По всем вопросам прошу обращаться к Семковой К.Г., как к ответственной за данный проект.</del></p>
      </div>
      
      <div data-role="collapsible" data-content-theme="b" data-theme="b">
	<h1>Об удалении сотрудника</h1>
	<p>При удалении сотрудника, данные о нем удаляются не полность, дабы иметь возможность его восстановить, а также иметь доступ к заказам, 
	сделанные под его именем. Удаление просто лишает Вас возможности заносить новые заказы от имени уволенного модельера. Чтобы восстановить модельера, просто 
	зарегистрируйте его заново. <i><u>Осторожно!</u></i> Если введенные при повторной регистрации данные не будут совпадать полностью с данными удаленного модельера, 
	база данных расценит это как регистрацию абсолютно нового сотрудника, а не восстановление удаленного.</p>
      </div>

      <div data-role="collapsible" data-content-theme="b" data-theme="b">
	<h1>Корректный ввод данных - залог верного ответа</h1>
	<p>При добавлении нового заказа, дробные числа следует вводить через точку "<b>.</b>"! Поиск может производиться в диапазонах, для этого необходимо указать 
	через дефис (без лишних пробелов между числами) минимальное и максимальное значение интересующей характеристики модели, например размеры от 38 до 42 можно
	найти, введя (без кавычек) в соответствующее поле следующее: <code>"38-42"</code>. Если необходимо найти еще и 32й размер то через пробел добавим и его, в 
	итоге получим: <code>"38-42 32"</code> и так сколько угодно. Аналогичный поиск может быть произведен в любом поле, но только если поиск ведется по числовым
	значениям. Этот нюанс относится к полю "Модель", где помимо чисел могут быть и буквы. И все же старайтесь более точно задавать критерии поиска, это поспособствует 
	снижению нагрузки на БД (особенно если в ней содержится очень большое количество информации (помним про оптимизацию БД)) и, как следствие, более быстрой обработке
	Вашего поискового запроса, который приведет к точному результату</p>
      </div>

      <div data-role="collapsible" data-content-theme="b" data-theme="b">
	<h1>О резервном копировании и восстановлении</h1>
	<p>Несмотря на все усилия, прилагаемые для того, чтобы защитить базы данных, такие ситуации, как перебои в электропитании, отказы оборудования
	и другие причины все равно могут приводить к повреждению и даже потере данных. Поэтому базы данных следует обязательно копировать и
	сохранять их копии в безопасном и надежном месте. Делать это лучше всего с определенной периодичностью, которая напрямую зависит от ценности
	Вашей информации. В любом случае, чем чаще Вы это делаете, тем лучше, но учтите, что БД восстанавливается из резервной копии только до того
	состояния, в котором она пребывала на момент, когда Вы в последний раз выполняли ее резервное копирование!
	Резервная копия сохраняется  на компьютер, за которым Вы работаете, поэтому старайтесь ограничить доступ третьих лиц, если информация, 
	сохраненная Вами, по-настоящему ценная и конфиденциальная.<br />
	При восстановлении БД, в целях предотвращения ошибок и повреждения текущей базы данных, пользуйтесь оригинальным
	файлом резервной копии, полученной с этого сайта.</p>
      </div>

      <div data-role="collapsible" data-content-theme="b" data-theme="b">
	<h1>Рекомендации</h1>
	<p>1. Иногда, в зависимости от нагруженности базы информацией, рекомендуется производить ее оптимизацию, в целях уменьшения
	дефрагментации таблиц, получив в итоге лучшее быстродействие (особенно при поиске).<br />
	2. Настоятельно рекомендуется пользоваться сайтом при помощи браузера <a href="https://www.google.com/intl/ru/chrome/" >Google Chrome</a> или хотя бы 
	<a href="https://download.mozilla.org/?product=firefox-19.0.2&os=win&lang=ru">Mozilla Firefox</a>. 
	Крайне НЕ рекомендуется использовать MS Internet Explorer.</p>
      </div>

      <div data-role="collapsible" data-content-theme="b" data-theme="b">
	<h1>О настройке сервера</h1>
	<p><code>
	    <u>httpd.conf:</u><br />
	    ServerName localhost<br />
	    AllowOverride ALL<br />
	    LoadModule php5_module "C:\путь_к_папке_php\php5apache2_2.dll"<br />
	    AddType application/x-httpd-php .php<br /><br />
	    <u>php.ini (скопированный в C:\Windows):</u><br />
	    short_open_tag = On<br />
	    file_uploads = On<br />
	    date.timezone = Europe/Moscow<br />
	    upload_tmp_dir = /tmp/ (для Linux OS)<br />
	    upload_tmp_dir = C:\WINDOWS\Temp\ (для Windows OS)<br />
	    On windows:
	      extension_dir = "-путь-\PHP\ext"<br />
	      extension=php_mysql.dll
	    <br /><br />
	    <u>mysql:</u><br />
	    [client]<br />
	    port=3306<br />
	    [mysql]<br />
	    default-character-set=utf8<br />
	    [mysqld]<br />
	    character-set-server=utf8
	  </code></p>
	</div>
      <hr align="center" width="200" style="margin:auto">
      <div align="center">Успехов!</div>
    </div>
  </div>
</div>
</body>
</html>
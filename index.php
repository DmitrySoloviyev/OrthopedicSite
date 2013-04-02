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
    ini_set('display_errors',1);
    error_reporting(E_ALL);
    header("Content-Type: text/html; charset=UTF-8");
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
//     if(preg_match("/Mobile/i", $user_agent)
//       echo "<!DOCTYPE html>";
//     else
//       echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\" 
//  \"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">";
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
	<title>Ортопедическая обувь</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0, width=device-width" />
	<link rel="shortcut icon" href="images/shoes.png" type="image/png">
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<link rel="stylesheet" href="css/smoothness/jquery-ui-1.10.2.custom.css" type="text/css" />
	<link rel="stylesheet" href="css/jquery.fancybox.css" type="text/css" />
	
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.2.custom.min.js"></script>
	<script type="text/javascript" src="js/jquery.jeditable.mini.js"></script>
	<script type="text/javascript" src="js/jquery.ajaxfileupload.js"></script>
	<script type="text/javascript" src="js/jquery.jeditable.ajaxupload.js"></script>
	<script type="text/javascript" src="js/jquery.fancybox.pack.js"></script>
	<script type="text/javascript">
	  $(document).ready(function() {
	      $('#center').hide().fadeIn(800);
	      $('#hint').hide().delay(1000).slideDown(500);
	      $('#hint').click(function(){
		  $(this).fadeOut(600);
	      });
	      //перемотка вверх
	      $("#back-top").hide();
	      // fade in #back-top
	      $(function () {
		  $(window).scroll(function () {
		      if ($(this).scrollTop() >= 400) {
			  $('#back-top').fadeIn();
		      } else {
			  $('#back-top').fadeOut();
		      }
		  });
		  // scroll body to 0px on click
		  $('#back-top a').click(function () {
		      $('body,html').animate({
			  scrollTop: 0
		      }, 700);
		      return false;
		  });
	      });//конец перемотка вверх
	      
	      //анимированное окно регистрации
	      $("#new_employee").animate({width:"+=155" }, 600);
	      $("#new_employee").click(function(event) {
		$("#registration form").slideToggle(300);
		$(this).toggleClass("close");
	      }); // окончание события click

	  });//end of ready
	</script>
    </head>    
    <body id="top">
    <a href="https://github.com/DmitrySoloviyev/OrthopedicSite">
      <img style="position: absolute; top: 0; left: 0; border: 0; float:left" src="../images/forkme_left_green.png" alt="Fork me on GitHub">
    </a>
    <div class="fix">
      <header>
	  <code><font size="2" style="position:relative; left:70px; top:0px;">Version 0.1.6.1</font></code>
	  <h1>База данных ортопедической обуви</h1> 
	  <div id="navigation">
	      <ul>
		  <li <?php if($_SERVER["QUERY_STRING"] == ''){echo "class='selected'";}?> ><a href="index.php" >Главная</a></li>
		  <li <?php if($_SERVER["QUERY_STRING"] == 'id=new'){echo "class='selected'";}?> ><a href="index.php?id=new" >Новая запись</a></li>
		  <li <?php if($_SERVER["QUERY_STRING"] == 'id=view'){echo "class='selected'";}?> ><a href="index.php?id=view" >Просмотреть базу</a></li>
		  <li <?php if($_SERVER["QUERY_STRING"] == 'id=search'){echo "class='selected'";}?> ><a href="index.php?id=search" >Поиск</a></li>
		  <li <?php if($_SERVER["QUERY_STRING"] == 'id=newdb'){echo "class='selected'";}?> ><a href="index.php?id=newdb" >Работа с БД</a></li>
		  <li <?php if($_SERVER["QUERY_STRING"] == 'id=delempl'){echo "class='selected'";}?> ><a href="index.php?id=delempl" >Удалить сотрудника</a></li>
		  <li <?php if($_SERVER["QUERY_STRING"] == 'id=about'){echo "class='selected'";}?> ><a href="index.php?id=about" >О сайте</a></li>
	      </ul>
	  </div>
      </header>
      <div id="center">
	  <?php
	    is_db_set($db, $host, $user, $passwd);
	    if($_SERVER["REQUEST_METHOD"] == 'GET'){
		if(!empty($_GET['edit'])){
		  $pri_key = $_GET['edit'];
		  require_once "edit.php";
		}
		else{
@		  $id = strip_tags($_GET["id"]);
		    switch($id){
		      case 'new': 
			    require_once "new.php";
			    break;
		      case 'view':   
			    $rows = 10;
			    require_once "view.php";
			    break;
		      case 'search':
			    require_once "search.php";
			    break;
		      case 'newdb':
			    require_once "newdb.php";
			    break;
		      case 'delempl':
			    require_once "deletemployee.php";
			    break;
		      case 'about':
			    require_once "about.php";
			    break;
		      default: echo "<h1><i>Привет!</i></h1>";
	  ?>
		      <div id="registration">
			<p id="new_employee">Новенький?</p>
			  <form action="<?=$_SERVER['PHP_SELF']?>" method='POST' class="form-container">
			      <div class="form-title"><h2>Представьтесь, пожалуйста</h2></div>
			      <div class="form-title">Фамилия</div>
				  <input type='text' name='sn' required autocomplete="Off" maxlength="29" autofocus class="form-field"/>
			      <div class="form-title">Имя</div>
				  <input type='text' name='fn' required autocomplete="Off" maxlength="29" class="form-field"/>
			      <div class="form-title">Отчество</div>
				  <input type='text' name='patr' required autocomplete="Off" maxlength="29" class="form-field"/>
			      <input type='hidden' name='form' value='newempl' />
			      <div class="submit-container"><input class="submit-button" type='submit' /></div>
			  </form>
		      </div>  
			    Просмотреть список сотрудников можно, кликнув ниже:
			  <details>
			    <summary style="cursor: pointer">Показать всех сотрудников</summary>
			    <?=get_employee_list($db, $host, $user, $passwd)?>
			  </details>
			  <p>Вы так же можете удалить сотрудника из базы данных, например, по причине его увольнения. Сделать это можно в соответствующем разделе меню.</p>

			<br />
			Лог версий:
			<p>
			  <table>
<!-- 			  <tr><td><i>0.3</i></td><td>Полный переход сайта на ООП!</td></tr> -->
<!--			  <tr><td style="vertical-align:text-top"><i>0.2.*</i></td><td>Логическое раздение сайта для клиентов и сотрудников. 
										      Новые пункты меню, сгруппированы старые. 
										      Клиенты имеют возможность оставить заявку на заказ и просмотреть 
										      текущий статус своего заказа.</td></tr>-->
<!--			  <tr><td style="vertical-align:text-top"><i>0.2</i></td><td>Введена сисема более жесткой регистрации сотрудников (применение паролей для входа в систему) 
										      и система прав пользователей. Возможно регистрация по аккаунту социальной(ых) сети(ей).
										      Более подробно о правах читать <a href="index.php?id=about">тут</a>.
										      Отображение статуса каждого сотрудника на сайте (Online или Offline). Только пользователь 
										      с учетной записью администратора имеет право добавлять и удалять сотрудников.
										      Только зарегистрированные сотрудники, вошедшие в систему, могут сохранять таблицу БД в файл, 
										      выполнять backup и восстановливаться из backup'а, производить удаление и редактирование данных 
										      из таблицы. Не зарегистрированные пользователи дальше index'a с окном ввода логина и пароля не 
										      пройдут по сайту, за исключегтями, доступными в следующей версии.</td></tr>-->
<!-- 			  <tr><td><i>0.1.6.1</i></td><td>Повышена безопасность работы сайта.</td></tr>  -->
<!--			  <tr><td style="vertical-align:text-top"><i>0.1.6.2</i></td><td> <b> ---Stable Release!---</b> Полностью доработан внешний вид. Адаптивная вестка сайта.
														  Исправлены все известные на данный момент ошибки, убрано все лишнее, реализован
														  весь основной функционал и интерфейс. Данный релиз полностью готов
														  к использованию в сети интранет какого-либо небольшого офиса какой-либо
														  организации (где все свои) для работы только с БД заказов. Тестим. Возможны
														  выходы нескольких минорных версий в будущем, реализующие некоторые 
														  доработки и исправляющие незначительные, обнаруженные со временем, ошибки, однако глобальных изменений 
														  не будет. Последующие версии, начиная с 0.2, реализуют функционал безопасности
														  и конфиденциальности,основанный на правах доступа, что необходимо в случае 
														  работы сайта на просторах всемирной паутины.</td></tr>  -->
			  <tr><td style="vertical-align:text-top"><i>0.1.6.1</i></td><td>Добавлен плагин для jQuery FancyBox. Доработано автозаполнение для графы "Модель". Upstream Changes.</td></tr>
			  <tr><td style="vertical-align:text-top"><i>0.1.6</i></td><td> Фундаментальные переработка в структуре Базы Данных и, как следствие, всего сайта. Добавлены отдельные таблицы: "Высота" со значениями от 7 до 
										      40 и значением 0 (указывает на отсутствие значения),"КВ" со значениями от 15 до 70, "Объем Лодыжки" от 10 до 50, "Объем верха" от 10 до 50 и таблица
										      для Моделей. Изменено значение 
										      номера заказа, теперь принимает значения вида 11706-1 (11706/1). Введено заполнение объемов, размера, урк, высоты для двух ног, в случае их
										      ассиметрии. Поля объемов принимают дробные числа с приращением 0,5. Удален плагин jQuery Validate, валидация заполнения веб-форм переработана, теперь 
										      осуществляется при помощи браузера (поддерживающего HTML5), так и при помощи проверки данных на стороне сервера. Подключены jQuery UI 
										      (Autocomplete и Dialog), Jeditable и AjaxfileUpload. При помощи Ajax добавлены появляющиеся виджеты при 
										      заполнении поля "модель" при поиске/оформлении/редактировании заказов. При добавлении нового заказа можно дать описание данной модели, а также поместить ее 
										      изображение <b>(размером не более 64 Кбайт)</b> в БД. Добавлены кнопки навигации для просмотра всех занесенных в базу моделей. Таким образом можно производить
										      выборку модели. Если такой модели в базе не обнаружевается, пользователю будет предложено занести ее изображение и описание в БД (в режиме поиска этого 
										      сделать нельзя). Добавлен циклический просмотр моделей. Исправлен баг, возникающий при удалении заказа из таблицы с номером, отличным от цифр, а так же
										      другие мелкие исправления и наработки.</td></tr>
 			  <tr><td style="width:111px;vertical-align:text-top"><i>0.1.5.8-Release</i></td><td>Усовершенствован поиск, стал более гибким (принимает по несколько значений, в том числе интервалы
											      значений). В таблицу добавлен столбец "длина УРК". Добавлена возможность в любое время производить 
											      оптимизацию базы данных. Некоторые существенные исправления, в том числе исправлено удаление всех заказов из 
											      таблицы при удалении сотрудника, сделавшего их. Коррекция внешнего вида, доработана подсветка слов при
											      поиске. Добавлен .htaccess для настройки сервера. </td></tr> 
			  <tr><td style="vertical-align:text-top"><i>0.1.5.7-RC2</i></td><td>Подсветка ключевых слов по которым осуществлен поиск. Добавлена и отлажена верификация заполения 
											     формы при редактировании записей. Немного модифицирован интерфейс для боле комфортной работы. 
											     Множество мелких, а так же серьезных исправлений и доработок, переработана в той или иной степени 
											     почти каждая составляющая сайта.</td></tr>
			  <tr><td style="vertical-align:text-top"><i>0.1.5.6-RC1</i></td><td> Проверка заполнения форм до отправки. Исправлено автозаполнение комментариев, внесено множество
											      некоторых исправлений. Добавлена поддержка возможностей JavaScript и jQuery!</td></tr>
			  <tr><td style="width:85px;vertical-align:text-top"><i>0.1.5.5</i></td><td> Добавлены различные виды меха в графу "материал". Добавлена возможность редактировать номер заказа.</td></tr>
			  <tr><td style="vertical-align:text-top"><i>0.1.5.4</i></td><td>Поддержка работы сайта под сервером в ОС Windows: исправлены недочеты, свойственные при работе под этой ОС. Исправлены
				  некоторые ошибки прошлых версий.</td></tr>
			  <tr><td><i>0.1.5.3</i></td><td>Исправлены недочеты поиска. Поиск стал более гибким и точным.</td></tr>
 			  <tr><td style="vertical-align:text-top"><i>0.1.5.2</i></td><td>Убраны всплывающие подсказки при регистрации, увеличено количество символов в форме ФИО, убраны обязательные поля при поиске.
				  Добавлено автозаполнение в поле "модель". Исправлены некоторые недочеты, подправлен внешний вид.</td></tr>
			  <tr><td><i>0.1.5.1</i></td><td>Поддержка UTF-8. Исправлены недочеты при добавлении нового и удалении старого сотрудника.</td></tr>
			  <tr><td><i>0.1.5</i></td><td>Добавлен раздел с HOWTO для сотрудников, корректировка вывода ошибок в лог и на экран.</td></tr> 
			  <tr><td style="vertical-align:text-top"><i>0.1.4.9</i></td><td>Добавлена сортировка по количеству строк при просмотре БД. Немного поправлено восстановление
				 из резервной копии. Реализована функция "Сохранить как". Удалено "загрузка таблицы из файла" т.к в ней нет необходимости. Повышена безопасность. </td></tr>
			  <tr><td style="vertical-align:text-top"><i>0.1.4.8</i></td><td>Переделан и доработан режим сохранения таблицы (одной таблицы) в файл (STABLE). Добавлена возможность сохранения ВСЕЙ Базы 
				 Данных (резервное копирование), а так же возможность восстановления базы из резервной копии.
				 Доступна кнопка удаления всех заказов.</td></tr>
			  <tr><td style="vertical-align:text-top"><i>0.1.4.7</i></td><td>Исправлена ошибка при сохранении таблицы в файл, если тот уже существует. Исправлены мелкие недочеты и ошибки.</td></tr>
			  <tr><td style="vertical-align:text-top"><i>0.1.4.6</i></td><td>Исправлена ошибка дробных чисел в базе. Исправлен и оптимизирован поиск по базе данных. Небольшой багфикс, 
				 сокращено количество строк кода.</td></tr>
			  <tr><td style="vertical-align:text-top"><i>0.1.4.5</i></td><td>Исправлена ошибка зацикливания, приводящая к невозможности пользоваться БД. Предусмотрено автоматическое создание
				 таблиц БД при самом первом посещении сотрудника. Доступна возможность удалить сотрудника из базы.</td></tr>
			  <tr><td style="vertical-align:text-top"><i>0.1.4.4</i></td><td>Исправлены ошибки при редактировании (STABLE) и удалении записей, а так же ошибки связанные с ФИО заказчиков и сотрудников.
				 Немного пофиксил дизайн.</td></tr>
			  <tr><td><i>0.1.4.3</i></td><td>Добавлена упрощенная форма регистрации сотрудников.</td></tr>
			  <tr><td><i>0.1.4.2</i></td><td>Повышена производительность БД за счет оптимизации запросов. Исправлены некоторые недочеты и ошибки.</td></tr>
			  <tr><td style="vertical-align:text-top"><i>0.1.4.1</i></td><td>Глобальное изменение сайта. Полностью переработанная и обновленная БД. Добавлена поддержка транзакций в запросах. 
				 Увеличение производительности базы за счет переработки.</td></tr>
			  <tr><td><i>0.1.3.1</i></td><td>Добавлена возможность редактирования записей в БД (alfa)</td></tr>
			  <tr><td style="vertical-align:text-top"><i>0.1.3</i></td><td>Добавлен лог ошибок. Возможность сохранения записей из БД в файл (alfa).
				 Активирована кнопки печати. Подправлены стили и логика сайта.</td></tr>
			  <tr><td><i>0.1.2</i></td><td>Обширный багфикс.</td></tr>
			  <tr><td><i>0.1.1</i></td><td>Общая оптимизация за счет сокращения строк кода, исправления множества недочетов и ошибок.</td></tr>
			  <tr><td style="vertical-align:text-top"><i>0.1</i></td><td>Первый, почти стабильный релиз с минимум возможностей. (практически все полностью переделано в версии 0.1.4.1)</td></tr>
			  <tr><td style="vertical-align:text-top"><i>0.0.9</i></td><td>Технические наработки закончены. Сайт менялся часто и переписывался. Введен базовый временный стиль страницы. Переделаны пункты меню и навигации.
				 Добавлены иконки and etc.</td></tr>
			  <tr><td><i>0.0.8</i></td><td>Введена нумерация версий.</td></tr>
		      </table>
		    </p>
	  <?php
		    }
		}
	    }
	    
	    if($_SERVER["REQUEST_METHOD"] == 'POST'){
	      if(!empty($_POST['form'])){
		switch($_POST['form']){
		  case "neworder":
			  is_db_set($db, $host, $user, $passwd);
			  new_order($db, $host, $user, $passwd);
			  header("Refresh: 1; index.php?id=new");
			  echo "<h2>Запись успешно добавлена!</h2>";
			  break;
		  case "save":
			  //сохраням БД в файл
			  $exp = $_POST['svas'];
			  save_tbl($db, $host, $user, $passwd, $exp);
			  break;
		  case "backupdb":
			  backup_db($db, $host, $user, $passwd);
			  break;
		  case "print":
			  //направляем на печать
			  header("Location: print.php");
			  exit;
		  case "search": 
			  //вызываем функцию из библиотеки для отработки запроса поиска
			  search($db, $host, $user, $passwd);
			  break;
		  case "newempl":
			  //добавляем нового сотрубника в базу
			  new_employee($db, $host, $user, $passwd);
			  break;
		  case "delempl":
			  //удаляем сотрудника
			  delete_employee($db, $host, $user, $passwd);
			  break;
		  case "delallrow":
			  delete_all_orders($db, $host, $user, $passwd);
			  break;
		  case "recoverydb":
			  recovery_db($db, $host, $user, $passwd);
			  break;
		  case "optimizedb":
			  echo "<h2>Оптимизация базы данных завершена!</h2>";
			  optimizedb($db, $host, $user, $passwd);
			  header("Refresh: 1; index.php?id=newdb");
			  break;
		}
	      }
		if(!empty($_POST['rows'])){
		  switch($_POST['rows']){
		      case 10: 
			$rows = $_POST['rows'];
			require_once "view.php";
			break;
		      case 20: 
			$rows = $_POST['rows'];
			require_once "view.php";
			break;
		      case 40: 
			$rows = $_POST['rows'];
			require_once "view.php";
			break;
		      case 60: 
			$rows = $_POST['rows'];
			require_once "view.php";
			break;
		      case 'ALL': 
			$rows = $_POST['rows'];
			require_once "view.php";
			break;
		      default:
			$rows = 10;
			break;
		  }
		}
	    }
	  ?>
      </div><!--end center-->
      <footer>
	<?php
	  echo "Powered by " . $_SERVER['SERVER_SOFTWARE']." with MySQL server ".mysql_get_server_info()."<br />"."Москва ".date('Y')."г.<br />&copy;Все права защищены / <a href='mailto:sd_dima@mail.ru'>Обратная связь</a><br />";
	?>
	<img src="images/gplv3.png" id="gpl" alt="GPL License"></img>
      </footer>
      </div><!--end fix-->
      <p id="back-top"><a href="#top"><img src="images/arrow_up.png"></img></a></p>
    </body>
</html>
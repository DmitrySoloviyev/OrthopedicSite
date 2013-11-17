<?php
/* @var $this SiteController */
$this->pageTitle=Yii::app()->name;
Yii::app()->clientScript->registerPackage('jquery.ui');
Yii::app()->clientScript->registerScript('t',"
    $('#tabs').tabs({
     	collapsible: true,
     	hide: { effect: 'blind', duration: 400 },
     	show: { effect: 'blind', duration: 400 },
     	active: 3
    });
", CClientScript::POS_READY);
?>
<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')):?>
    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>

<div id="tabs" style="width:681px;">

	<blockquote>
		<p class="mytext">
			<?php
				$quotes = file(Yii::app()->request->baseUrl.'assets/quotes.txt');
				if($quotes){
					$cnt = count($quotes);

					echo $quotes[rand(0, --$cnt)];
				}else{
					echo "Дешевая пара обуви — плохая экономия. Не экономьте на главном: обувь — основа вашего гардероба. <br />&copy; 
						Джорджио Армани.";
				}
			?>
		</p>
	</blockquote>

  <ul>
  	<li><a href="#tabs_1">Новый модельер</a></li>
    <li><a href="#tabs_2">Зарегестрированные модельеры</a></li>
    <li><a href="#tabs_3">Удаленные модельеры</a></li>
  </ul>
  <div id="tabs_1">
    <div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'add-employee-form',
			'enableClientValidation'=>true,
			'clientOptions'=>array('validateOnSubmit'=>true),
		)); ?>
		<fieldset>
		<legend>Новый сотрудник</legend>
			<div>
				<div class="row">
					<?php
					echo $form->TextField(
							$employeesModel,
							'EmployeeSN', 
							array(
								'autocomplete'=>'Off', 
								'maxlength'=>'29', 
								'placeholder'=>'Фамилия'
							)
					);
					echo $form->error($employeesModel,'EmployeeSN');?>
				</div>
				<div class="row">
					<?php
					echo $form->TextField(
						$employeesModel,
						'EmployeeFN', 
						array(
							'autocomplete'=>'Off', 
							'maxlength'=>'29', 
							'placeholder'=>'Имя'
						)
					);
					echo $form->error($employeesModel,'EmployeeFN');?>
				</div>
				<div class="row">
					<?php
					echo $form->TextField(
						$employeesModel,
						'EmployeeP', 
						array(
							'autocomplete'=>'Off', 
							'maxlength'=>'29', 
							'placeholder'=>'Отчество'
						)
					);
					echo $form->error($employeesModel,'EmployeeP');?>
				</div>
			</div>
		   	<div class="row submit">
				<?php echo CHtml::submitButton('Отправить', array('class'=>'button')); ?>
			</div>
		</fieldset>
		<?php $this->endWidget(); ?>
	</div><!-- form -->
  </div>
  <div id="tabs_2">
    	<?php
    		$result = Employees::model()->findAllBySql(
    			"SELECT CONCAT_WS(' ', EmployeeSN, EmployeeFN, EmployeeP) AS FIO FROM Employees WHERE STATUS = 'Работает'");
    		foreach ($result as $key => $value) {
    			echo "<div>".$value->FIO."</div>";
    		}
    	?>
  </div>
  <div id="tabs_3">
    	<?php
    		$result = Employees::model()->findAllBySql(
    			"SELECT CONCAT_WS(' ', EmployeeSN, EmployeeFN, EmployeeP) AS FIO FROM Employees WHERE STATUS = 'Уволен'");
    		foreach ($result as $key => $value) {
    			echo "<div>".$value->FIO."</div>";
    		}
    	?>
  </div>
</div>
<br />

<h4><i>Журнал разработки:</i></h4>
<table style="line-height:1.6">
	<!-- <tr><td style="vertical-align:text-top"><i>Version</i></td><td>Text</td></tr> -->

	<!-- <tr><td style="vertical-align:text-top"><i>0.3</i></td><td>Новый виток развития. Проведена адаптация сайта под высокие нагрузки 
		при помощи кэширования и применении таких технологий как <a href="http://redis.io/">Redis</a> и 
		<a href="http://memcached.org/">Memcached</a>. Оптимизация кода и повышение безопасности работы сайта.</td></tr> -->

	<!--<tr><td style="vertical-align:text-top"><i>0.2.3</i></td><td>Скрипт, автоматически выполняющий резерное копирование БД.</td></tr>-->

	<tr><td style="vertical-align:text-top"><i>0.2.2</i></td><td>Добавлена возможность сохранять заказы 
		в Excel за выбранный промежуток времени (реализована с помощью <a href="http://phpexcel.codeplex.com/">PHPExcel</a>) и графический 
		раздел статистики (реальзован с помощью <a href="http://www.jqplot.com/">jqPlot</a>). 
		Графический раздел при желании может быть легко расширен графиками для вывода иной необходимой информации, по умолчанию показывается
		одна зависимость - количество заказов по дням. Исправлена ошибка, возникающая в том случае, когда редактируется заказ, модельер
		которого был уволен: невозможно сохранить изменения в заказе, не изменив модельера заказа (уволенный модельер не сохранялся как 
		модельер заказа). Отдельное замечание: теперь, если при редактировании заказа, модельером которого является уволенный модельер, 
		назначить другого, Вы больше не сможете вернуть этому заказу изначального (уволенного) модельера. Как выход, пишите комментарий
		к заказу, который, к слову, теперь может вмещать до 255 символов. Подкорректирован расширенный поиск. Полный
		<u><i>редизайн</i></u> сайта. Быстрый поиск вынесен из страницы всех заказов и теперь доступен на любой странице сайта. 
		Небольшой багфикс.</td></tr>

	<tr><td style="vertical-align:text-top"><i>0.2.1</i></td><td>Добавлены рандомные цитаты и быстрый поиск на страницу просмотра всех 
		заказов. Восстановлена подсветка слов поиска в поисковых результатах. Добавлена динамическая сортировка заказов в результатах 
		поиска и при просмотре всех заказов. Введено изображение по умолчанию для моделей, поиск заказов по комментарию, а также 
		множество других исправлений, изменений и улучшений, делающие данную сборку весьма стабильной.</td></tr>

	<tr class="infoMessage"><td style="vertical-align:text-top"><i><b>Сообщение:</b></i></td><td><b>Состоялся <u>релиз</u> приложения для 
		Android по работе с базой данных - <a href="<?php echo Yii::app()->request->baseUrl; ?>/assets/OrthopedicDB.apk">OrthopedicDB</a> 
		(текущая версия 1.0).<b></td></tr>

	<tr><td style="vertical-align:text-top"><i>0.2</i></td><td>Вновь проведена серьезная переработка сайта - сайт переписан под Yii,
		что делает его модульным и легко расширяемым. Изменено хранение информации о модели в БД:
		вынесено хранение изображения модели из БД (размер изображения больше не важен, изображения хранятся в папке
		assets/OrthopedicGallery), стало допустимо хранение одинаковых моделей, но с разными характеристиками.
		Окончательно доработана валидация заполнения форм (основанная на применении регулярных выражений). Раздел "Работа с БД"
		переименован в "Администрирование БД" и объединен со страницей удаления сотрудника (вход только для администратора).
		Переработка дизайна. В эту версию также включены изменения и наработки, которые должны были войти в версию 0.1.6.2:
		корректировка внешнего вида, добавлено автоматическое заполнение формы поиска, используя значения, использованные в
		предыдущем поиске (доработано), виджет с информацией о модели стал перетаскиваемым и многое другое.
		Множество различных изменений и улучшений, в общей сложности переработан весь сайт с верху донизу. Have fun!</td></tr>

	<tr class="infoMessage"><td style="vertical-align:text-top"><i><b>Сообщение:</b></i></td><td><b>Доступна бета-версия приложения 
		для Android по работе с базой данных - <a href="">OrthopedicDB</a> (текущая версия 0.9.1).<b></td></tr>
		
	<tr><td style="vertical-align:text-top"><i>0.1.6.1</i></td><td>Добавлен плагин для jQuery FancyBox. Доработано автозаполнение
		для графы "Модель". Upstream Changes.</td></tr>

	<tr><td style="vertical-align:text-top"><i>0.1.6</i></td><td> Фундаментальные переработка в структуре Базы Данных и, как
		следствие, всего сайта. Добавлены отдельные таблицы: "Высота" со значениями от 7 до 40 и значением 0 (указывает на
		отсутствие значения),"КВ" со значениями от 15 до 70, "Объем Лодыжки" от 10 до 50, "Объем верха" от 10 до 50 и таблица для
		Моделей. Изменено значение номера заказа, теперь принимает значения вида 11706-1 (11706/1). Введено заполнение объемов,
		размера, урк, высоты для двух ног, в случае их ассиметрии. Поля объемов принимают дробные числа с приращением 0,5. Удален
		плагин jQuery Validate, валидация заполнения веб-форм переработана, теперь осуществляется при помощи браузера
		(поддерживающего HTML5), так и при помощи проверки данных на стороне сервера. Подключены jQuery UI (Autocomplete и Dialog),
		Jeditable и AjaxfileUpload. При помощи Ajax добавлены появляющиеся виджеты при заполнении поля "модель" при поиске/
		оформлении/редактировании заказов. При добавлении нового заказа можно дать описание данной модели, а также поместить ее
		изображение <b>(размером не более 64 Кбайт)</b> в БД. Добавлены кнопки навигации для просмотра всех занесенных в базу
		моделей. Таким образом можно производить выборку модели. Если такой модели в базе не обнаружевается, пользователю будет
		предложено занести ее изображение и описание в БД (в режиме поиска этого сделать нельзя). Добавлен циклический просмотр
		моделей. Исправлен баг, возникающий при удалении заказа из таблицы с номером, отличным от цифр, а так же другие мелкие
		исправления и наработки.</td></tr>

 	<tr><td style="vertical-align:text-top"><i>0.1.5.8</i></td><td>Усовершенствован поиск, стал более гибким (принимает
 		по несколько значений, в том числе интервалы значений). В таблицу добавлен столбец "длина УРК". Добавлена возможность в
 		любое время производить оптимизацию базы данных. Некоторые существенные исправления, в том числе исправлено удаление всех
 		заказов из таблицы при удалении сотрудника, сделавшего их. Коррекция внешнего вида, доработана подсветка слов при поиске.
 		Добавлен .htaccess для настройки сервера. </td></tr>

	<tr><td style="vertical-align:text-top"><i>0.1.5.7</i></td><td>Подсветка ключевых слов по которым осуществлен поиск. Добавлена
		и отлажена верификация заполения формы при редактировании записей. Немного модифицирован интерфейс для боле комфортной
		работы. Множество мелких, а так же серьезных исправлений и доработок, переработана в той или иной степени почти каждая
		составляющая сайта.</td></tr>

	<tr><td style="vertical-align:text-top"><i>0.1.5.6</i></td><td> Проверка заполнения форм до отправки. Исправлено автозаполнение
		комментариев, внесено множество некоторых исправлений. Добавлена поддержка возможностей JavaScript с применением библиотеки
		<a href="http://jquery.com/">jQuery</a> !</td></tr>

	<tr><td style="vertical-align:text-top"><i>0.1.5.5</i></td><td> Добавлены различные виды меха в графу "материал".
		Добавлена возможность редактировать номер заказа.</td></tr>

	<tr><td style="vertical-align:text-top"><i>0.1.5.4</i></td><td>Поддержка работы сайта под сервером в ОС Windows: исправлены
		недочеты, свойственные при работе под этой ОС. Исправлены некоторые ошибки прошлых версий.</td></tr>

	<tr><td><i>0.1.5.3</i></td><td>Исправлены недочеты поиска. Поиск стал более гибким и точным.</td></tr>

 	<tr><td style="vertical-align:text-top"><i>0.1.5.2</i></td><td>Убраны всплывающие подсказки при регистрации, увеличено
 		количество символов в форме ФИО, убраны обязательные поля при поиске. Добавлено автозаполнение в поле "модель". Исправлены
 		некоторые недочеты, подправлен внешний вид.</td></tr>

	<tr><td><i>0.1.5.1</i></td><td>Поддержка UTF-8. Исправлены недочеты при добавлении нового и удалении старого сотрудника.</td></tr>

	<tr><td><i>0.1.5</i></td><td>Добавлен раздел с HOWTO для сотрудников, корректировка вывода ошибок в лог и на экран.</td></tr>

	<tr><td style="vertical-align:text-top"><i>0.1.4.9</i></td><td>Добавлена сортировка по количеству строк при просмотре БД. Немного
		поправлено восстановление из резервной копии. Реализована функция "Сохранить как". Удалено "загрузка таблицы из файла" т.к в
		ней нет необходимости. Повышена безопасность. </td></tr>

	<tr><td style="vertical-align:text-top"><i>0.1.4.8</i></td><td>Переделан и доработан режим сохранения таблицы (одной таблицы) в
		файл (STABLE). Добавлена возможность сохранения ВСЕЙ Базы Данных (резервное копирование), а так же возможность восстановления
		базы из резервной копии. Доступна кнопка удаления всех заказов.</td></tr>

	<tr><td style="vertical-align:text-top"><i>0.1.4.7</i></td><td>Исправлена ошибка при сохранении таблицы в файл, если тот уже
		существует. Исправлены мелкие недочеты и ошибки.</td></tr>

	<tr><td style="vertical-align:text-top"><i>0.1.4.6</i></td><td>Исправлена ошибка дробных чисел в базе. Исправлен и оптимизирован
		поиск по базе данных. Небольшой багфикс, сокращено количество строк кода.</td></tr>

	<tr><td style="vertical-align:text-top"><i>0.1.4.5</i></td><td>Исправлена ошибка зацикливания, приводящая к невозможности
		пользоваться БД. Предусмотрено автоматическое создание таблиц БД при самом первом посещении сотрудника. Доступна возможность
		удалить сотрудника из базы.</td></tr>

	<tr><td style="vertical-align:text-top"><i>0.1.4.4</i></td><td>Исправлены ошибки при редактировании (STABLE) и удалении записей,
		а так же ошибки связанные с ФИО заказчиков и сотрудников. Немного пофиксил дизайн.</td></tr>

	<tr><td><i>0.1.4.3</i></td><td>Добавлена упрощенная форма регистрации сотрудников.</td></tr>

	<tr><td><i>0.1.4.2</i></td><td>Повышена производительность БД за счет оптимизации запросов. Исправлены некоторые недочеты и
		ошибки.</td></tr>

	<tr><td style="vertical-align:text-top"><i>0.1.4.1</i></td><td>Глобальное изменение сайта. Полностью переработанная и обновленная
		БД. Добавлена поддержка транзакций в запросах. Увеличение производительности базы за счет переработки.</td></tr>

	<tr><td><i>0.1.3.1</i></td><td>Добавлена возможность редактирования записей в БД (alfa)</td></tr>

	<tr><td style="vertical-align:text-top"><i>0.1.3</i></td><td>Добавлен лог ошибок. Возможность сохранения записей из БД в файл
		(alfa). Активирована кнопки печати. Подправлены стили и логика сайта.</td></tr>

	<tr><td><i>0.1.2</i></td><td>Обширный багфикс.</td></tr>

	<tr><td><i>0.1.1</i></td><td>Общая оптимизация за счет сокращения строк кода, исправления множества недочетов и ошибок.</td></tr>

	<tr><td style="vertical-align:text-top"><i>0.1</i></td><td>Первый, почти стабильный релиз с минимум возможностей.
		(практически все полностью переделано в версии 0.1.4.1)</td></tr>

	<tr><td style="vertical-align:text-top"><i>0.0.9</i></td><td>Технические наработки закончены. Сайт менялся часто и переписывался.
		Введен базовый временный стиль страницы. Переделаны пункты меню и навигации. Добавлены иконки and etc.</td></tr>

	<tr><td><i>0.0.8</i></td><td>Введена нумерация версий.</td></tr>
</table>
<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 05.08.14
 * Time: 0:34
 */

$this->pageTitle = Yii::app()->name;
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScript('t', "
    $('#tabs').tabs({
     	collapsible: true,
     	hide: { effect: 'blind', duration: 400 },
     	show: { effect: 'blind', duration: 400 },
     	active: 3
    });
", CClientScript::POS_READY);
Yii::app()->clientScript->registerScriptFile('/js/hideFlash.js', CClientScript::POS_END);
$this->widget('ext.yii-flash.Flash', [
    'keys' => ['success', 'error'],
    'htmlOptions' => [
        'success' => ['class' => 'flash-success'],
        'error' => ['class' => 'flash-error'],
    ],
]); ?>

<div id='tabs'>
    <?php $this->widget('ext.quote-widget.Quote'); ?>
    <ul>
        <li><a href="#tabs_2">Зарегестрированные модельеры</a></li>
        <li><a href="#tabs_3">Удаленные модельеры</a></li>
    </ul>
    <div id="tabs_2">
        <?= Employee::searchEmployee()?>
    </div>
    <div id="tabs_3">
        <?= Employee::searchEmployee(true)?>
    </div>
</div>
<br/>

<ul>
    <li>Профилирование: анализ MySQL запросов (лог медленных запросов) и их оптимизация (если возможно)</li>
    <li>Эталонное тестирование</li>
    <li>Повысить безопасность</li>
    <li>Codeception</li>
    <li>Фильтровать ввод, экранировать вывод</li>
    <li>TODO $this->createIndex('employees_is_deleted', 'employees', 'is_deleted');</li>
    <li>Индексы по столбцам значений родительских таблиц</li>
</ul>

<h4><i>Журнал разработки:</i></h4>
<table style="line-height:1.6; padding:0 2% 1% 1%; text-align: justify;">
<!-- <tr><td style="vertical-align:text-top"><i>Version</i></td><td>Text</td></tr> -->

<!-- <tr><td style="vertical-align:text-top"><i>0.6</i></td><td>Работа с заказчиком. Переработка в соответствии с ТЗ.</td></tr> -->

<!-- <tr><td style="vertical-align:text-top"><i>0.5</i></td><td>Синхронизация базы данных с мобильным приложением.</td></tr> -->
<!-- <tr class="infoMessage"><td style="vertical-align:text-top; padding: 1% 0;"><i><b>Сообщение:</b></i></td><td style="padding: 1% 0;"><b>
		Обновление приложения для Android по работе с базой данных -
		<a href="<?= Yii::app()->request->baseUrl?>/assets/OrthopedicDB.apk">OrthopedicDB</a>(текущая версия 1.1).<b>Синхронизация базы
		данных с мобильным приложением.</td></tr> -->

<!--
<tr>
    <td style="vertical-align:text-top; color:grey"><i>0.4</i></td>
    <td style="color:grey;padding-bottom: 3%;">Портирование на Yii 2.0</td>
</tr>
-->
<!--
<tr>
    <td style="vertical-align:text-top; color:grey"><i>0.3.2</i></td>
    <td style="color:grey">Благодаря внедрению поисковой системы полнотекстового поиска
        <a href="http://sphinxsearch.com/">Sphinx</a> поиск по базе данных осуществляется на порядок быстрее.
    </td>
</tr>
-->
<!--
<tr>
    <td style="vertical-align:text-top; color:grey"><i>0.3.1</i></td>
    <td style="color:grey">Добавлена регистрация и авторизация. Разграничение прав доступа на основе RBAC.
    Начиная с этой версии, заказы и модели добавляются от имени того пользователя, под которым был осуществлен вход.
    Редактировать и удалять можно только свои заказы и модели. Администратору, как и положено - любые.
    К моделями добавлен атрибут автор. Ресайз загружаемых изображений моделей. На странице со всеми моделями теперь
    отображаются их уменьшенные изображения. Комментарии к заявкам и моделям больше неограничены по длине. Для
    удобства их написания подключен виджет <a href="http://ckeditor.com/">ckeditor</a>. Серьезно изменена визуальная
    основа сайта: внешний вид основан на <a href="http://getbootstrap.com/">Bootstrap</a>, совместно с
    <a href="http://fontawesome.veliovgroup.com/">Font Awesome</a>.</td>
</tr>
-->

<tr>
    <td style="vertical-align:text-top; color:grey"><i>0.3</i></td>
    <td style="color:grey;padding-bottom: 3%;">Yii обновлен до версии 1.1.15. Каких-либо визуальных изменений практически нет, все изменения и
        доработки "под капотом" сайта. Текущая ветка имеет в основном чисто технический характер. В первую очередь
        уделено внимание безопасности сайта, его стабильности и оптимизации, с целью повышения производительности.
        Полностью переработан и доработан, оптимизирован и корректно оформлен код. Теперь конкретнее:
        <ul class="newsList">
            <li>
                Внедрено кэширования данных (реализовано при помощи <a href="http://redis.io/">Redis</a>).
                Задействовано расширение <a href="https://bitbucket.org/limi7less/minscript/wiki/Home">minScript</a>
                для сжатия js- и css-файлов. Включено кэширование схем БД для улучшения производительности. Подключен
                php-акселлератор APC (Alternative PHP Cache).
            </li>
            <li>
                Проведено эталонное тестирование и профилирование. Нагрузка эмулировалась при помощи
                <a href="http://httpd.apache.org/docs/2.2/programs/ab.html">Apache Benchmark tool (ab)</a>.
            </li>
            <li>
                Тестирование приложения при помощи фреймворка автоматического тестирования веб-приложений
                <a href="http://codeception.com/">Codeception</a>.
            </li>
            <li>
                Несколько переработана структура БД, а ее создание вынесено в миграции, что
                позволит в будущем производить безболезненные изменения в ее структуре, если это потребуется.
                Резервная копия создается при помощи <a href="http://www.maatkit.org/">Maatkit</a>.
            </li>
            <li>
                Автоматическое развертывание веб-приложения при помощи <a href="http://www.vagrantup.com/">Vagrant</a>.
            </li>
            <li>
                Удалять и редактировать заказы/модели можно только от имени администратора.
            </li>
            <li>
                Более тесная и полная интеграция с фреймворком Yii.
            </li>
            <li>
                Полноценная админка для создания, редактирования, удаления и просмотра моделей, материалов, модельеров,
                а также выполнения некоторых специфичных действий (выгрузка отчетов, бэкап базы данных и т.д).
                Ужесточение прав доступа. Больше нет возможности создать новую модель при оформлении нового заказа,
                теперь это возможно в соответствующем разделе меню (администратор это также может делать из админки).
                В таблице с заказами добавилась кнопка детального просмотра. Удален раздел "Поиск". Взамен появилась
                строка фильтров, под названием столбцов таблиц, которая отвечает за поиск нужной информации.
            </li>
            <li>
                Приложение включает в себя консольную утилиту, выполняющая резервное копирование базы данных. Настройте
                ваш cron-планировщик на выполнение этого файла в ночное время.
            </li>
        </ul>
        <i>Начиная с этой версии, для работы сайта требуется версия PHP не ниже 5.4.</i><br />
        Приложение протестировано и полностью готово к работе под нагрузкой с количеством записей в базе свыше 1 000 000.
    </td>
</tr>

<tr>
    <td style="vertical-align:text-top;"><i>0.2.4</i></td>
    <td>Небольшая переработка структуры БД: добавлена возможность
        заносить свои материалы (в разделе администрирования). Вывод в разделе статистики информации о количестве
        реализованных заказов по месяцам по каждому модельеру. Для того чтобы увидеть эту информацию, необходимо
        кликнуть на название того месяца, подробности которого, вас интересуют. Небольшой багфикс.
    </td>
</tr>

<tr>
    <td style="vertical-align:text-top;"><i>0.2.3</i></td>
    <td>Корректирующий релиз.
        Исправлена ошибка отображения графиков в разделе статистики при отсутствии записей в базе. Корректное
        отображение графиков, в тех случаях, когда в какой-либо день не было сделано никаких заказов. После создания
        нового заказа очищаются все поля формы. Более плавная анимация появления и исчезновения сообщений об
        ошибках. Некоторые наработки, связанные с повышением безопасности и производительности (за счет сжатия
        страниц). В раздел статистики добавлено два графика. Один показывает количество заказов в день, сделанные
        каждым модельером, другой - процент реализованных заказов по модельерам. Графики, кроме последнего, можно
        масштабировать. Поиск стал более точным, исправлен баг поиска заказа по комментарию. На странице
        редактирования заказа доступна кнопка для удаления текущего заказа. Небольшая доработка дизайна: немного
        видоизменена страница с заказами, несколько переработана выдача поисковых результатов, ссылки сортировки
        заказов (добавлены новые) перемещены в заголовок таблицы, а также множество других мелких доработок.
    </td>
</tr>

<tr>
    <td style="vertical-align:text-top"><i>0.2.2</i></td>
    <td>Добавлена возможность сохранять заказы
        в Excel за выбранный промежуток времени (реализована с помощью <a
            href="http://phpexcel.codeplex.com/">PHPExcel</a>)
        и графический раздел статистики (реальзован с помощью <a href="http://www.jqplot.com/">jqPlot</a>).
        Графический раздел при желании может быть легко расширен графиками для вывода иной необходимой информации,
        по умолчанию показывается одна зависимость - количество заказов по дням. Исправлена ошибка, возникающая в
        том случае, когда редактируется заказ, модельер которого был уволен: невозможно сохранить изменения в
        заказе, не изменив модельера заказа (уволенный модельер не сохранялся как модельер заказа). Отдельное
        замечание: теперь, если при редактировании заказа, модельером которого является уволенный модельер,
        назначить другого, Вы больше не сможете вернуть этому заказу изначального (уволенного) модельера. Как выход,
        пишите комментарий к заказу, который, к слову, теперь может вмещать до 255 символов. Подкорректирован
        расширенный поиск. Полный <u><i>редизайн</i></u> сайта. Быстрый поиск вынесен из страницы всех заказов и
        теперь доступен на любой странице сайта. Небольшой багфикс.
    </td>
</tr>

<tr>
    <td style="vertical-align:text-top"><i>0.2.1</i></td>
    <td>Добавлены рандомные цитаты и быстрый поиск на страницу просмотра всех
        заказов. Восстановлена подсветка слов поиска в поисковых результатах. Добавлена динамическая сортировка
        заказов в результатах поиска и при просмотре всех заказов. Введено изображение по умолчанию для моделей,
        поиск заказов по комментарию, а также множество других исправлений, изменений и улучшений, делающие данную
        сборку весьма стабильной.
    </td>
</tr>

<tr class="infoMessage">
    <td style="vertical-align:text-top; padding: 1% 0;"><i><b>Сообщение:</b></i></td>
    <td style="padding: 1% 0;"><b> Состоялся <u>релиз</u> приложения для Android по работе с базой данных -
            <a href="<?= Yii::app()->request->baseUrl; ?>/upload/OrthopedicDB.apk"><i>OrthopedicDB</i></a>
            (текущая версия 1.0).<b>
    </td>
</tr>

<tr>
    <td style="vertical-align:text-top;"><i>0.2</i></td>
    <td style="padding-bottom: 3%;">Вновь проведена серьезная переработка сайта - сайт переписан под
        <a href="http://www.yiiframework.com/">Yii</a>, что делает его модульным и легко расширяемым.
        Изменено хранение информации о модели в БД:
        вынесено хранение изображения модели из БД (размер изображения больше не важен, изображения хранятся в папке
        assets/OrthopedicGallery), стало допустимо хранение одинаковых моделей, но с разными характеристиками.
        Окончательно доработана валидация заполнения форм (основанная на применении регулярных выражений). Раздел
        "Работа с БД" переименован в "Администрирование БД" и объединен со страницей удаления сотрудника (вход
        только для администратора). Переработка дизайна. В эту версию также включены изменения и наработки, которые
        должны были войти в версию 0.1.6.2: корректировка внешнего вида, добавлено автоматическое заполнение формы
        поиска, используя значения, использованные в предыдущем поиске (доработано), виджет с информацией о модели
        стал перетаскиваемым и многое другое. Множество различных изменений и улучшений, в общей сложности
        переработан весь сайт с верху донизу. Have fun!
    </td>
</tr>

<tr class="infoMessage">
    <td style="vertical-align:text-top; padding: 1% 0;"><i><b>Сообщение:</b></i></td>
    <td style="padding: 1% 0;"><b> Доступна бета-версия приложения для Android по работе с базой данных -
            <a href="<?= Yii::app()->request->baseUrl; ?>/upload/OrthopedicDB.apk"><i>OrthopedicDB</i></a>
            (текущая версия 0.9.1).<b>
    </td>
</tr>

<tr>
    <td style="vertical-align:text-top"><i>0.1.6.1</i></td>
    <td>Добавлен плагин jQuery FancyBox. Доработано автозаполнение для графы "Модель". Upstream Changes.</td>
</tr>

<tr>
    <td style="vertical-align:text-top"><i>0.1.6</i></td>
    <td> Фундаментальные переработка в структуре Базы Данных и, как
        следствие, всего сайта. Добавлены отдельные таблицы: "Высота" со значениями от 7 до 40 и значением 0
        (указывает на отсутствие значения),"КВ" со значениями от 15 до 70, "Объем Лодыжки" от 10 до 50,
        "Объем верха" от 10 до 50 и таблица для Моделей. Изменено значение номера заказа, теперь принимает значения
        вида 11706-1 (11706/1). Введено заполнение объемов, размера, урк, высоты для двух ног, в случае их
        ассиметрии. Поля объемов принимают дробные числа с приращением 0,5. Удален плагин jQuery Validate, валидация
        заполнения веб-форм переработана, теперь осуществляется при помощи браузера (поддерживающего HTML5), так и
        при помощи проверки данных на стороне сервера. Подключены jQuery UI (Autocomplete и Dialog),
        Jeditable и AjaxfileUpload. При помощи Ajax добавлены появляющиеся виджеты при заполнении поля "модель" при
        поиске/оформлении/редактировании заказов. При добавлении нового заказа можно дать описание данной модели,
        а также поместить ее изображение <b>(размером не более 64 Кбайт)</b> в БД. Добавлены кнопки навигации для
        просмотра всех занесенных в базу моделей. Таким образом можно производить выборку модели. Если такой модели
        в базе не обнаружевается, пользователю будет предложено занести ее изображение и описание в БД (в режиме
        поиска этого сделать нельзя). Добавлен циклический просмотр моделей. Исправлен баг, возникающий при удалении
        заказа из таблицы с номером, отличным от цифр, а так же другие мелкие исправления и наработки.
    </td>
</tr>

<tr>
    <td style="vertical-align:text-top"><i>0.1.5.8</i></td>
    <td>Усовершенствован поиск, стал более гибким (принимает
        по несколько значений, в том числе интервалы значений). В таблицу добавлен столбец "длина УРК". Добавлена
        возможность в любое время производить оптимизацию базы данных. Некоторые существенные исправления, в том
        числе исправлено удаление всех заказов из таблицы при удалении сотрудника, сделавшего их. Коррекция внешнего
        вида, доработана подсветка слов при поиске. Добавлен .htaccess для настройки сервера.
    </td>
</tr>

<tr>
    <td style="vertical-align:text-top"><i>0.1.5.7</i></td>
    <td>Подсветка ключевых слов по которым осуществлен поиск. Добавлена
        и отлажена верификация заполения формы при редактировании записей. Немного модифицирован интерфейс для боле
        комфортной работы. Множество мелких, а так же серьезных исправлений и доработок, переработана в той или иной
        степени почти каждая составляющая сайта.
    </td>
</tr>

<tr>
    <td style="vertical-align:text-top"><i>0.1.5.6</i></td>
    <td> Проверка заполнения форм до отправки. Исправлено автозаполнение
        комментариев, внесено множество некоторых исправлений. Добавлена поддержка возможностей JavaScript с
        применением библиотеки <a href="http://jquery.com/">jQuery</a>!
    </td>
</tr>

<tr>
    <td style="vertical-align:text-top"><i>0.1.5.5</i></td>
    <td> Добавлены различные виды меха в графу "материал". Добавлена возможность редактировать номер заказа.
    </td>
</tr>

<tr>
    <td style="vertical-align:text-top"><i>0.1.5.4</i></td>
    <td>Поддержка работы сайта под сервером в ОС Windows: исправлены
        недочеты, свойственные при работе под этой ОС. Исправлены некоторые ошибки прошлых версий.
    </td>
</tr>

<tr>
    <td><i>0.1.5.3</i></td>
    <td>Исправлены недочеты поиска. Поиск стал более гибким и точным.</td>
</tr>

<tr>
    <td style="vertical-align:text-top"><i>0.1.5.2</i></td>
    <td>Убраны всплывающие подсказки при регистрации, увеличено
        количество символов в форме ФИО, убраны обязательные поля при поиске. Добавлено автозаполнение в поле
        "модель". Исправлены некоторые недочеты, подправлен внешний вид.
    </td>
</tr>

<tr>
    <td><i>0.1.5.1</i></td>
    <td>Поддержка UTF-8. Исправлены недочеты при добавлении нового и удалении старого сотрудника.</td>
</tr>

<tr>
    <td><i>0.1.5</i></td>
    <td>Добавлен раздел с HOWTO для сотрудников, корректировка вывода ошибок в лог и на экран.</td>
</tr>

<tr>
    <td style="vertical-align:text-top"><i>0.1.4.9</i></td>
    <td>Добавлена сортировка по количеству строк при просмотре БД. Немного
        поправлено восстановление из резервной копии. Реализована функция "Сохранить как". Удалено "загрузка таблицы
        из файла" т.к в ней нет необходимости. Повышена безопасность.
    </td>
</tr>

<tr>
    <td style="vertical-align:text-top"><i>0.1.4.8</i></td>
    <td>Переделан и доработан режим сохранения таблицы (одной таблицы) в
        файл (STABLE). Добавлена возможность сохранения ВСЕЙ Базы Данных (резервное копирование), а так же
        возможность восстановления базы из резервной копии. Доступна кнопка удаления всех заказов.
    </td>
</tr>

<tr>
    <td style="vertical-align:text-top"><i>0.1.4.7</i></td>
    <td>Исправлена ошибка при сохранении таблицы в файл, если тот уже
        существует. Исправлены мелкие недочеты и ошибки.
    </td>
</tr>

<tr>
    <td style="vertical-align:text-top"><i>0.1.4.6</i></td>
    <td>Исправлена ошибка дробных чисел в базе. Исправлен и оптимизирован
        поиск по базе данных. Небольшой багфикс, сокращено количество строк кода.
    </td>
</tr>

<tr>
    <td style="vertical-align:text-top"><i>0.1.4.5</i></td>
    <td>Исправлена ошибка зацикливания, приводящая к невозможности
        пользоваться БД. Предусмотрено автоматическое создание таблиц БД при самом первом посещении сотрудника.
        Доступна возможность удалить сотрудника из базы.
    </td>
</tr>

<tr>
    <td style="vertical-align:text-top"><i>0.1.4.4</i></td>
    <td>Исправлены ошибки при редактировании (STABLE) и удалении записей,
        а так же ошибки связанные с ФИО заказчиков и сотрудников. Немного пофиксил дизайн.
    </td>
</tr>

<tr>
    <td><i>0.1.4.3</i></td>
    <td>Добавлена упрощенная форма регистрации сотрудников.</td>
</tr>

<tr>
    <td><i>0.1.4.2</i></td>
    <td>Повышена производительность БД за счет оптимизации запросов. Исправлены некоторые недочеты и
        ошибки.
    </td>
</tr>

<tr>
    <td style="vertical-align:text-top"><i>0.1.4.1</i></td>
    <td>Глобальное изменение сайта. Полностью переработанная и обновленная
        БД. Добавлена поддержка транзакций в запросах. Увеличение производительности базы за счет переработки.
    </td>
</tr>

<tr>
    <td><i>0.1.3.1</i></td>
    <td>Добавлена возможность редактирования записей в БД (alfa)</td>
</tr>

<tr>
    <td style="vertical-align:text-top"><i>0.1.3</i></td>
    <td>Добавлен лог ошибок. Возможность сохранения записей из БД в файл
        (alfa). Активирована кнопки печати. Подправлены стили и логика сайта.
    </td>
</tr>

<tr>
    <td><i>0.1.2</i></td>
    <td>Обширный багфикс.</td>
</tr>

<tr>
    <td><i>0.1.1</i></td>
    <td>Общая оптимизация за счет сокращения строк кода, исправления множества недочетов и ошибок.</td>
</tr>

<tr>
    <td style="vertical-align:text-top"><i>0.1</i></td>
    <td>Первый, почти стабильный релиз с минимум возможностей.
        (практически все полностью переделано в версии 0.1.4.1)
    </td>
</tr>

<tr>
    <td style="vertical-align:text-top"><i>0.0.9</i></td>
    <td>Технические наработки закончены. Сайт менялся часто и переписывался.
        Введен базовый временный стиль страницы. Переделаны пункты меню и навигации. Добавлены иконки and etc.
    </td>
</tr>

<tr>
    <td><i>0.0.8</i></td>
    <td>Введена нумерация версий.</td>
</tr>
</table>
<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 05.08.14
 * Time: 0:34
 */
$this->pageTitle = Yii::app()->name;
Yii::app()->clientScript->registerScript('showOldNews', "
$('#showOldNews').click(function() {
    $('.news').fadeIn();
    $(this).fadeOut();

    return false;
});
", CClientScript::POS_END); ?>

<div style="padding: 4px">
    <?php $this->widget('ext.quote-widget.Quote'); ?>
</div>

<?php
list($controller) = Yii::app()->createController('model');
$this->widget('yiiwheels.widgets.gallery.WhCarousel', [
    'items' => $controller->actionFeedImages(),
]);
?>

<h4><i>Журнал разработки:</i></h4>
<div style="line-height:1.6; text-align: justify;">
    <!--
        <div class="row-fluid news">
            <div class="span1"><i>Version</i></div>
            <div class="span11">Text</div>
        </div>
    -->

    <!--
    <div class="row-fluid news">
        <div class="span1" style="font-size: 1.4em;"><i><b>1.0.0</b></i></div>
        <div class="span11" style="padding-bottom: 5%;">
            Технологический прорыв!
            Портирование на <a target="_blank" href="http://www.yiiframework.com/">Yii 2 (2.1.x)</a> с полным сохранением
            существующего функционала. Новая база данных -
            <a target="_blank" href="http://www.postgresql.org/"> PostgreSQL</a>!
            Тестирование приложения при помощи фреймворка автоматического тестирования веб-приложений -
            <a href="http://codeception.com/">Codeception</a>!
            Обновленный внешний вид: <a target="_blank" href="http://getbootstrap.com/">Bootstrap 3.x</a>!
            Используется поисковая система полнотекстового поиска
            <a target="_blank" href="http://sphinxsearch.com/">Sphinx</a>!
            Теперь поиск информации по базе данных, генерация отчета, построение графиков статистики
            осуществляется на несколько порядоков быстрее.
            <p class="release_date">(31.01.2016)</p>
        </div>
    </div>
    -->

    <!--
    <div class="row-fluid news">
        <div class="span1" ><i>0.5</i></div>
        <div class="span11" style="padding-bottom: 5%;">
            Добавлена новая тема: Material Design, с использованием библиотеки
            <a target="_blank" href="http://materializecss.com/">materialize</a>.
            Старая тема также сохранена, используйте переключатель для динамической смены темы оформления.
            Переписаны графики: используется библиотека
            <a target="_blank" href="http://www.highcharts.com/">highcharts</a>, удален jqplot.
            В раздел статистики добавлены 3 новых графика, аналогичные существующим, но по моделям.
            Разграничение прав доступа к разделам сайта на основе системы доступа на
            основе ролей: Role Based Access Control (RBAC). По умолчанию доступны 3 роли: администратор, модельер и
            гость. Редактировать и удалять можно только свои заказы и модели. Администратору, как и положено - любые.
            Администратор имеет возможность назначать роли пользователям. Приложение покрыто логами, которые
            отображаются в админке. Скрытие всех разделов сайта для гостей: обязательная авторизация на новой странице.
            Исправлены некоторые ошибки.
            <p class="release_date">(xx.08.2015)</p>
        </div>
    </div>
    -->

    <div class="row-fluid">
        <div class="span1"><i>0.4.1</i></div>
        <div class="span11" style="padding-bottom: 1%;">
            Проведено эталонное тестирование и профилирование. Загрузка базы данных при тестировании:
            модельеров 101 человек, моделей 200 000, материалов 1005, заказчиков 500 000 и 500 000 заказов.
            В админку возвращен раздел оптимизации базы данных и добавлен раздел с выводом отчета по моделям.
            Переписано простроение отчетов. Для удобства, в отчеты добавлены ссылки в ячейки с заказами и моделями.
            Кэширование сессии пользователя. Если при создании нового заказа, модель не находится, выводится сообщение
            с предложением ее создать. Страница просмотра модели поделена на вкладки с основной информацией и с
            заказами, в которых она используется. На главной странице отображается виджет какусель с изображениями
            последних добавленных моделей.
            <p class="release_date">(11.05.2015)</p>
        </div>
    </div>

    <a id="showOldNews" href="#">Показать предыдущие записи</a>

    <div class="row-fluid news">
        <div class="span1"><i>0.4</i></div>
        <div class="span11" style="padding-bottom: 5%;">
            Yii обновлен до версии
            <a href="http://www.yiiframework.com/news/83/yii-1-1-16-is-released/" target="_blank">1.1.16</a>.
            Продолжена работа над улучшением архитектуры. Возможен множественный выбор материалов в заказе.
            Для использования сайта теперь необходимо обязательно авторизоваться: ввести логин и пароль (выдаются
            администратором после создания пользователя в админке). Использован компонент WebUser.
            Заказы и модели добавляются от имени того пользователя, под которым был осуществлен вход в систему (удален
            пункт выбора модельера из выпадающего списка). По аналогии с заказами, у моделей появился атрибут автор
            (заполняется автоматически). Повышена безопасность сайта. Комментарии к заказам и моделям и поле описание
            у моделей теперь являются полнотекстовыми и больше не ограниченны по длине. Добавлен специальный виджет,
            позволяющий форматировать текста при заполнении комментариев. На странице просмотра модели можно посмотреть
            заказы, в которых она используется. Серьезно изменена и переписана визуальная основа сайта: внешний вид
            базируется на
            <a target="_blank" href="http://www.getyiistrap.com/">Yiistrap (Twitter Bootstrap for Yii)</a>, основанный
            на
            <a target="_blank" href="http://getbootstrap.com/">Bootstrap</a>
            (<a target="_blank" href="http://getbootstrap.com/2.3.2/">v2.3.2</a>) с применением множества различных
            виджетов <a target="_blank" href="http://yiiwheels.2amigos.us/">YiiWheels</a>.
            Адаптивный и улучшенный дизайн. А также множество других более мелких улучшений, доработок и
            исправлений.
            <p class="release_date">(16.03.2015)</p>
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1"><i>0.3</i></div>
        <div class="span11" style="padding-bottom: 5%;">
            Yii обновлен до версии
            <a href="http://www.yiiframework.com/news/78/yii-1-1-15-is-released-security-fix/"
               target="_blank">1.1.15</a>.
            Каких-либо визуальных изменений
            практически нет, все изменения и доработки в основном "под капотом" сайта. Полностью переписана архитектура
            приложения. Текущая ветка имеет в основном чисто технический характер. В первую очередь
            уделено внимание безопасности сайта, его стабильности и оптимизации, с целью повышения производительности.
            Полностью переработан, доработан, оптимизирован и корректно оформлен код. Теперь конкретнее:
            <ul class="newsList">
                <li>
                    Внедрено кэширования данных (реализовано при помощи
                    <a target="_blank" href="http://redis.io/">Redis</a>). Задействовано расширение
                    <a target="_blank" href="https://bitbucket.org/limi7less/minscript/wiki/Home">minScript</a>
                    для сжатия js- и css-файлов. Включено кэширование схем БД для улучшения производительности.
                    Подключен php-акселлератор APC (Alternative PHP Cache).
                </li>
                <li>
                    Переработана структура БД, а ее создание вынесено в миграции, что
                    позволит в будущем производить безболезненные изменения в ее структуре, если это потребуется.
                </li>
                <li>
                    Автоматическое развертывание веб-приложения при помощи
                    <a target="_blank" href="http://www.vagrantup.com/">Vagrant</a>.
                </li>
                <li>
                    Удалять и редактировать заказы/модели можно только от имени администратора.
                </li>
                <li>
                    Более тесная и полная интеграция с фреймворком Yii.
                </li>
                <li>
                    Полноценная админка для создания, редактирования, удаления и просмотра моделей, материалов,
                    модельеров,
                    а также выполнения некоторых специфичных действий (выгрузка отчетов, бэкап базы данных и т.д).
                    Ужесточение прав доступа. Больше нет возможности создать новую модель при оформлении нового заказа,
                    теперь это возможно в соответствующем разделе меню (администратор это также может делать из
                    админки).
                    В таблице с заказами добавилась кнопка детального просмотра. Удален раздел "Поиск". Взамен появилась
                    строка фильтров, под названием столбцов таблиц, которая отвечает за поиск нужной информации.
                    Убрана регистрация, теперь только администратор имеет право заводить новых модельеров. Два
                    дополнительных раздела для моделей по аналогии с заказами: "новая модель" и "все модели".
                </li>
            </ul>
            <i>Начиная с этой версии, для работы сайта требуется версия PHP не ниже 5.4.</i>

            <p class="release_date">(01.02.2015)</p>
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1"><i>0.2.4</i></div>
        <div class="span11" style="padding-bottom: 1%;">
            Небольшая переработка структуры БД: добавлена возможность
            заносить свои материалы (в разделе администрирования). Вывод в разделе статистики информации о количестве
            реализованных заказов по месяцам по каждому модельеру. Для того чтобы увидеть эту информацию, необходимо
            кликнуть на название того месяца, подробности которого, вас интересуют. Небольшой багфикс.
            <p class="release_date">(18.02.2014)</p>
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1"><i>0.2.3</i></div>
        <div class="span11" style="padding-bottom: 1%;">
            Корректирующий релиз.
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
            <p class="release_date">(09.01.2014)</p>
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1" style="vertical-align:text-top"><i>0.2.2</i></div>
        <div class="span11" style="padding-bottom: 1%;">
            Добавлена возможность сохранять заказы
            в Excel за выбранный промежуток времени (реализована с помощью
            <a target="_blank" href="http://phpexcel.codeplex.com/">PHPExcel</a>)
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
            <p class="release_date">(17.11.2013)</p>
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1" style="vertical-align:text-top"><i>0.2.1</i></div>
        <div class="span11" style="padding-bottom: 1%;">
            Добавлены рандомные цитаты и быстрый поиск на страницу просмотра
            всех заказов. Восстановлена подсветка слов поиска в поисковых результатах. Добавлена динамическая сортировка
            заказов в результатах поиска и при просмотре всех заказов. Введено изображение по умолчанию для моделей,
            поиск заказов по комментарию, а также множество других исправлений, изменений и улучшений, делающие данную
            сборку весьма стабильной.
            <p class="release_date">(03.11.2013)</p>
        </div>
    </div>

    <div class="infoMessage row-fluid news">
        <div class="span1" style="vertical-align:text-top; padding: 1% 0;"><i><b>Сообщение:</b></i></div>
        <div class="span11" style="padding: 1% 0;"><b> Состоялся <u>релиз</u> приложения для Android по работе с базой
                данных -
                <a href="<?= Yii::app()->request->baseUrl; ?>/upload/OrthopedicDB.apk"><i>OrthopedicDB</i></a>
                (текущая версия 1.0).</b>
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1"><i>0.2</i></div>
        <div class="span11" style="padding-bottom: 5%;">
            Вновь проведена серьезная переработка сайта - сайт переписан под
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
            <p class="release_date">(23.09.2013)</p>
        </div>
    </div>

    <div class="infoMessage row-fluid news">
        <div class="span1" style="vertical-align:text-top; padding: 1% 0;"><i><b>Сообщение:</b></i></div>
        <div class="span11" style="padding: 1% 0;"><b> Доступна бета-версия приложения для Android по работе с базой
                данных -
                <a href="<?= Yii::app()->request->baseUrl; ?>/upload/OrthopedicDB.apk"><i>OrthopedicDB</i></a>
                (текущая версия 0.9.1).</b>
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1" style="vertical-align:text-top"><i>0.1.6.1</i></div>
        <div class="span11">Добавлен плагин jQuery FancyBox. Доработано автозаполнение для графы "Модель".
            Upstream Changes. <p class="release_date">(02.04.2013)</p>
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1" style="vertical-align:text-top"><i>0.1.6</i></div>
        <div class="span11">
            Фундаментальные переработка в структуре Базы Данных и, как
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
            <p class="release_date">(31.03.2013)</p>
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1" style="vertical-align:text-top"><i>0.1.5.8</i></div>
        <div class="span11">
            Усовершенствован поиск, стал более гибким (принимает
            по несколько значений, в том числе интервалы значений). В таблицу добавлен столбец "длина УРК". Добавлена
            возможность в любое время производить оптимизацию базы данных. Некоторые существенные исправления, в том
            числе исправлено удаление всех заказов из таблицы при удалении сотрудника, сделавшего их. Коррекция внешнего
            вида, доработана подсветка слов при поиске. Добавлен .htaccess для настройки сервера.
            <p class="release_date">(20.03.2013)</p>
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1" style="vertical-align:text-top"><i>0.1.5.7</i></div>
        <div class="span11">
            Подсветка ключевых слов по которым осуществлен поиск. Добавлена
            и отлажена верификация заполения формы при редактировании записей. Немного модифицирован интерфейс для боле
            комфортной работы. Множество мелких, а так же серьезных исправлений и доработок, переработана в той или иной
            степени почти каждая составляющая сайта.
            <p class="release_date">(13.03.2013)</p>
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1" style="vertical-align:text-top"><i>0.1.5.6</i></div>
        <div class="span11">
            Проверка заполнения форм до отправки. Исправлено автозаполнение
            комментариев, внесено множество некоторых исправлений. Добавлена поддержка возможностей JavaScript с
            применением библиотеки <a href="http://jquery.com/">jQuery</a>!
            <p class="release_date">(04.03.2013)</p>
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1" style="vertical-align:text-top"><i>0.1.5.5</i></div>
        <div class="span11">
            Добавлены различные виды меха в графу "материал". Добавлена возможность редактировать номер заказа.
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1" style="vertical-align:text-top"><i>0.1.5.4</i></div>
        <div class="span11">Поддержка работы сайта под сервером в ОС Windows: исправлены
            недочеты, свойственные при работе под этой ОС. Исправлены некоторые ошибки прошлых версий.
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1"><i>0.1.5.3</i></div>
        <div class="span11">Исправлены недочеты поиска. Поиск стал более гибким и точным.</div>
    </div>

    <div class="row-fluid news">
        <div class="span1" style="vertical-align:text-top"><i>0.1.5.2</i></div>
        <div class="span11">
            Убраны всплывающие подсказки при регистрации, увеличено
            количество символов в форме ФИО, убраны обязательные поля при поиске. Добавлено автозаполнение в поле
            "модель". Исправлены некоторые недочеты, подправлен внешний вид.
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1"><i>0.1.5.1</i></div>
        <div class="span11">
            Поддержка UTF-8. Исправлены недочеты при добавлении нового и удалении старого сотрудника.
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1"><i>0.1.5</i></div>
        <div class="span11">
            Добавлен раздел с HOWTO для сотрудников, корректировка вывода ошибок в лог и на экран.
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1" style="vertical-align:text-top"><i>0.1.4.9</i></div>
        <div class="span11">
            Добавлена сортировка по количеству строк при просмотре БД. Немного
            поправлено восстановление из резервной копии. Реализована функция "Сохранить как". Удалено "загрузка таблицы
            из файла" т.к в ней нет необходимости. Повышена безопасность.
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1" style="vertical-align:text-top"><i>0.1.4.8</i></div>
        <div class="span11">
            Переделан и доработан режим сохранения таблицы (одной таблицы) в
            файл (STABLE). Добавлена возможность сохранения ВСЕЙ Базы Данных (резервное копирование), а так же
            возможность восстановления базы из резервной копии. Доступна кнопка удаления всех заказов.
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1" style="vertical-align:text-top"><i>0.1.4.7</i></div>
        <div class="span11">
            Исправлена ошибка при сохранении таблицы в файл, если тот уже существует.
            Исправлены мелкие недочеты и ошибки.
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1" style="vertical-align:text-top"><i>0.1.4.6</i></div>
        <div class="span11">
            Исправлена ошибка дробных чисел в базе. Исправлен и оптимизирован
            поиск по базе данных. Небольшой багфикс, сокращено количество строк кода.
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1" style="vertical-align:text-top"><i>0.1.4.5</i></div>
        <div class="span11">
            Исправлена ошибка зацикливания, приводящая к невозможности
            пользоваться БД. Предусмотрено автоматическое создание таблиц БД при самом первом посещении сотрудника.
            Доступна возможность удалить сотрудника из базы.
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1" style="vertical-align:text-top"><i>0.1.4.4</i></div>
        <div class="span11">
            Исправлены ошибки при редактировании (STABLE) и удалении записей, а так же ошибки связанные с
            ФИО заказчиков и сотрудников. Немного пофиксил дизайн.
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1"><i>0.1.4.3</i></div>
        <div class="span11">Добавлена упрощенная форма регистрации сотрудников.</div>
    </div>

    <div class="row-fluid news">
        <div class="span1"><i>0.1.4.2</i></div>
        <div class="span11">
            Повышена производительность БД за счет оптимизации запросов. Исправлены некоторые недочеты и ошибки.
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1" style="vertical-align:text-top"><i>0.1.4.1</i></div>
        <div class="span11">
            Глобальное изменение сайта. Полностью переработанная и обновленная БД.
            Добавлена поддержка транзакций в запросах. Увеличение производительности базы за счет переработки.
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1"><i>0.1.3.1</i></div>
        <div class="span11">Добавлена возможность редактирования записей в БД (alfa)</div>
    </div>

    <div class="row-fluid news">
        <div class="span1" style="vertical-align:text-top"><i>0.1.3</i></div>
        <div class="span11">Добавлен лог ошибок. Возможность сохранения записей из БД в файл (alfa).
            Активирована кнопки печати. Подправлены стили и логика сайта.
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1"><i>0.1.2</i></div>
        <div class="span11">Обширный багфикс.</div>
    </div>

    <div class="row-fluid news">
        <div class="span1"><i>0.1.1</i></div>
        <div class="span11">
            Общая оптимизация за счет сокращения строк кода, исправления множества недочетов и ошибок.
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1" style="vertical-align:text-top"><i>0.1</i></div>
        <div class="span11">
            Первый, почти стабильный релиз с минимум возможностей.
            (практически все полностью переделано в версии 0.1.4.1)
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1" style="vertical-align:text-top"><i>0.0.9</i></div>
        <div class="span11">
            Технические наработки закончены. Сайт менялся часто и переписывался.
            Введен базовый временный стиль страницы. Переделаны пункты меню и навигации. Добавлены иконки and etc.
        </div>
    </div>

    <div class="row-fluid news">
        <div class="span1"><i>0.0.8</i></div>
        <div class="span11">Введена нумерация версий.</div>
    </div>
</div>

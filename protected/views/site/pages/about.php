<?php
/* @var $this SiteController */
$this->pageTitle=Yii::app()->name . ' - О сайте';
Yii::app()->clientScript->registerScript('about',"
  $(document).ready(function(){
    var query = window.location.hash.substring(1);
    $('.accordion h3').eq(query).addClass('active');
    $('.accordion p').eq(query).show();
    $('.accordion h3').click(function(){
      $(this).next('p').slideToggle('medium').siblings('p:visible').slideUp('medium');
      $(this).toggleClass('active');
      $(this).siblings('h3').removeClass('active');
    });
  });
", CClientScript::POS_READY);
?>

<div class="accordion">
  <h3>Общая информация</h3>
  <p>Прежче чем приступать к работе и дабавлять новые заказы, убедитесь, что зарегистрированы все сотрудники, которые будут непосредственно
  работать с базой данных. В противном случае Вы не сможете создать какой-либо новый заказ, модельером которого является
  незарегистрированныый сотрудник. Однако просматривать базу данных (БД), удалять, сохранять ее и редактировать отдельные заказы
  такому сотруднику не возбраняется.</p>

  <h3>Об удалении сотрудника</h3>
  <p>При удалении сотрудника, данные о нем удаляются не полность, дабы иметь возможность его восстановить, а также иметь доступ к заказам,
  сделанные под его именем. Удаление просто лишает Вас возможности заносить новые заказы от имени уволенного модельера. Чтобы восстановить 
  модельера, просто зарегистрируйте его заново. <i><u>Осторожно!</u></i> Если введенные при повторной регистрации данные не будут совпадать
  полностью с данными удаленного модельера, база данных расценит это как регистрацию абсолютно нового сотрудника, а не восстановление 
  удаленного.</p>

  <h3>Корректный ввод данных - залог верного ответа</h3>
  <p>При добавлении нового заказа, дробные числа следует вводить через точку "<b>.</b>"! Поиск может производиться в диапазонах, для 
  этого необходимо указать через дефис (без лишних пробелов между числами) минимальное и максимальное значение интересующей характеристики 
  модели, например размеры от 38 до 42 можно найти, введя (без кавычек) в соответствующее поле следующее: <code>"38-42"</code>. Если 
  необходимо найти еще и 32й размер то через пробел добавим и его, в итоге получим: <code>"38-42 32"</code> и так сколько угодно. 
  Аналогичный поиск может быть произведен в любом поле, но только если поиск ведется по числовым значениям. Этот нюанс относится к полю 
  "Модель", где помимо чисел могут быть и буквы. И все же старайтесь более точно задавать критерии поиска, это поспособствует
  снижению нагрузки на БД (особенно если в ней содержится очень большое количество информации (помним про оптимизацию БД)) и, как следствие, 
  более быстрой обработке Вашего поискового запроса, который приведет к точному результату.</p>

  <h3>О резервном копировании и восстановлении</h3>
  <p>Несмотря на все усилия, прилагаемые для того, чтобы защитить базы данных, такие ситуации, как перебои в электропитании, отказы 
  оборудования и другие причины все равно могут приводить к повреждению и даже потере данных. Поэтому базы данных следует обязательно 
  копировать и сохранять их копии в безопасном и надежном месте. Делать это лучше всего с определенной периодичностью, которая напрямую 
  зависит от ценности Вашей информации. В любом случае, чем чаще Вы это делаете, тем лучше, но учтите, что БД восстанавливается из резервной
  копии только до того состояния, в котором она пребывала на момент, когда Вы в последний раз выполняли ее резервное копирование!
  Резервная копия сохраняется  на компьютер, за которым Вы работаете, поэтому старайтесь ограничить доступ третьих лиц, если информация,
  сохраненная Вами, по-настоящему ценная и конфиденциальная.<br />
  При восстановлении БД, в целях предотвращения ошибок и повреждения текущей базы данных, пользуйтесь оригинальным
  файлом резервной копии, полученной с этого сайта.</p>

  <h3>Вывод отчета</h3>
  <p>
    Начиная с версии 0.2.2 стала доступна возможность сохранять заказы в Excel за выбранный промежуток времени. Имейте в виду, что чем
    больше разница между датами, тем, соответственно, больше заказов попадет в отчет за выбранный промежуток времени. Будьте готовы к тому,
    что время создания такого документа может занять некоторое время, т.к существенно увеличивается
    нагрузка на сервер. Вполне вероятна ситуация, связанная с нехваткой памяти. В этом случае обратитесь к системному админисратору с
    просьбой увеличить количество памяти, выделяемой серверу.
  </p>

  <h3>Рекомендации</h3>
  <p>
    1. Иногда, в зависимости от нагруженности базы информацией, рекомендуется производить ее оптимизацию, в целях уменьшения
    дефрагментации таблиц, получив в итоге лучшее быстродействие (особенно при поиске).<br />
    2. Настоятельно рекомендуется пользоваться сайтом при помощи браузера <a href="https://www.google.com/intl/ru/chrome/" >Google Chrome</a>.
  </p>

  <h3>О настройке сервера</h3>
  <p>
    <code>
      <span style="display:block; font-weight:600">PHP:</span>
        &nbsp;&nbsp;&nbsp;&nbsp;extension=php_gd2<br />
        &nbsp;&nbsp;&nbsp;&nbsp;extension=php_mbstring<br />
        &nbsp;&nbsp;&nbsp;&nbsp;extension=php_mysql<br />
        &nbsp;&nbsp;&nbsp;&nbsp;extension=php_mysqli<br />
        &nbsp;&nbsp;&nbsp;&nbsp;extension=php_pdo_mysql<br />
      <span style="display:block; font-weight:600">MySQL:</span>
        [mysql]<br />
        &nbsp;&nbsp;&nbsp;&nbsp;default-character-set=utf8<br />
        [mysqld]<br />
        &nbsp;&nbsp;&nbsp;&nbsp;character-set-server=utf8
    </code>
  </p>
</div><br />
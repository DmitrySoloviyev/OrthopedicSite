<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 05.04.15
 * Time: 0:45
 */

echo TbHtml::alert(TbHtml::ALERT_COLOR_INFO, '<h3>Резервирование базы данных</h3>
Этот раздел позволяет получить дамп содержимого базы данных. Дамп будет содержать набор команд SQL для создания
и/или заполнения таблиц. Полученный sql-файл применяется для развертывания базы данных в соответствующем разделе.');

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm');

echo TbHtml::submitButton('Создать резервную копию', ['color' => TbHtml::BUTTON_COLOR_INFO, 'name' => 'backupDbBtn',]);

$this->endWidget();

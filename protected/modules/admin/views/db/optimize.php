<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 03.04.15
 * Time: 23:06
 */

echo TbHtml::alert(TbHtml::ALERT_COLOR_INFO, '<h3>Оптимизация таблиц базы данных</h3>
Чтобы объединить фрагментированные записи и избавиться от потерь пространства, происходящих из-за постоянного
удаления и обновления записей, а также выполнить ремонт таблиц, анализ ключей и отсортировать дерево индексов
для ускорения поиска, запускайте оптимизацию приблизительно раз в месяц.'); ?>

<?= TbHtml::animatedProgressBar(100, ['color' => TbHtml::PROGRESS_COLOR_SUCCESS, 'style' => 'opacity: 0']); ?>

<?= TbHtml::ajaxButton('Начать оптимизацию',
    $this->createUrl('db/optimize'),
    [
        'type' => 'post',
        'data' => [Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken],
        'beforeSend' => 'js: function(data) { $("#optimizeDbBtn").button("loading"); $(".bar").parent().fadeTo("slow", 1); }',
        'success' => 'js: function(response) { $("#optimizeDbBtn").button("complete"); $(".bar").parent().fadeTo("slow", 0); }',
    ],
    [
        'id' => 'optimizeDbBtn',
        'loading' => 'Оптимизация...',
        'data-complete-text' => "Начать оптимизацию",
        'color' => TbHtml::BUTTON_COLOR_INFO,
    ]); ?>

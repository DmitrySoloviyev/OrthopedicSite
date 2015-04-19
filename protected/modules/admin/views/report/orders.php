<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 03.08.14
 * Time: 11:03
 *
 * @var $report Report
 */
echo TbHtml::alert(TbHtml::ALERT_COLOR_INFO, '<h3>Отчетность</h3>
При указании существенной разницы между датами, в отчет попадет большое количество записей. Будьте готовы к тому,
что время создания такого документа может занять некоторое время, т.к существенно увеличивается нагрузка на сервер.
Вполне вероятна ситуация, связанная с нехваткой памяти. В этом случае обратитесь к системному администратору с
просьбой увеличить количество памяти, выделяемой серверу.');
?>

<div class="form">
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'htmlOptions' => ['style' => 'margin:10px'],
    ]); ?>
    <fieldset>
        <legend class='legend'>Отчетность по заказам за период:</legend>
        <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', [
            'model' => $report,
            'attribute' => 'dateStart',
            'htmlOptions' => [
                'prepend' => TbHtml::icon(TbHtml::ICON_CALENDAR),
            ],
        ]); ?>
        &mdash;
        <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', [
            'model' => $report,
            'attribute' => 'dateEnd',
            'htmlOptions' => [
                'prepend' => TbHtml::icon(TbHtml::ICON_CALENDAR),
            ],
        ]); ?>

        <?= TbHtml::formActions([
            TbHtml::submitButton('Скачать', [
                'color' => TbHtml::BUTTON_COLOR_INFO,
            ]),
        ]); ?>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>

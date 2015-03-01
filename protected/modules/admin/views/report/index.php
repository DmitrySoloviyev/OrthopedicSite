<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 03.08.14
 * Time: 11:03
 *
 * @var $report Report
 */
?>

<div class="form">
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'htmlOptions' => ['style' => 'margin:10px'],
    ]); ?>
    <fieldset>
        <legend class='legend'>Отчет за период</legend>
        <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', [
            'model' => $report,
            'attribute' => 'dateStart',
        ]); ?>
        &mdash;
        <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', [
            'model' => $report,
            'attribute' => 'dateEnd',
        ]); ?>

        <?= TbHtml::formActions([
            TbHtml::submitButton('Сохранить в Excel', [
                'color' => TbHtml::BUTTON_COLOR_INFO,
            ]),
        ]); ?>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>

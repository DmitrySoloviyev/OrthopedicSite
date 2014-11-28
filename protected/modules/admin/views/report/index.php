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

<div class="form" style="float:left; width:50%;">
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'htmlOptions' => ['style' => 'margin:10px'],
    ]); ?>
    <fieldset>
        <legend class='legend'>Отчет за период</legend>
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', [
                'model' => $report,
                'attribute' => 'dateStart',
            ]);?>
            &nbsp;&mdash;&nbsp;
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', [
                'model' => $report,
                'attribute' => 'dateEnd',
            ]);?>

        <div class="submit">
            <?= CHtml::submitButton('Сохранить в Excel', ['class' => 'btn btn-primary']); ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>

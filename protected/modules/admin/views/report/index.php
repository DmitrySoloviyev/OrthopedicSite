<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 03.08.14
 * Time: 11:03
 */
?>

<div class="form" style="float:left; width:50%;">
    <?php $form = $this->beginWidget('CActiveForm', [
        'htmlOptions' => ['style' => 'margin:10px'],
        'action' => Yii::app()->createUrl('admin/generateExcel'),
    ]); ?>
    <fieldset>
        <legend class='legend'>Отчет за период</legend>
        <div class="row">
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', [
                'name' => 'startDate',
                'attribute' => 'startDate',
            ]);?>
            &nbsp;&mdash;&nbsp;
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', [
                'name' => 'endDate',
                'attribute' => 'endDate',
            ]);?>
        </div>
        <div class="row submit">
            <?= CHtml::submitButton('Сохранить в Excel', ['class' => 'button', 'name' => 'saveAsExcel']); ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>
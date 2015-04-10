<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 03.08.14
 * Time: 10:56
 *
 * @var $model Restore
 * @var $form TbActiveForm
 */

$this->widget('ext.yii-flash.Flash', [
    'keys' => ['success', 'error'],
    'js' => null,
]);
echo TbHtml::alert(TbHtml::ALERT_COLOR_WARNING, 'Загрузите полученную ранее резервную копию базы данных. <b>Внимание</b>, эта операция необратима!');
?>

<div class="form">
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'recovery-db-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->errorSummary($model); ?>

    <legend class='legend'>Восстановление базы данных</legend>

    <?= $form->fileFieldControlGroup($model, 'dump'); ?>

    <?= TbHtml::formActions([
        TbHtml::submitButton('Восстановить', [
            'color' => TbHtml::BUTTON_COLOR_WARNING,
            'name' => 'restoreBtn',
        ]),
    ]); ?>

    <?php $this->endWidget(); ?>
</div>

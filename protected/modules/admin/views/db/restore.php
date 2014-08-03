<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 03.08.14
 * Time: 10:56
 *
 * @var $form CFormModel
 * @var $model Restore
 */
?>

<div class="form">
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'recovery-db-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => ['enctype' => 'multipart/form-data'],
    ]); ?>
    <legend class='legend'>Восстановление базы данных</legend>
    <?php
    echo $form->errorSummary($model);
    if (Yii::app()->user->hasFlash('success')) {
        echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('success'));
    } elseif (Yii::app()->user->hasFlash('error')) {
        echo TbHtml::alert(TbHtml::ALERT_COLOR_ERROR, Yii::app()->user->getFlash('error'));
    }
    echo TbHtml::alert(TbHtml::ALERT_COLOR_WARNING, 'Загрузите полученную ранее резервную копию базы данных.
            <b>Внимание</b>, эта операция необратима!');
    echo $form->fileField($model, 'dump');
    ?>

    <div class="submit"><br/>
        <?= CHtml::submitButton('Восстановить', ['class' => 'btn btn-warning', 'name' => 'restoreBtn']); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>

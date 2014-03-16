<?php
/**
 * @var $employee Employee
 */
if (Yii::app()->user->isGuest) {
    $this->redirect(['site/login']);
    Yii::app()->end();
}
$this->pageTitle = Yii::app()->name . ' - Администрирование';
Yii::app()->clientScript->registerScriptFile('/js/hideFlash.js', CClientScript::POS_END);
?>

<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<?php if (Yii::app()->user->hasFlash('error')): ?>
    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>

<!-- Удалить модельера -->
<div class="form" style="float:left; width:50%; ">
    <?php $form = $this->beginWidget('CActiveForm', [
        'id' => 'employee-delete-form',
        'htmlOptions' => ['style' => 'margin:10px'],
        'action' => Yii::app()->createUrl('user/delete'),
    ]); ?>
    <fieldset>
        <legend class='legend'>Удалить модельера</legend>
        <div class="row">
            <?php
            echo $form->dropDownList($employee, 'id', $employee->employeeList(), [
                'empty' => 'Ф.И.О Модельера',
                'style' => 'width:204px'
            ]);
            echo $form->error($employee, 'id');
            ?>
        </div>
        <div class="row submit">
            <?= CHtml::submitButton('Удалить', ['class' => 'button']); ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div><!-- form -->

<!-- Оптимизировать БД -->
<div class="form" style="float:right; width:50%; ">
    <?php $form = $this->beginWidget('CActiveForm', [
        'id' => 'optimize-db-form',
        'htmlOptions' => ['style' => 'margin:10px'],
        'action' => Yii::app()->createUrl('admin/optimize'),
    ]); ?>
    <fieldset>
        <legend class='legend'>Оптимизация</legend>
        <div class="row" style="margin-bottom:21px">
            Оптимизировать Базу Данных
        </div>
        <div class="row submit">
            <?= CHtml::submitButton('Оптимизировать', ['class' => 'button', 'name' => 'optimizeDbBtn']); ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div><!-- form -->

<div class="clear"></div>

<!-- Резервирование БД -->
<div class="form" style="float:left; width:50%; ">
    <?php $form = $this->beginWidget('CActiveForm', [
        'id' => 'backup-db-form',
        'htmlOptions' => ['style' => 'margin:10px'],
        'action' => Yii::app()->createUrl('admin/backupDb'),
    ]); ?>
    <fieldset>
        <legend class='legend'>Резервирование</legend>
        <div class="row" style="margin-bottom:25px">
            Создать резервную копию БД
        </div>
        <div class="row submit">
            <?= CHtml::submitButton('Создать', ['class' => 'button', 'name' => 'backupDbBtn']); ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div><!-- form -->


<div class="form" style="float:right; width:50%; ">
    <?php $form = $this->beginWidget('CActiveForm', [
        'id' => 'recovery-db-form',
        'action' => Yii::app()->createUrl('admin/recoveryDb'),
        'htmlOptions' => [
            'enctype' => 'multipart/form-data',
            'style' => 'margin:10px',
        ],
    ]); ?>
    <fieldset>
        <legend class='legend'>Восстановить БД</legend>
        <div class="row">
            <?= CHtml::fileField('recoveryDb', ''); ?>
        </div>
        <div class="row submit">
            <?= CHtml::submitButton('Восстановить', ['class' => 'button', 'name' => 'recoveryDbBtn']); ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div><!-- form -->

<div class="clear"></div>

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

<!-- Новый материал -->
<div class="form" style="float:right; width:50%; ">
    <?php $form = $this->beginWidget('CActiveForm', [
        'id' => 'create-new-material-form',
        'htmlOptions' => [
            'style' => 'margin:10px',
        ],
        'action' => Yii::app()->createUrl('material/create'),
    ]); ?>
    <fieldset>
        <legend class='legend'>Новый материал</legend>
        <div class="row">
            <?php
                echo $form->TextField($material, 'material', [
                    'autocomplete' => 'Off',
                    'placeholder' => 'Название материала',
                    'class' => 'input_text'
                ]);
                echo $form->error($material, 'material');
            ?>
        </div>
        <div class="row submit">
            <?= CHtml::submitButton('Создать', ['class' => 'button', 'name' => 'newMaterialBtn']); ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div><!-- form -->

<div class="clear"></div>

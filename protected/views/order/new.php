<?php
/**
 * @var $order Order
 * @var $model Models
 */
$this->pageTitle = Yii::app()->name . ' - Новый заказ';
Yii::app()->clientScript->registerScriptFile('/js/hideFlash.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/js/model.js', CClientScript::POS_END);
$this->widget('ext.fancybox.EFancyBox', [
    'target' => '#ddd',
    'config' => [
        'enableEscapeButton' => true,
    ],
]);
$this->widget('ext.yii-flash.Flash', [
    'keys' => ['success', 'error'],
    'htmlOptions' => [
        'success' => ['class' => 'flash-success'],
        'error' => ['class' => 'flash-error'],
    ],
]);
?>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', [
        'id' => 'orders-new-form',
        'htmlOptions' => ['enctype' => 'multipart/form-data'],
    ]); ?>
    <fieldset class="formContainer">
        <legend style="margin-left:60px;">Новый заказ</legend>
        <?= $form->errorSummary($order) ?>
        <div id="leftForm">
            <div>№ заказа:</div>
            <div class="row">
                <?php
                echo $form->TextField($order, 'order_id', ['autocomplete' => 'Off', 'maxlength' => '10']);
                echo $form->error($order, 'order_id');
                ?>
            </div>

            <div>Модель:</div>
            <div class="row">
                <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', [
                    'model' => $model,
                    'attribute' => 'name',
                    'name' => 'name',
                    'source' => $this->createUrl("ajax/getmodels", [Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken]),
                    'options' => [
                        'showAnim' => 'fold',
                        'minLength' => '2',
                        'select' => new CJavaScriptExpression('function(event,ui) {
                                $("#Models_name").val(ui.item.label).change().blur();
                                $("#modelId").val(ui.item.id);
                                return false;
                            }'),
                    ],
                    'htmlOptions' => [
                        'id' => CHtml::activeId($model, 'name'),
                        'autocomplete' => 'Off',
                        'maxlength' => '6'
                    ],
                ]);

                echo '<br />' . $form->checkBox($model, 'is_new_model', ['disabled' => 'disabled']) . ' ';
                echo $form->labelEx($model, 'is_new_model', ['style' => 'font-weight: normal; font-style: italic; font-size: 0.9em; display: inline;']);
                echo $form->error($model, 'name');
                ?>
            </div>
            <input type="hidden" id="modelId" value=""/>

            <div>Размер:</div>
            <div class="row" style="float: left">
                <?= $form->TextField($order, 'size_left_id', ['autocomplete' => 'Off', 'maxlength' => '2']) ?>
            </div>
            <div class="row">
            <?= $form->TextField($order, 'size_right_id', ['autocomplete' => 'Off', 'maxlength' => '2']) ?>
            </div>
            <?php
                echo $form->error($order, 'size_left_id');
                echo $form->error($order, 'size_right_id');
            ?>


            <div>УРК:</div>
            <div class="row" style="float: left">
                <?= $form->TextField($order, 'urk_left_id', ['autocomplete' => 'Off', 'maxlength' => '3']) ?>
            </div>
            <div class="row">
                <?= $form->TextField($order, 'urk_right_id', ['autocomplete' => 'Off', 'maxlength' => '3']) ?>
            </div>
            <?php
                echo $form->error($order, 'urk_left_id');
                echo $form->error($order, 'urk_right_id');
            ?>

            <div>Материал:</div>
            <div class="row">
                <?php
                echo $form->dropDownList($order, 'material_id', Material::materialList(), ['empty' => 'Выберите материал']);
                echo $form->error($order, 'material_id');
                ?>
            </div>

            <div>Высота:</div>
            <div class="row" style="float: left">
                <?= $form->TextField($order, 'height_left_id', ['autocomplete' => 'Off', 'maxlength' => '2']) ?>
            </div>
            <div class="row">
                <?= $form->TextField($order, 'height_right_id', ['autocomplete' => 'Off', 'maxlength' => '2']) ?>
            </div>
            <?php
            echo $form->error($order, 'height_left_id');
            echo $form->error($order, 'height_right_id');
            ?>

            <div>Объем верха:</div>
            <div class="row" style="float: left">
                <?= $form->TextField($order, 'top_volume_left_id', ['autocomplete' => 'Off', 'maxlength' => '4']) ?>
            </div>
            <div class="row">
                <?= $form->TextField($order, 'top_volume_right_id', ['autocomplete' => 'Off', 'maxlength' => '4']) ?>
            </div>
            <?php
            echo $form->error($order, 'top_volume_left_id');
            echo $form->error($order, 'top_volume_right_id');
            ?>

            <div>Объем лодыжки:</div>
            <div class="row" style="float: left">
                <?= $form->TextField($order, 'ankle_volume_left_id', ['autocomplete' => 'Off', 'maxlength' => '4']) ?>
            </div>
            <div class="row">
                <?= $form->TextField($order, 'ankle_volume_right_id', ['autocomplete' => 'Off', 'maxlength' => '4']) ?>
            </div>
            <?php
            echo $form->error($order, 'ankle_volume_left_id');
            echo $form->error($order, 'ankle_volume_right_id');
            ?>

            <div title="косого взъема">Объем КВ:</div>
            <div class="row" style="float: left">
                <?= $form->TextField($order, 'kv_volume_left_id', ['autocomplete' => 'Off', 'maxlength' => '4']) ?>
            </div>
            <div class="row">
                <?= $form->TextField($order, 'kv_volume_right_id', ['autocomplete' => 'Off', 'maxlength' => '4']) ?>
            </div>
            <?php
            echo $form->error($order, 'kv_volume_left_id');
            echo $form->error($order, 'kv_volume_right_id');
            ?>

            <div>Заказчик:</div>
            <div class="row">
                <?= $form->TextField($customer, 'surname', ['autocomplete' => 'Off', 'maxlength' => '29', 'placeholder' => 'Фамилия']) ?>
            </div>
            <div class="row">
                <?= $form->TextField($customer, 'name', ['autocomplete' => 'Off', 'maxlength' => '29', 'placeholder' => 'Имя']) ?>
            </div>
            <div class="row">
                <?= $form->TextField($customer, 'patronymic', ['autocomplete' => 'Off', 'maxlength' => '29', 'placeholder' => 'Отчество']) ?>
            </div>
            <?php
            echo $form->error($customer, 'surname');
            echo $form->error($customer, 'name');
            echo $form->error($customer, 'patronymic');
            ?>

            <div>Модельер:</div>
            <div class="row">
                <?php
                echo $form->dropDownList($order, 'employee_id', Employee::employeeList(), ['empty' => 'Ф.И.О Модельера']);
                echo $form->error($order, 'employee_id');
                ?>
            </div>

            <div>Комментарий:</div>
            <div class="row">
                <?php
                echo $form->TextArea($order, 'comment', ['rows' => '5', 'cols' => '28']);
                echo $form->error($order, 'comment');
                ?>
            </div>

            <div class="row submit">
                <?= CHtml::submitButton('Записать', ['class' => 'button']); ?>
            </div>
        </div>

        <div id="modelForm">
            <?php $this->renderPartial('_model', ['model' => $model, 'form' => $form]); ?>
        </div>

        <div class="clear"></div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div><!-- form -->

<div id="hint">
    <i>Дробные числа обязательно<br/>вводить через точку.</i>
</div>

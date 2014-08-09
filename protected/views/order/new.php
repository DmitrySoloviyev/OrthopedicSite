<?php
/**
 * @var $order Order
 * @var $model Models
 * @var $customer Customer
 * @var $form CActiveForm
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
]); ?>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', [
        'id' => 'orders-new-form',
    ]); ?>
    <fieldset class="formContainer">
        <legend style="margin-left:60px;">Новый заказ</legend>
        <?= $form->errorSummary($order) ?>

        <table style="padding-left:20px;">
            <tr>
                <td style="width:180px" class="left_td">№ заказа:</td>
                <td style="width:330px">
                    <div class="row">
                        <?= $form->TextField($order, 'order_id', ['autocomplete' => 'Off', 'maxlength' => '10']); ?>
                        <?= $form->error($order, 'order_id'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Модель:</td>
                <td>
                    <div class="row">
                        <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', [
                            'name' => 'model_id_autocomplete',
                            'value' => isset($_POST['model_id_autocomplete']) ? $_POST['model_id_autocomplete'] : '',
                            'source' => $this->createUrl('ajax/GetModelByName', [
                                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken]),
                            'options' => [
                                'showAnim' => 'fold',
                                'minLength' => '2',
                                'select' => 'js:function(event,ui) {
                                    this.value = ui.item.value;
                                    $("#Order_model_id").val(ui.item.id);
                                    getModelInfoById(ui.item.id);
                                    return false;
                                }',
                            ],
                            'htmlOptions' => [
                                'autocomplete' => 'Off',
                                'maxlength' => '6',
                            ],
                        ]); ?>
                        <?= $form->TextField($order, 'model_id', ['hidden' => 'hidden']); ?>
                        <?= $form->error($order, 'model_id'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Размер:</td>
                <td>
                    <div class="row">
                        <?= $form->TextField($order, 'sizes', ['autocomplete' => 'Off', 'maxlength' => '5']) ?>
                        <?= $form->error($order, 'sizes'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>УРК:</td>
                <td>
                    <div class="row">
                        <?= $form->TextField($order, 'urks', ['autocomplete' => 'Off', 'maxlength' => '7']) ?>
                        <?= $form->error($order, 'urks'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Материал:</td>
                <td>
                    <div class="row">
                        <?= $form->dropDownList($order, 'material_id', Material::materialList(), ['empty' => 'Выберите материал']); ?>
                        <?= $form->error($order, 'material_id'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Высота:</td>
                <td>
                    <div class="row">
                        <?= $form->TextField($order, 'heights', ['autocomplete' => 'Off', 'maxlength' => '5']) ?>
                        <?= $form->error($order, 'heights'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Объем верха:</td>
                <td>
                    <div class="row">
                        <?= $form->TextField($order, 'top_volumes', ['autocomplete' => 'Off', 'maxlength' => '9']) ?>
                        <?= $form->error($order, 'top_volumes'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Объем лодыжки:</td>
                <td>
                    <div class="row">
                        <?= $form->TextField($order, 'ankle_volumes', ['autocomplete' => 'Off', 'maxlength' => '9']) ?>
                        <?= $form->error($order, 'ankle_volumes'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td title="косого взъема">Объем КВ:</td>
                <td>
                    <div class="row">
                        <?= $form->TextField($order, 'kv_volumes', ['autocomplete' => 'Off', 'maxlength' => '9']) ?>
                        <?= $form->error($order, 'kv_volumes'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Заказчик:</td>
                <td>
                    <div class="row">
                        <?= $form->TextField($customer, 'surname', ['autocomplete' => 'Off', 'maxlength' => '29', 'placeholder' => 'Фамилия']) ?>
                        <br>
                        <?= $form->TextField($customer, 'name', ['autocomplete' => 'Off', 'maxlength' => '29', 'placeholder' => 'Имя']) ?>
                        <br>
                        <?= $form->TextField($customer, 'patronymic', ['autocomplete' => 'Off', 'maxlength' => '29', 'placeholder' => 'Отчество']) ?>
                        <?= $form->error($customer, 'surname'); ?>
                        <?= $form->error($customer, 'name'); ?>
                        <?= $form->error($customer, 'patronymic'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Модельер:</td>
                <td>
                    <div class="row">
                        <?= $form->dropDownList($order, 'employee_id', Employee::employeeList(), ['empty' => 'Ф.И.О Модельера']); ?>
                        <?= $form->error($order, 'employee_id'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Комментарий:</td>
                <td>
                    <div class="row">
                        <?= $form->TextArea($order, 'comment', ['rows' => '5', 'cols' => '28']); ?>
                        <?= $form->error($order, 'comment'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="row submit">
                        <?= CHtml::submitButton('Записать', ['class' => 'button']); ?>
                    </div>
                </td>
            </tr>
            <!--<div id="modelForm">-->
            <!--            --><?php //$this->renderPartial('_model', ['model' => $model, 'form' => $form]); ?>
            <!--</div>-->
        </table>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>

<div id="hint">
    <i>Дробные числа обязательно<br/>вводить через точку.</i>
</div>

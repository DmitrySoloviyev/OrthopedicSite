<?php
/* @var $this OrderController */
/* @var $order Order */
/* @var $customer Customer */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', [
        'id' => 'order-form',
        'enableAjaxValidation' => false,
    ]); ?>

    <fieldset class="formContainer">
        <legend
            style="margin-left:60px;"><?= $order->isNewRecord ? 'Новый заказ' : 'Редактирование заказа №' . $order->order_name ?></legend>
        <?= $form->errorSummary($order); ?>

        <table style="padding-left:20px;">
            <tr>
                <td style="width:180px" class="left_td"><?= $form->labelEx($order, 'order_name'); ?>:</td>
                <td style="width:330px" colspan="2">
                    <div class="row">
                        <?= $form->textField($order, 'order_name', ['size' => 27, 'autocomplete' => 'Off', 'maxlength' => 10]); ?>
                        <?= $form->error($order, 'order_name'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td><?= $form->labelEx($order, 'model_id'); ?>:</td>
                <td colspan="2">
                    <div class="row">
                        <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', [
                            'name' => 'model_id_autocomplete',
                            'value' => is_object($order->model) ? $order->model->name : '',
                            'sourceUrl' => $this->createUrl('ajax/GetModelByName', [
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
                                'size' => 27,
                            ],
                        ]); ?>
                        <?= $form->TextField($order, 'model_id', ['hidden' => 'hidden']); ?>
                        <?= $form->error($order, 'model_id'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td><?= $form->labelEx($order, 'sizes'); ?>:</td>
                <td>
                    <div class="row">
                        <?= $form->TextField($order, 'size_left', ['size' => 3, 'autocomplete' => 'Off', 'maxlength' => '2']) ?>
                        <?= $form->error($order, 'size_left'); ?>
                    </div>
                </td>
                <td>
                    <div class="row">
                        <?= $form->TextField($order, 'size_right', [
                            'tabindex' => -1,
                            'size' => 3,
                            'autocomplete' => 'Off',
                            'maxlength' => '2']) ?>
                        <?= $form->error($order, 'size_right'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td><?= $form->labelEx($order, 'urks'); ?>:</td>
                <td>
                    <div class="row">
                        <?= $form->TextField($order, 'urk_left', [
                            'size' => 3,
                            'autocomplete' => 'Off',
                            'maxlength' => '3']) ?>
                        <?= $form->error($order, 'urk_left'); ?>
                    </div>
                </td>
                <td>
                    <div class="row">
                        <?= $form->TextField($order, 'urk_right', [
                            'tabindex' => -1,
                            'size' => 3,
                            'autocomplete' => 'Off',
                            'maxlength' => '3']) ?>
                        <?= $form->error($order, 'urk_right'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td><?= $form->labelEx($order, 'material_id'); ?>:</td>
                <td colspan="2">
                    <div class="row">
                        <?= $form->dropDownList($order, 'material_id', Material::materialList(), ['empty' => 'Выберите материал']); ?>
                        <?= $form->error($order, 'material_id'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td><?= $form->labelEx($order, 'heights'); ?>:</td>
                <td>
                    <div class="row">
                        <?= $form->TextField($order, 'height_left', ['size' => 3, 'autocomplete' => 'Off', 'maxlength' => '2']) ?>
                        <?= $form->error($order, 'height_left'); ?>
                    </div>
                </td>
                <td>
                    <div class="row">
                        <?= $form->TextField($order, 'height_right', [
                            'tabindex' => -1,
                            'size' => 3,
                            'autocomplete' => 'Off',
                            'maxlength' => '2']) ?>
                        <?= $form->error($order, 'height_right'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td><?= $form->labelEx($order, 'top_volumes'); ?>:</td>
                <td>
                    <div class="row">
                        <?= $form->TextField($order, 'top_volume_left', ['size' => 3, 'autocomplete' => 'Off', 'maxlength' => '4']) ?>
                        <?= $form->error($order, 'top_volume_left'); ?>
                    </div>
                </td>
                <td>
                    <div class="row">
                        <?= $form->TextField($order, 'top_volume_right', [
                            'tabindex' => -1,
                            'size' => 3,
                            'autocomplete' => 'Off',
                            'maxlength' => '4']) ?>
                        <?= $form->error($order, 'top_volume_right'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td><?= $form->labelEx($order, 'ankle_volumes'); ?>:</td>
                <td>
                    <div class="row">
                        <?= $form->TextField($order, 'ankle_volume_left', ['size' => 3, 'autocomplete' => 'Off', 'maxlength' => '4']) ?>
                        <?= $form->error($order, 'ankle_volume_left'); ?>
                    </div>
                </td>
                <td>
                    <div class="row">
                        <?= $form->TextField($order, 'ankle_volume_right', [
                            'tabindex' => -1,
                            'size' => 3,
                            'autocomplete' => 'Off',
                            'maxlength' => '4']) ?>
                        <?= $form->error($order, 'ankle_volume_right'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td title="косого взъема"><?= $form->labelEx($order, 'kv_volumes'); ?>:</td>
                <td>
                    <div class="row">
                        <?= $form->TextField($order, 'kv_volume_left', ['size' => 3, 'autocomplete' => 'Off', 'maxlength' => '4']) ?>
                        <?= $form->error($order, 'kv_volume_left'); ?>
                    </div>
                </td>
                <td>
                    <div class="row">
                        <?= $form->TextField($order, 'kv_volume_right', [
                            'tabindex' => -1,
                            'size' => 3,
                            'autocomplete' => 'Off',
                            'maxlength' => '4']) ?>
                        <?= $form->error($order, 'kv_volume_right'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td><?= $form->labelEx($order, 'customer_id'); ?>:</td>
                <td colspan="2">
                    <div class="row">
                        <?= $form->TextField($customer, 'surname', [
                            'size' => 27,
                            'autocomplete' => 'Off',
                            'maxlength' => '29',
                            'placeholder' => 'Фамилия']) ?>
                        <br>
                        <?= $form->TextField($customer, 'name', [
                            'size' => 27,
                            'autocomplete' => 'Off',
                            'maxlength' => '29',
                            'placeholder' => 'Имя']) ?>
                        <br>
                        <?= $form->TextField($customer, 'patronymic', [
                            'size' => 27,
                            'autocomplete' => 'Off',
                            'maxlength' => '29',
                            'placeholder' => 'Отчество']) ?>
                        <?= $form->error($customer, 'surname'); ?>
                        <?= $form->error($customer, 'name'); ?>
                        <?= $form->error($customer, 'patronymic'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td><?= $form->labelEx($order, 'employee_id'); ?>:</td>
                <td colspan="2">
                    <div class="row">
                        <?= $form->dropDownList($order, 'employee_id', Employee::employeeList(), ['empty' => 'Ф.И.О Модельера']); ?>
                        <?= $form->error($order, 'employee_id'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td><?= $form->labelEx($order, 'comment'); ?>:</td>
                <td colspan="2">
                    <div class="row">
                        <?= $form->TextArea($order, 'comment', ['rows' => '5', 'cols' => '27']); ?>
                        <?= $form->error($order, 'comment'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="row submit">
                        <?= CHtml::submitButton($order->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'button']); ?>
                    </div>
                </td>
            </tr>
            <div id="modelForm">
                <?php $this->renderPartial('_model', ['model' => $order->model]); ?>
            </div>
        </table>
    </fieldset>
    <?php $this->endWidget(); ?>

</div>

<div id="hint">
    <i>Дробные числа обязательно<br/>вводить через точку.</i>
</div>

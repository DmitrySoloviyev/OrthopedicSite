<?php
/* @var $this OrderController */
/* @var $order Order */
/* @var $customer Customer */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'order-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
    ]); ?>

    <?= $form->errorSummary($order); ?>

    <div class="row-fluid">
        <div class="span7">
            <div class="row-fluid">
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'order_name', ['span' => 5, 'autocomplete' => 'Off', 'maxlength' => 10]); ?>
                </div>
                <div class="span6">
<!--                    --><?//= $form->labelEx($order, 'material_id') ?>
<!--                    --><?php //$this->widget('yiiwheels.widgets.multiselect.WhMultiSelect', [
//                        'attribute' => 'material_id',
//                        'model' => $order,
//                        'data' => Material::materialList(),
//                        'pluginOptions' => ['empty' => 'd'],
//                    ]); ?>
                    <?= $form->dropDownListControlGroup($order, 'material_id', Material::materialList())?>
                </div>
            </div>
            <!--            --><? //= $form->labelEx($order, 'model_id'); ?>
            <!--            --><?php //$this->widget('zii.widgets.jui.CJuiAutoComplete', [
            //                'name' => 'model_id_autocomplete',
            //                'value' => is_object($order->model) ? $order->model->name : '',
            //                'sourceUrl' => $this->createUrl('ajax/GetModelByName', [
            //                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken]),
            //                'options' => [
            //                    'showAnim' => 'fold',
            //                    'minLength' => '2',
            //                    'select' => 'js:function(event,ui) {
            //                                    this.value = ui.item.value;
            //                                    $("#Order_model_id").val(ui.item.id);
            //                                    getModelInfoById(ui.item.id);
            //                                    return false;
            //                                }',
            //                ],
            //                'htmlOptions' => [
            //                    'autocomplete' => 'Off',
            //                    'maxlength' => '6',
            //                    'size' => 27,
            //                ],
            //            ]); ?>
            <!--            --><? //= $form->TextField($order, 'model_id', ['hidden' => 'hidden']); ?>
            <!--            --><? //= $form->error($order, 'model_id'); ?>
            <div class="row-fluid">
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'size_left', ['span' => 5]); ?>
                </div>
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'size_right', ['span' => 5]); ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'urk_left', ['span' => 5]); ?>
                </div>
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'urk_right', ['span' => 5]); ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'height_left', ['span' => 5, 'autocomplete' => 'Off', 'maxlength' => '2']); ?>
                </div>
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'height_right', ['span' => 5,
                        'tabindex' => -1,
                        'size' => 3,
                        'autocomplete' => 'Off',
                        'maxlength' => '2']); ?>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'top_volume_left', ['span' => 5, 'autocomplete' => 'Off', 'maxlength' => '4']); ?>
                </div>
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'top_volume_right', ['span' => 5, 'tabindex' => -1,
                        'size' => 3,
                        'autocomplete' => 'Off',
                        'maxlength' => '4']); ?>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'ankle_volume_left', ['span' => 5, 'autocomplete' => 'Off', 'maxlength' => '4']); ?>
                </div>
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'ankle_volume_right', ['span' => 5, 'tabindex' => -1,
                        'size' => 3,
                        'autocomplete' => 'Off',
                        'maxlength' => '4']); ?>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'kv_volume_left', ['span' => 5, 'autocomplete' => 'Off', 'maxlength' => '4']); ?>
                </div>
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'kv_volume_right', ['span' => 5, 'tabindex' => -1,
                        'size' => 3,
                        'autocomplete' => 'Off',
                        'maxlength' => '4']); ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <?= $form->labelEx($order, 'customer_id') ?>
                    <?= $form->telField($customer, 'customer_surname', [
                        'size' => 27,
                        'autocomplete' => 'Off',
                        'maxlength' => '29',
                        'required' => 'required',
                        'placeholder' => 'Фамилия']) ?>
                    <br>
                    <?= $form->TextField($customer, 'customer_name', [
                        'size' => 27,
                        'autocomplete' => 'Off',
                        'maxlength' => '29',
                        'placeholder' => 'Имя']) ?>
                    <br>
                    <?= $form->TextField($customer, 'customer_patronymic', [
                        'size' => 27,
                        'autocomplete' => 'Off',
                        'maxlength' => '29',
                        'placeholder' => 'Отчество']) ?>
                    <div class="control-group error">
                        <?= $form->error($customer, 'customer_surname'); ?>
                        <?= $form->error($customer, 'customer_name'); ?>
                        <?= $form->error($customer, 'customer_patronymic'); ?>
                    </div>
                </div>
                <div class="span6">
                    <?= $form->textAreaControlGroup($order, 'comment', ['maxlength' => 255, 'rows' => '5', 'cols' => '27']); ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <?= $form->dropDownListControlGroup($order, 'employee_id', Employee::employeeList(), ['empty' => 'Ф.И.О Модельера']); ?>
                </div>
            </div>
        </div>
        <div class="span5">
            <?php $this->renderPartial('_model', ['model' => $order->model]); ?>
        </div>
    </div>
    <?= TbHtml::formActions([
        TbHtml::submitButton($order->isNewRecord ? 'Создать' : 'Сохранить', [
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
        ]),
        TbHtml::resetButton('Очистить', [
            'color' => TbHtml::BUTTON_COLOR_DEFAULT,
        ]),
    ]); ?>
    <?php $this->endWidget(); ?>
</div>

<div id="hint">
    <i>Дробные числа обязательно<br/>вводить через точку.</i>
</div>

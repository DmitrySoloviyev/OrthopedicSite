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
    <?= TbHtml::alert(TbHtml::ALERT_COLOR_INFO, '', ['id' => 'createNewModel', 'style' => 'display:none']); ?>

    <div class="row-fluid">
        <div class="span7">
            <div class="row-fluid">
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'order_name', ['span' => 5, 'autocomplete' => 'Off', 'maxlength' => 10]); ?>
                </div>
                <div class="span6">
                    <?= $form->labelEx($order, 'model_id'); ?>
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
                            'response' => 'js:function(event,ui) {
                                if (ui.content.length === 0) {
                                    var searchedModel = $(this).val();
                                    var url = "/model/create?name=" + searchedModel;
                                    $("#createNewModel").html("<a target=\'_blank\' href=\'" + url + "\'>Указаная модель " + searchedModel + " не найдена. Создать ее сейчас?</a>").fadeIn();
                                } else {
                                    $("#createNewModel").fadeOut();
                                }
                            }',
                        ],
                        'htmlOptions' => [
                            'autocomplete' => 'Off',
                            'maxlength' => '6',
                            'size' => 27,
                            'class' => 'span5',
                        ],
                    ]); ?>
                    <?= $form->hiddenField($order, 'model_id'); ?>
                    <?= $form->error($order, 'model_id'); ?>
                </div>
            </div>
            <div class="row-fluid" style="padding-bottom: 25px;">
                <div class="span12">
                    <?= $form->labelEx($order, 'ordersHasMaterials') ?>
                    <?php $this->widget('yiiwheels.widgets.multiselect.WhMultiSelect', [
                        'model' => $order,
                        'attribute' => 'ordersHasMaterials',
                        'data' => Material::materialList(),
                        'pluginOptions' => [
                            'nonSelectedText' => 'Выберите материал(ы)',
                            'enableFiltering' => true,
                            'enableCaseInsensitiveFiltering' => true,
                            'filterPlaceholder' => 'Поиск материала',
                            'nSelectedText' => 'выбрано',
                            'maxHeight' => 400,
                        ],
                    ]); ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'size_left', ['span' => 5, 'autocomplete' => 'Off', 'maxlength' => 2]); ?>
                </div>
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'size_right', ['span' => 5, 'autocomplete' => 'Off', 'maxlength' => 2]); ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'urk_left', ['span' => 5, 'autocomplete' => 'Off', 'maxlength' => 3]); ?>
                </div>
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'urk_right', ['span' => 5, 'autocomplete' => 'Off', 'maxlength' => 3]); ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'height_left', ['span' => 5, 'autocomplete' => 'Off', 'maxlength' => 2]); ?>
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
                    <?= $form->textFieldControlGroup($order, 'top_volume_left', ['span' => 5, 'autocomplete' => 'Off', 'maxlength' => 4]); ?>
                </div>
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'top_volume_right', ['span' => 5, 'tabindex' => -1,
                        'size' => 3,
                        'autocomplete' => 'Off',
                        'maxlength' => 4]); ?>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'ankle_volume_left', ['span' => 5, 'autocomplete' => 'Off', 'maxlength' => 4]); ?>
                </div>
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'ankle_volume_right', ['span' => 5, 'tabindex' => -1,
                        'size' => 3,
                        'autocomplete' => 'Off',
                        'maxlength' => 4]); ?>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'kv_volume_left', ['span' => 5, 'autocomplete' => 'Off', 'maxlength' => 4]); ?>
                </div>
                <div class="span6">
                    <?= $form->textFieldControlGroup($order, 'kv_volume_right', ['span' => 5, 'tabindex' => -1,
                        'size' => 3,
                        'autocomplete' => 'Off',
                        'maxlength' => 4]); ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <?= $form->labelEx($order, 'customer_id') ?>
                    <?= $form->telField($customer, 'surname', [
                        'size' => 27,
                        'autocomplete' => 'Off',
                        'maxlength' => 29,
                        'required' => 'required',
                        'placeholder' => 'Фамилия']) ?>
                    <br>
                    <?= $form->TextField($customer, 'name', [
                        'size' => 27,
                        'autocomplete' => 'Off',
                        'maxlength' => 29,
                        'placeholder' => 'Имя']) ?>
                    <br>
                    <?= $form->TextField($customer, 'patronymic', [
                        'size' => 27,
                        'autocomplete' => 'Off',
                        'maxlength' => 29,
                        'placeholder' => 'Отчество']) ?>
                    <div class="control-group error">
                        <?= $form->error($customer, 'surname'); ?>
                        <?= $form->error($customer, 'name'); ?>
                        <?= $form->error($customer, 'patronymic'); ?>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <?= $form->labelEx($order, 'comment') ?>
                    <?php $this->widget('yiiwheels.widgets.redactor.WhRedactor', [
                        'model' => $order,
                        'attribute' => 'comment',
                        'pluginOptions' => [
                            'lang' => Yii::app()->language,
                        ],
                    ]); ?>
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

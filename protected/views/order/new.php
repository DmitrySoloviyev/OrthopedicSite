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
    <fieldset>
        <legend style="margin-left:60px;">Новый заказ</legend>
        <?= $form->errorSummary($order) ?>
        <table style="padding-left:20px;" border="1">
            <tr>
                <td style="width:180px" class="left_td">№ заказа:</td>
                <td style="width:330px">
                    <?php
                    echo $form->TextField($order, 'order_id', ['autocomplete' => 'Off', 'maxlength' => '10']);
                    echo $form->error($order, 'order_id');
                    ?>
                </td>
            </tr>
            <tr>
                <td class="left_td">Модель:</td>
                <td>
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
                    <input type="hidden" id="modelId" value=""/>
                </td>
            </tr>
            <tr>
                <td class="left_td">Размер:</td>
                <td>
                    <?php
                    echo $form->TextField($order, 'size_left_id', ['autocomplete' => 'Off', 'maxlength' => '2']);
                    echo $form->TextField($order, 'size_right_id', ['autocomplete' => 'Off', 'maxlength' => '2']);
                    echo $form->error($order, 'size_left_id');
                    echo $form->error($order, 'size_right_id');
                    ?>
                </td>
            </tr>
            <tr>
                <td class="left_td">УРК:</td>
                <td>
                    <?php
                    echo $form->TextField($order, 'urk_left_id', ['autocomplete' => 'Off', 'maxlength' => '3']);
                    echo $form->TextField($order, 'urk_right_id', ['autocomplete' => 'Off', 'maxlength' => '3']);
                    echo $form->error($order, 'urk_left_id');
                    echo $form->error($order, 'urk_right_id');
                    ?>
                </td>
            </tr>
            <tr>
                <td class="left_td">Материал:</td>
                <td>
                    <?php
                    echo $form->dropDownList($order, 'material_id', Material::materialList(), ['empty' => 'Выберите материал']);
                    echo $form->error($order, 'material_id');
                    ?>
                </td>
            </tr>
            <tr>
                <td class="left_td">Высота:</td>
                <td>
                    <?php
                    echo $form->TextField($order, 'height_left_id', ['autocomplete' => 'Off', 'maxlength' => '2']);
                    echo $form->TextField($order, 'height_right_id', ['autocomplete' => 'Off', 'maxlength' => '2']);
                    echo $form->error($order, 'height_left_id');
                    echo $form->error($order, 'height_right_id');
                    ?>
                </td>
            </tr>
            <tr>
                <td class="left_td">Объем верха:</td>
                <td>
                    <?php
                    echo $form->TextField($order, 'top_volume_left_id', ['autocomplete' => 'Off', 'maxlength' => '4']);
                    echo $form->TextField($order, 'top_volume_right_id', ['autocomplete' => 'Off', 'maxlength' => '4']);
                    echo $form->error($order, 'top_volume_left_id');
                    echo $form->error($order, 'top_volume_right_id');
                    ?>
                </td>
            </tr>
            <tr>
                <td class="left_td">Объем лодыжки:</td>
                <td>
                    <?php
                    echo $form->TextField($order, 'ankle_volume_left_id', ['autocomplete' => 'Off', 'maxlength' => '4']);
                    echo $form->TextField($order, 'ankle_volume_right_id', ['autocomplete' => 'Off', 'maxlength' => '4']);
                    echo $form->error($order, 'ankle_volume_left_id');
                    echo $form->error($order, 'ankle_volume_right_id');
                    ?>
                </td>
            </tr>
            <tr>
                <td title="косого взъема" class="left_td">Объем КВ:</td>
                <td>
                    <?php
                    echo $form->TextField($order, 'kv_volume_left_id', ['autocomplete' => 'Off', 'maxlength' => '4']);
                    echo $form->TextField($order, 'kv_volume_right_id', ['autocomplete' => 'Off', 'maxlength' => '4']);
                    echo $form->error($order, 'kv_volume_left_id');
                    echo $form->error($order, 'kv_volume_right_id');
                    ?>
                </td>
            </tr>
            <tr>
                <td>Заказчик:</td>
                <td>
                    <?php
                    echo $form->TextField($customer, 'surname', ['autocomplete' => 'Off', 'maxlength' => '29', 'placeholder' => 'Фамилия']);
                    echo $form->error($customer, 'surname');

                    echo $form->TextField($customer, 'name', ['autocomplete' => 'Off', 'maxlength' => '29', 'placeholder' => 'Имя']);
                    echo $form->error($customer, 'name');

                    echo $form->TextField($customer, 'patronymic', ['autocomplete' => 'Off', 'maxlength' => '29', 'placeholder' => 'Отчество']);
                    echo $form->error($customer, 'patronymic');
                    ?>
                </td>
            </tr>
            <tr>
                <td class="left_td">Модельер:</td>
                <td>
                    <?php
                    echo $form->dropDownList($order, 'employee_id', Employee::employeeList(), ['empty' => 'Ф.И.О Модельера']);
                    echo $form->error($order, 'id');
                    ?>
                </td>
            </tr>
            <tr>
                <td class="left_td">Комментарий:</td>
                <td>
                    <?php
                    echo $form->TextArea($order, 'comment', ['rows' => '5', 'cols' => '28']);
                    echo $form->error($order, 'comment');
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="row submit">
                        <?= CHtml::submitButton('Записать', ['class' => 'button']); ?>
                    </div>
                </td>
            </tr>
        </table>
    </fieldset>
    <?php $this->endWidget(); ?>
</div><!-- form -->

<div id="hint">
    <i>Дробные числа обязательно<br/>вводить через точку.</i>
</div>

<div id="ModelForm">
    <?php $this->renderPartial('_model', ['model' => $model, 'form' => $form]);?>
</div>

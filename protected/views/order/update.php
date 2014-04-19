<?php
if (Yii::app()->user->isGuest) {
    $this->redirect(['site/login']);
}
$this->pageTitle = Yii::app()->name . ' - Редактирование';

Yii::app()->clientScript->registerScript('model', "
// показываем/скрываем форму для модели
$('#ModelForm').css('opacity', '0');

var id = $('#basedID').val();
GetModelInfoById(id);
$('#ModelForm').animate({opacity: 1.0}, 800);
$('#Models_isNewModel').removeAttr('disabled');


$('#Models_ModelName').change(function(e){
    var modelName = $(this).val();
    if(modelName != ''){
    	$('#ModelForm').animate({opacity: 1.0}, 800);
    	$('#Models_isNewModel').removeAttr('disabled');

    	// необходимо выбрать из базы модель с указанным именем и ее айди и вывести информацию о ней в 
    	// соответствующую форму
    	// если в базе нет такой модели, ставим чекбокс - записываем как новую модель
    	// если в базе несколько одноименных моделей, показываем поочереди
		getModelInfo();
    }
    else{
    	$('#ModelForm').animate({opacity: 0.0}, 800);
    	$('#Models_isNewModel').attr('disabled', 'disabled');
    	$('#basedID').val('null');
    }
});

//обрабатываем нажатие на флажок
$('#Models_isNewModel').click(function() {
	if( $(this).is(':checked') ){
		loadNewModelForm();
	}else{
		$('#Models_ModelName').change();
		getModelInfo();
	}
}); 

function loadNewModelForm(){
	var modelName = $('#Models_ModelName').val();
	$('#Models_ModelPicture').attr('src', '#');
	$('#modelNameTitle').text('Новая модель № '+ modelName);
	$('#Models_ModelDescription').val('');
	$('#Models_DateModified').text('Дата изменения: ');
	$('#basedID').val('null');
	$('#pic').attr('href', '../../../'+1);
}

var Models = null;
var currentModel = 0;

//функция вывода информации о ТЕКУЩЕЙ модели
function GetModelInfoById(id){
	$.post('" . $this->createUrl('/site/GetModelInfoById') . "', {id:id}, function(data){
		var info = $.parseJSON(data);

			Models = info;
			//сохраняем ID модели в скрытое поле
			$('#Models_isNewModel').removeAttr('checked');
			$('#basedID').val(info[0].ModelID);
			$('#Models_ModelPicture').attr('src', '../../../'+info[0].ModelPicture);
			$('#pic').attr('href', '../../../'+info[0].ModelPicture);
			$('#Models_ModelDescription').val(info[0].ModelDescription);
			$('#modelNameTitle').text('Модель № ' + info[0].ModelName);
			$('#Models_DateModified').text('Дата изменения: ' + info[0].DateModified);

    });
}

//функция вывода информации о модели
function getModelInfo(){
	var modelName = $('#Models_ModelName').val();
	//пытаемся загрузить указанную модель, если ее не существует, отмечаем флажок и грузим форму создания новой модели
	$.post('" . $this->createUrl('/site/GetModelInfo') . "', {modelName:modelName}, function(data){
		var info = $.parseJSON(data);
		if(info[0] == undefined)
		{
			$('#Models_isNewModel').attr('checked', 'checked');
			loadNewModelForm();
		}
		else
		{
			Models = info;
			//сохраняем ID модели в скрытое поле
			$('#Models_isNewModel').removeAttr('checked');
			$('#basedID').val(info[0].ModelID);
			$('#Models_ModelPicture').attr('src', '../../../'+info[0].ModelPicture);
			$('#pic').attr('href', '../../../'+info[0].ModelPicture);
			$('#Models_ModelDescription').val(info[0].ModelDescription);
			$('#modelNameTitle').text('Модель № ' + info[0].ModelName);
			$('#Models_DateModified').text('Дата изменения: ' + info[0].DateModified);
		}
    });
}

//кнопка ДАЛЕЕ
$('#next').click(function(e){
    $('#ModelForm').hide('drop', {direction: 'left'}, 300);
	var checked = $('#Models_isNewModel').is(':checked');
	if(!checked){
	    if(Models != null && Models.length > 1)
	    {

	    	if(currentModel != Models.length-1)
	    		++currentModel;
	    	else
	    		currentModel = Models.length-1;

		    $('#Models_isNewModel').removeAttr('checked');
			$('#basedID').val(Models[currentModel].ModelID);
			$('#Models_ModelPicture').attr('src', '../../../'+Models[currentModel].ModelPicture);
			$('#pic').attr('href', '../../../'+Models[currentModel].ModelPicture);
			$('#Models_ModelDescription').val(Models[currentModel].ModelDescription);
			$('#modelNameTitle').text('Модель № ' + Models[currentModel].ModelName);
			$('#Models_DateModified').text('Дата изменения: ' + Models[currentModel].DateModified);
	    }
	}

    $('#ModelForm').show('drop', {direction: 'right'}, 300);
    e.preventDefault;
});
  
//кнопка НАЗАД
$('#previous').click(function(e){
	$('#ModelForm').hide('drop', {direction: 'right'}, 300);
    
    var checked = $('#Models_isNewModel').is(':checked');
	if(!checked){
		if(Models != null && Models.length > 1)
	    {
	    	if(currentModel != 0)
	    		--currentModel;
	    	else
	    		currentModel=0;
		    $('#Models_isNewModel').removeAttr('checked');
			$('#basedID').val(Models[currentModel].ModelID);
			$('#Models_ModelPicture').attr('src', '../../../'+Models[currentModel].ModelPicture);
			$('#pic').attr('href', '../../../'+Models[currentModel].ModelPicture);
			$('#Models_ModelDescription').val(Models[currentModel].ModelDescription);
			$('#modelNameTitle').text('Модель № ' + Models[currentModel].ModelName);
			$('#Models_DateModified').text('Дата изменения: ' + Models[currentModel].DateModified);
	    }
	}
    
    $('#ModelForm').show('drop', {direction: 'left'}, 300);
    e.preventDefault;
});

$('#ModelForm').draggable({
    delay:150,
    start:function(){
	    $(this).css('opacity', 0.6).css('cursor','move')
	  },
    stop:function(){
	    $(this).css('opacity', '').css('cursor','')
	  }
});

$('.closeWindow').click(function(e){
    $('#ModelForm').animate({opacity: 0.0}, 400);
    return false;
});

$('#hint').hide().delay(1000).slideDown(500).delay(1500).fadeOut(800);
", CClientScript::POS_READY);
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
    'id' => 'orders-update-form',
    'htmlOptions' => ['enctype' => 'multipart/form-data'],
]); ?>
<fieldset>
<legend style="margin-left:60px;">Редактирование</legend>
<?php echo $form->errorSummary($model); ?>
<table>
<tr>
    <td style="width:160px" class="left_td">№ заказа:</td>
    <td style="width:330px">
        <div class="row">
            <?php
            echo $form->TextField($model, 'OrderIDUpdate', ['autocomplete' => 'Off', 'maxlength' => '10', 'value' => $model->OrderID]);
            echo $form->error($model, 'OrderIDUpdate');
            ?>
        </div>
    </td>
</tr>
<tr>
    <td class="left_td">Модель:</td>
    <td>
        <div class="row">
            <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', [
                'model' => $modelsModel,
                'attribute' => 'ModelName',
                'name' => 'ModelName',
                'source' => $this->createUrl("/site/GetModelNames"),
                'options' => [
                    'minLength' => '2',
                    'select' => new CJavaScriptExpression('function(event,ui) {
							$("#Models_ModelName").val(ui.item.label).change().blur();
							return false;
						}')
                ],
                'htmlOptions' => [
                    'id' => CHtml::activeId($modelsModel, 'ModelName'),
                    'autocomplete' => 'Off',
                    'maxlength' => '6'
                ],
            ]);

            echo "<br />" . $form->checkBox($modelsModel, 'isNewModel', ['disabled' => 'disabled']) . " ";
            echo $form->labelEx($modelsModel, 'isNewModel', ['style' => 'font-weight: normal; font-style: italic; font-size: 0.9em; display: inline;']);
            echo $form->error($modelsModel, 'ModelName');
            echo $form->hiddenField($modelsModel, 'basedID', ['id' => 'basedID', 'value' => $modelsModel->ModelID]);
            $this->widget('ext.fancybox.EFancyBox', [
                'target' => '#pic',
                'config' => [
                    'enableEscapeButton' => true,
                ],
            ]);
            ?>
        </div>
    </td>
</tr>
<tr>
    <td class="left_td">Размер:</td>
    <td>
        <div class="row">
            <?php
            echo $form->TextField($model, 'SizeLEFTUpdate', ['autocomplete' => 'Off', 'maxlength' => '2', 'value' => $model->sizeLEFT->SizeValue, 'size' => 2]);
            echo "<span class='delimiter'></span>";
            echo $form->TextField($model, 'SizeRIGHTUpdate', ['autocomplete' => 'Off', 'maxlength' => '2', 'value' => $model->sizeRIGHT->SizeValue, 'size' => 2]);
            echo $form->error($model, 'SizeLEFTUpdate');
            echo $form->error($model, 'SizeRIGHTUpdate');
            ?>
        </div>
    </td>
</tr>
<tr>
    <td class="left_td">УРК:</td>
    <td>
        <div class="row">
            <?php
            echo $form->TextField($model, 'UrkLEFTUpdate', ['autocomplete' => 'Off', 'maxlength' => '3', 'value' => $model->urkLEFT->UrkValue, 'size' => 2]);
            echo "<span class='delimiter'></span>";
            echo $form->TextField($model, 'UrkRIGHTUpdate', ['autocomplete' => 'Off', 'maxlength' => '3', 'value' => $model->urkRIGHT->UrkValue, 'size' => 2]);
            echo $form->error($model, 'UrkLEFTUpdate');
            echo $form->error($model, 'UrkRIGHTUpdate');
            ?>
        </div>
    </td>
</tr>
<tr>
    <td class="left_td">Материал:</td>
    <td>
        <div class="row">
            <?php
            echo $form->dropDownList($materialsModel, 'MaterialID', $materialsModel->getMaterialsList());
            echo $form->error($materialsModel, 'MaterialID');
            ?>
        </div>
    </td>
</tr>
<tr>
    <td class="left_td">Высота:</td>
    <td>
        <div class="row">
            <?php
            echo $form->TextField($model, 'HeightLEFTUpdate', ['autocomplete' => 'Off', 'maxlength' => '2', 'value' => $model->heightLEFT->HeightValue, 'size' => 2]);
            echo "<span class='delimiter'></span>";
            echo $form->TextField($model, 'HeightRIGHTUpdate', ['autocomplete' => 'Off', 'maxlength' => '2', 'value' => $model->heightRIGHT->HeightValue, 'size' => 2]);
            echo $form->error($model, 'HeightLEFTUpdate');
            echo $form->error($model, 'HeightRIGHTUpdate');
            ?>
        </div>
    </td>
</tr>
<tr>
    <td class="left_td">Объем верха:</td>
    <td>
        <div class="row">
            <?php
            echo $form->TextField($model, 'TopVolumeLEFTUpdate', ['autocomplete' => 'Off', 'maxlength' => '4', 'value' => $model->topVolumeLEFT->TopVolumeValue, 'size' => 2]);
            echo "<span class='delimiter'></span>";
            echo $form->TextField($model, 'TopVolumeRIGHTUpdate', ['autocomplete' => 'Off', 'maxlength' => '4', 'value' => $model->topVolumeRIGHT->TopVolumeValue, 'size' => 2]);
            echo $form->error($model, 'TopVolumeLEFTUpdate');
            echo $form->error($model, 'TopVolumeRIGHTUpdate');
            ?>
        </div>
    </td>
</tr>
<tr>
    <td class="left_td">Объем лодыжки:</td>
    <td>
        <div class="row">
            <?php
            echo $form->TextField($model, 'AnkleVolumeLEFTUpdate', ['autocomplete' => 'Off', 'maxlength' => '4', 'value' => $model->ankleVolumeLEFT->AnkleVolumeValue, 'size' => 2]);
            echo "<span class='delimiter'></span>";
            echo $form->TextField($model, 'AnkleVolumeRIGHTUpdate', ['autocomplete' => 'Off', 'maxlength' => '4', 'value' => $model->ankleVolumeRIGHT->AnkleVolumeValue, 'size' => 2]);
            echo $form->error($model, 'AnkleVolumeLEFTUpdate');
            echo $form->error($model, 'AnkleVolumeRIGHTUpdate');
            ?>
        </div>
    </td>
</tr>
<tr>
    <td title="косого взъема" class="left_td">Объем КВ:</td>
    <td>
        <div class="row">
            <?php
            echo $form->TextField($model, 'KvVolumeLEFTUpdate', ['autocomplete' => 'Off', 'maxlength' => '4', 'value' => $model->kvVolumeLEFT->KvVolumeValue, 'size' => 2]);
            echo "<span class='delimiter'></span>";
            echo $form->TextField($model, 'KvVolumeRIGHTUpdate', ['autocomplete' => 'Off', 'maxlength' => '4', 'value' => $model->kvVolumeRIGHT->KvVolumeValue, 'size' => 2]);
            echo $form->error($model, 'KvVolumeLEFTUpdate');
            echo $form->error($model, 'KvVolumeRIGHTUpdate');
            ?>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2">
        Заказчик:
        <div style="margin-left:60px">
            <div class="row">
                <?php
                echo $form->TextField($customersModel, 'CustomerSNUpdate', ['autocomplete' => 'Off', 'maxlength' => '29', 'placeholder' => 'Фамилия', 'value' => $model->customer->CustomerSN]);
                echo $form->error($customersModel, 'CustomerSNUpdate');
                ?>
            </div>
            <div class="row">
                <?php
                echo $form->TextField($customersModel, 'CustomerFNUpdate', ['autocomplete' => 'Off', 'maxlength' => '29', 'placeholder' => 'Имя', 'value' => $model->customer->CustomerFN]);
                echo $form->error($customersModel, 'CustomerFNUpdate');
                ?>
            </div>
            <div class="row">
                <?php
                echo $form->TextField($customersModel, 'CustomerPUpdate', ['autocomplete' => 'Off', 'maxlength' => '29', 'placeholder' => 'Отчество', 'value' => $model->customer->CustomerP]);
                echo $form->error($customersModel, 'CustomerPUpdate');
                ?>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td class="left_td">Модельер:</td>
    <td>
        <div class="row">
            <?php
            echo $form->dropDownList($employeesModel, 'EmployeeID', $employeesModel->getEmployeeList($employeesModel->EmployeeID));
            echo $form->error($employeesModel, 'EmployeeID');
            ?>
        </div>
    </td>
</tr>
<tr>
    <td class="left_td">Комментарий:</td>
    <td><?php
        echo $form->TextArea($model, 'Comment', ['rows' => '5', 'cols' => '28']);
        echo $form->error($model, 'Comment');
        ?>
    </td>
</tr>
<tr>
    <td colspan="3">
        <div class="row submit">
            <?= CHtml::submitButton('Исправить', ['class' => 'button']); ?>
            <?=
            CHtml::submitButton('Удалить заказ', [
                'class' => 'button_delete',
                'style' => 'margin-left: 6%;',
                'submit' => [
                    'order/delete',
                    'id' => $model->OrderID,
                ],
                'params' => [
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                ],
                'confirm' => 'Вы действительно хотите удалить этот заказ?',
            ]);?>
        </div>
    </td>
</tr>
</table>
</fieldset>
<?php $this->endWidget(); ?>
</div><!-- form -->
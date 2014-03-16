<?php $this->pageTitle = Yii::app()->name . ' - Новый заказ';
Yii::app()->clientScript->registerScriptFile('/js/hideFlash.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScript('model', "
// показываем/скрываем форму для модели
$('#ModelForm').css('opacity', '0');

var name = $('#Models_ModelName').val();
if(name != ''){
    	$('#ModelForm').animate({opacity: 1.0}, 800);
    	$('#Models_isNewModel').removeAttr('disabled');
		getModelInfo();
}

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
		$('#pic').attr('href', '../../'+1);
		$('#basedID').val('null');
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
}

var Models = null;
var currentModel = 0;

//функция вывода информации о модели
function getModelInfo(){
	var modelName = $('#Models_ModelName').val();
	//пытаемся загрузить указанную модель, если ее не существует, отмечаем флажок и грузим форму создания новой модели
	$.post('" . $this->createUrl('site/GetModelInfo') . "', {modelName:modelName}, function(data){
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
			$('#Models_ModelPicture').attr('src', '../../'+info[0].ModelPicture);
			$('#pic').attr('href', '../../'+info[0].ModelPicture);
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
			$('#Models_ModelPicture').attr('src', '../../'+Models[currentModel].ModelPicture);
			$('#pic').attr('href', '../../'+Models[currentModel].ModelPicture);
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
			$('#Models_ModelPicture').attr('src', '../../'+Models[currentModel].ModelPicture);
			$('#pic').attr('href', '../../'+Models[currentModel].ModelPicture);
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

<div class="form">
<?php $form = $this->beginWidget('CActiveForm', [
    'id' => 'orders-new-form',
    'enableClientValidation' => true,
    'clientOptions' => ['validateOnSubmit' => true],
    'htmlOptions' => ['enctype' => 'multipart/form-data'],
]); ?>
<fieldset>
<legend style="margin-left:60px;">Новый заказ</legend>
<?php echo $form->errorSummary($order); ?>
<table style="padding-left:20px;">
    <tr>
        <td style="width:180px" class="left_td">№ заказа:</td>
        <td style="width:330px">
            <div class="row">
                <?php
                    echo $form->TextField($order, 'order_id', ['autocomplete' => 'Off', 'maxlength' => '10']);
                    echo $form->error($order, 'order_id');
                ?>
            </div>
        </td>
        <td id="ModelForm" rowspan="10">
            <a href="#" class="closeWindow"></a>
            <fieldset>
                <legend style="margin-left:30px;">Модель</legend>
                <table>
                    <tr>
                        <td colspan="2" style="font-style: normal; font-size: 1em; text-align:center">
                            <span id="previous"><img src="/images/previous.png" height="16" width="16"/></span>
                            <span id="modelNameTitle">Модель №</span>
                            <span id="next"><img src="/images/next.png" height="16" width="16"/></span>
                            <hr/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
	    						<span id="pic">
	    							<img id='Models_ModelPicture' src="#" alt='изображение модели' width="200"
                                         height="200"/>
	    						</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Загрузить изображение:
                            <?= $form->fileField($model, 'picture', ['class' => 'loadImgModel']); ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 1px;">Описание:</td>
                        <td>
                            <?php
                                echo $form->TextArea($model, 'description', ['rows' => '6', 'cols' => '30', 'autocomplete' => 'Off']);
                                echo $form->error($model, 'description');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" id='Models_DateModified'>Дата изменения: <?= $model->date_modified; ?></td>
                    </tr>
                </table>
            </fieldset>
        </td>
    </tr>
    <tr>
        <td class="left_td">Модель:</td>
        <td>
            <div class="row">
                <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', [
                    'model' => $model,
                    'attribute' => 'name',
                    'name' => 'name',
                    'source' => $this->createUrl("site/getModels"),
                    'options' => [
                        'minLength' => '2',
                        'select' => new CJavaScriptExpression('function(event,ui) {
							$("#Models_ModelName").val(ui.item.label).change().blur();
							return false;
						}')
                    ],
                    'htmlOptions' => [
                        'id' => CHtml::activeId($model, 'ModelName'),
                        'autocomplete' => 'Off',
                        'maxlength' => '6'
                    ],
                ]);

                echo "<br />" . $form->checkBox($model, 'isNewModel', ['disabled' => 'disabled']) . " ";
                echo $form->labelEx($model, 'isNewModel', ['style' => 'font-weight: normal; font-style: italic; font-size: 0.9em; display: inline;']);
                echo $form->error($model, 'ModelName');
                echo $form->hiddenField($model, 'basedID', ['id' => 'basedID']);
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
                    echo $form->TextField($order, 'size', ['autocomplete' => 'Off', 'maxlength' => '5']);
                    echo $form->error($order, 'size');
                ?>
            </div>
        </td>
    </tr>
    <tr>
        <td class="left_td">УРК:</td>
        <td>
            <div class="row">
                <?php
                    echo $form->TextField($order, 'urk', ['autocomplete' => 'Off', 'maxlength' => '7']);
                    echo $form->error($order, 'urk');
                ?>
            </div>
        </td>
    </tr>
    <tr>
        <td class="left_td">Материал:</td>
        <td>
            <div class="row">
                <?php
                    echo $form->dropDownList($material, 'id', $material->getMaterialsList(), ['empty' => 'Выберите материал']);
                    echo $form->error($material, 'id');
                ?>
            </div>
        </td>
    </tr>
    <tr>
        <td class="left_td">Высота:</td>
        <td>
            <div class="row">
                <?php
                    echo $form->TextField($order, 'height', ['autocomplete' => 'Off', 'maxlength' => '5']);
                    echo $form->error($order, 'height');
                ?>
            </div>
        </td>
    </tr>
    <tr>
        <td class="left_td">Объем верха:</td>
        <td>
            <div class="row">
                <?php
                    echo $form->TextField($order, 'topVolume', ['autocomplete' => 'Off', 'maxlength' => '9']);
                    echo $form->error($order, 'topVolume');
                ?>
            </div>
        </td>
    </tr>
    <tr>
        <td class="left_td">Объем лодыжки:</td>
        <td>
            <div class="row">
                <?php
                    echo $form->TextField($order, 'ankleVolume', ['autocomplete' => 'Off', 'maxlength' => '9']);
                    echo $form->error($order, 'ankleVolume');
                ?>
            </div>
        </td>
    </tr>
    <tr>
        <td title="косого взъема" class="left_td">Объем КВ:</td>
        <td>
            <div class="row">
                <?php
                    echo $form->TextField($order, 'kvVolume', ['autocomplete' => 'Off', 'maxlength' => '9']);
                    echo $form->error($order, 'kvVolume');
                ?>
            </div>
        </td>
    </tr>
    <tr>
        <td>Заказчик:</td>
        <td colspan="2">
            <div class="row">
                <?php
                    echo $form->TextField($customer, 'surname', ['autocomplete' => 'Off', 'maxlength' => '29', 'placeholder' => 'Фамилия']);
                    echo $form->error($customer, 'surname');
                ?>
            </div>
            <div class="row">
                <?php
                    echo $form->TextField($customer, 'name', ['autocomplete' => 'Off', 'maxlength' => '29', 'placeholder' => 'Имя']);
                    echo $form->error($customer, 'name');
                ?>
            </div>
            <div class="row">
                <?php
                    echo $form->TextField($customer, 'patronymic', ['autocomplete' => 'Off', 'maxlength' => '29', 'placeholder' => 'Отчество']);
                    echo $form->error($customer, 'patronymic');
                ?>
            </div>
        </td>
    </tr>
    <tr>
        <td class="left_td">Модельер:</td>
        <td>
            <div class="row">
                <?php
                    echo $form->dropDownList($employee, 'id', $employee->getEmployeeList(), ['empty' => 'Ф.И.О Модельера']);
                    echo $form->error($employee, 'id');
                ?>
            </div>
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

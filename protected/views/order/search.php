<?php $this->pageTitle = Yii::app()->name . ' - Поиск';

Yii::app()->clientScript->registerScript('search', "
var Models = null;
var currentModel = 0;

//обрабатываем нажатие на флажок
$('#showAllModels').click(function() {
	if( $(this).is(':checked') ){
		getAllModelsInfo();
	}else{
		$('#Models_ModelName').val();
	}
});

//функция вывода информации о модели
function getAllModelsInfo(){
	var modelName = $('#Models_ModelName').val();

	$.post('" . $this->createUrl('/site/GetAllModelsInfo') . "', {}, function(data){
		var info = $.parseJSON(data);
		Models = info;
		$('#Models_ModelName').val(info[0].ModelName);
		$('#Models_ModelPicture').attr('src', info[0].ModelPicture);
		$('#pic').attr('href', '../../'+info[0].ModelPicture);
		$('#Models_ModelDescription').append(info[0].ModelDescription);
		$('#modelNameTitle').text('Модель № ' + info[0].ModelName);
		$('#Models_DateModified').text('Дата изменения: ' + info[0].DateModified);
    });
}

//кнопка ДАЛЕЕ
$('#next').click(function(e){
    $('#ModelForm').hide('drop', {direction: 'left'}, 300);

	    if(Models != null && Models.length > 1)
	    {
	    	if(currentModel < Models.length-1){
	    		currentModel++;

	    		$('#Models_ModelName').val(Models[currentModel].ModelName);
				$('#Models_ModelPicture').attr('src', Models[currentModel].ModelPicture);
				$('#pic').attr('href', '../../'+Models[currentModel].ModelPicture);
				$('#Models_ModelDescription').text(Models[currentModel].ModelDescription);
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

		if(Models != null && Models.length > 1)
	    {
	    	if(currentModel != 0)
	    		--currentModel;
	    	else
	    		currentModel=0;

	    		$('#Models_ModelName').val(Models[currentModel].ModelName);
				$('#Models_ModelPicture').attr('src', Models[currentModel].ModelPicture);
				$('#pic').attr('href', '../../'+Models[currentModel].ModelPicture);
				$('#Models_ModelDescription').text(Models[currentModel].ModelDescription);
				$('#modelNameTitle').text('Модель № ' + Models[currentModel].ModelName);
				$('#Models_DateModified').text('Дата изменения: ' + Models[currentModel].DateModified);
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

$('#search_header').hide();

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
    <h3 id="search_header" class="title_header" width="100%"></h3>
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'ordersSearchForm',
        'enableClientValidation' => false,
        'clientOptions' => array('validateOnSubmit' => false),
        'method' => 'GET'
    )); ?>
    <fieldset>
        <legend style="margin-left:60px;">Поиск</legend>
        <?php echo $form->errorSummary($model); ?>
        <table style="padding-left:20px;">
            <tr>
                <td style="width:160px" class="left_td">№ заказа:</td>
                <td style="width:330px">
                    <div class="row">
                        <?php
                        echo $form->TextField($model, 'OrderID', array('autocomplete' => 'Off'));
                        echo $form->error($model, 'OrderID'); ?>
                    </div>
                </td>
                <td id="ModelForm" rowspan="10">
                    <a href="#" class="closeWindow"></a>
                    <fieldset>
                        <legend style="margin-left:30px;">Модель</legend>
                        <table>
                            <tr>
                                <td colspan="2" style="font-style: normal; font-size: 1em; text-align:center">
                                    <span id="previous"><img src="/images/previous.png"/></span>
                                    <span id="modelNameTitle">Модель №</span>
                                    <span id="next"><img src="/images/next.png"/></span>
                                    <hr/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                <span id="pic"><img id='Models_ModelPicture'
                                                    src=<?php echo "'" . $modelsModel->ModelPicture . "'"; ?> alt='изображение
                                                    модели' width="200" height="200" />
                                </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 1px;">Описание:</td>
                                <td id='Models_ModelDescription'><?php echo CHtml::encode($modelsModel->ModelDescription); ?></td>
                            </tr>
                            <tr>
                                <td colspan="2" id='Models_DateModified'>Дата
                                    изменения: <?php echo CHtml::encode($modelsModel->DateModified); ?></td>
                            </tr>
                        </table>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <td class="left_td">Модель:</td>
                <td>
                    <div class="row">
                        <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'model' => $modelsModel,
                            'attribute' => 'ModelName',
                            'name' => 'ModelName',
                            'source' => $this->createUrl("/site/GetModelNames"),
                            'options' => array(
                                'minLength' => '1',
                                'select' => new CJavaScriptExpression('function(event,ui) {
							$("#Models_ModelName").val(ui.item.label).change();
							return false;
						}')
                            ),
                            'htmlOptions' => array(
                                'id' => CHtml::activeId($modelsModel, 'ModelName'),
                                'autocomplete' => 'Off',
                                'maxlength' => '6'
                            ),
                        ));
                        echo "<br /><input type='checkbox' id='showAllModels'/><label for='showAllModels' style='font-weight: normal; font-style: italic; font-size: 0.9em; display: inline;'>Показать все модели</label>";
                        echo $form->error($modelsModel, 'ModelName');
                        $this->widget('ext.fancybox.EFancyBox', array(
                            'target' => '#pic',
                            'config' => array(
                                'enableEscapeButton' => true,
                            ),
                        ));
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="left_td">Размер:</td>
                <td>
                    <div class="row">
                        <?php
                        echo $form->TextField($model, 'Size', array('autocomplete' => 'Off'));
                        echo $form->error($model, 'Size');?>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="left_td">УРК:</td>
                <td>
                    <div class="row">
                        <?php
                        echo $form->TextField($model, 'Urk', array('autocomplete' => 'Off'));
                        echo $form->error($model, 'Urk');?>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="left_td">Материал:</td>
                <td>
                    <div class="row">
                        <?php
                        echo $form->checkBoxList($materialsModel, 'MaterialID', $materialsModel->getMaterialsList());
                        echo $form->error($materialsModel, 'MaterialID');?>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="left_td">Высота:</td>
                <td>
                    <div class="row">
                        <?php
                        echo $form->TextField($model, 'Height', array('autocomplete' => 'Off'));
                        echo $form->error($model, 'Height');?>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="left_td">Объем верха:</td>
                <td>
                    <div class="row">
                        <?php
                        echo $form->TextField($model, 'TopVolume', array('autocomplete' => 'Off'));
                        echo $form->error($model, 'TopVolume');?>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="left_td">Объем лодыжки:</td>
                <td>
                    <div class="row">
                        <?php
                        echo $form->TextField($model, 'AnkleVolume', array('autocomplete' => 'Off'));
                        echo $form->error($model, 'AnkleVolume');?>
                    </div>
                </td>
            </tr>
            <tr>
                <td title="косого взъема" class="left_td">Объем КВ:</td>
                <td>
                    <div class="row">
                        <?php
                        echo $form->TextField($model, 'KvVolume', array('autocomplete' => 'Off'));
                        echo $form->error($model, 'KvVolume');?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Заказчик:</td>
                <td colspan="2">
                    <div class="row">
                        <?php
                        echo $form->TextField($customersModel, 'CustomerSN', array('autocomplete' => 'Off', 'placeholder' => 'Фамилия'));
                        echo $form->error($customersModel, 'CustomerSN');?>
                    </div>
                    <div class="row">
                        <?php
                        echo $form->TextField($customersModel, 'CustomerFN', array('autocomplete' => 'Off', 'placeholder' => 'Имя'));
                        echo $form->error($customersModel, 'CustomerFN');?>
                    </div>
                    <div class="row">
                        <?php
                        echo $form->TextField($customersModel, 'CustomerP', array('autocomplete' => 'Off', 'placeholder' => 'Отчество'));
                        echo $form->error($customersModel, 'CustomerP');?>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="left_td">Модельер:</td>
                <td colspan="2">
                    <?php
                    echo $form->checkBoxList($employeesModel, 'EmployeeID', $employeesModel->getEmployeeList());
                    echo $form->error($employeesModel, 'EmployeeID');
                    ?>
                </td>
            </tr>
            <tr>
                <td class="left_td">Комментарий:</td>
                <td><?php echo $form->TextArea($model, 'Comment', array('rows' => '4', 'cols' => '22')); ?></td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="row submit">
                        <?php echo CHtml::submitButton('Искать', array('class' => 'button')); ?>
                    </div>
                </td>
            </tr>
        </table>
    </fieldset>
    <?php $this->endWidget(); ?>
    </div><!-- form -->
    <div id="hint">
        <i>Поля, оставленные пустыми,<br/> участвовать в поиске не будут.<br/>
            Для задания диапазона используйте тире "-". Отделяйте каждое значение и диапазон значений пробелом.
        </i>
    </div>


<?php if (isset($_GET['Orders'])) {
    Yii::app()->clientScript->registerScript('searchResults', "
$('#hint').hide();
$('#search_result').addClass('expand');
$('#ModelForm').hide();
$('#ordersSearchForm').slideUp('medium');
$('#search_header').show().text('Критерии поиска:');

$('#search_header').click(function(){
	$('#ordersSearchForm').slideToggle(600);
	$(this).toggleClass('expand');
	$('#ModelForm').show();
});
", CClientScript::POS_READY);
    $sort = $dataProvider->getSort();
    ?>
    <div id="searchResult">
        <h3 class="title_header" id="search_result" style="cursor:default">Найдено
            заказов: <?= $dataProvider->totalItemCount ?></h3>
        <table cols='14' border='2' class='dboutput'>
            <tr>
                <th><?= $sort->link('OrderID', '№ заказа', array('class' => 'sorter_link')); ?></th>
                <th><?= $sort->link('ModelName', 'Модель', array('class' => 'sorter_link')); ?></th>
                <th>Размер</th>
                <th>Длина УРК</th>
                <th><?= $sort->link('MaterialID', 'Материал', array('class' => 'sorter_link')); ?></th>
                <th>Высота</th>
                <th>Объем верха</th>
                <th>Объем лодыжки</th>
                <th>Объем КВ</th>
                <th>Заказчик</th>
                <th><?= $sort->link('EmployeeID', 'Модельер', array('class' => 'sorter_link')); ?></th>
                <th><?= $sort->link('Date', 'Дата заказа', array('class' => 'sorter_link')); ?></th>
                <th width="110px">Комментарий</th>
                <?php if (!Yii::app()->user->isGuest): ?>
                    <th>Правка</th>
                    <th>Удалить</th>
                <?php endif; ?>
            </tr>
            <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $dataProvider,
                'itemView' => '_view',
                'emptyText' => 'Поиск не дал результатов.',
                'ajaxUpdate' => true,
                'summaryText' => '',
            ));
            ?>
        </table>
    </div>
<?php
} else {
    Yii::app()->clientScript->registerScript('hideHint', "
		$('#hint').hide().delay(1000).slideDown(500).delay(2000).fadeOut(2000);
	", CClientScript::POS_READY);
}
?>
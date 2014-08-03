<?php
$beforeSend = <<< JSBS
    $('#ModelForm').addClass('loading');
JSBS;

$success = <<< JSS
    var data = $.parseJSON(data);
    $('#Models_description').text(data.description);
    $('#ddd').attr('src', data.picture);
    $('#modelNameTitle').text('Модель № ' + data.name);

    $('#ModelForm').removeClass('loading');
JSS;
?>

<div id="navLeft">
    <?=
    CHtml::ajaxLink("<img src='/images/arrow_left.png' height=48 width='48' />",
        $this->createUrl('ajax/prevmodel', [Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken]),
        [
            ['replace' => '#ModelForm'],
            'data' => [
                'id' => 'js:$("#Models_name").val()',
                'name' => 'js:$("#modelId").val()',
            ],
            'beforeSend' => "function(request) { " . $beforeSend . " }",
            'success' => "function(data){ " . $success . " }",
        ],
        ['id' => 'previous',]
    );?>
</div>

<div id="navRight">
    <?=
    CHtml::ajaxLink("<img src='/images/arrow_right.png' height=48 width='48' />",
        $this->createUrl('ajax/nextmodel', [Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken]),
        [
            ['replace' => '#ModelForm'],
            'data' => [
                'id' => 'js:$("#Models_name").val()',
                'name' => 'js:$("#modelId").val()',
            ],
            'beforeSend' => "function(request) { " . $beforeSend . " }",
            'success' => "function(data){ " . $success . " }",
        ],
        ['id' => 'next']
    );?>
</div>

<div id="modelContent">

    <span style="font-style: italic; font-size: 1.1em;">Модель № <?= CHtml::encode($model->name) ?></span>

    <div id="pic">
        <img src="../../../upload/OrthopedicGallery/ortho.jpg" href="../../../upload/OrthopedicGallery/ortho.jpg" id="ddd" alt='изображение модели' />
    </div>

    <label style="display: block;text-align: center;cursor: pointer;">
        <a>Загрузить изображение
            <?= $form->fileField($model, 'picture', ['class' => 'loadImgModel', 'style' => 'display:none']); ?>
        </a>
    </label>

    <div style="margin: 3% auto">
        <?php
        echo $form->TextArea($model, 'description', ['rows' => '10', 'cols' => '39', 'autocomplete' => 'Off', 'placeholder' => 'Описание модели']);
        echo $form->error($model, 'description');
        ?>
    </div>

    <div class="subInfo">Дата изменения: <?= $model->date_modified; ?></div>
</div>

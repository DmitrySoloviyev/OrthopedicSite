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
<table>
    <tr>
        <td colspan="2" style="font-style: normal; font-size: 1em; text-align:center">
            <?= CHtml::ajaxLink(
                "<img src='/images/previous.png' height='16' width='16' />",
                $this->createUrl('ajax/prevmodel', [Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken]),
                [
                    ['replace' => '#ModelForm'],
                    'data' => [
                        'id' => "1",
                        'name' => 'винтажная'
                    ],
                    'beforeSend' => "function(request) { " . $beforeSend . " }",
                    'success' => "function(data){ " . $success . " }",
                ],
                ['id' => 'previous',]
            );?>

            <span id="modelNameTitle">Модель № <?= CHtml::encode($model->name) ?></span>

            <?= CHtml::ajaxLink(
                "<img src='/images/next.png' height='16' width='16' />",
                $this->createUrl('ajax/nextmodel', [Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken]),
                [
                    ['replace' => '#ModelForm'],
                    'data' => [
                        'id' => "2",
                        'name' => 'винтажная'
                    ],
                    'beforeSend' => "function(request) { " . $beforeSend . " }",
                    'success' => "function(data){ " . $success . " }",
                ],
                ['id' => 'next']
            );?>
            <hr/>
            <br/>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <span id="pic"><img src="#" id="ddd" alt='изображение модели' width="200" height="200"/></span>
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
        <td colspan="2" id='Models_date_modified'>Дата изменения: <?= $model->date_modified; ?></td>
    </tr>
</table>

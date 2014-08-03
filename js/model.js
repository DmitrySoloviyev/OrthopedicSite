/**
 * Created by dmitry on 21.03.14.
 */

function getModelInfoById(id) {
    $.get('/ajax/GetModelInfoById', {id: id}, function (data) {
        console.log(data);
    });
}

function resetModelView() {

}

jQuery(function ($) {

    $('#Models_name').change(function () {
        var name = $(this).val();
        if (name != '') {
            $('#Models_is_new_model').removeAttr('disabled');
        }
    });

    /*
     $('#Models_ModelName').change(function (e) {
     var modelName = $(this).val();
     if (modelName != '') {
     $('#ModelForm').animate({opacity: 1.0}, 800);
     $('#Models_isNewModel').removeAttr('disabled');

     // необходимо выбрать из базы модель с указанным именем и ее айди и вывести информацию о ней в
     // соответствующую форму если в базе нет такой модели, ставим чекбокс - записываем как новую модель
     // если в базе несколько одноименных моделей, показываем их поочереди
     getModelInfo();
     }
     else {
     $('#ModelForm').animate({opacity: 0.0}, 800);
     $('#Models_isNewModel').attr('disabled', 'disabled');
     $('#basedID').val('null');
     }
     });

     //обрабатываем нажатие на флажок
     $('#Models_isNewModel').click(function () {
     if ($(this).is(':checked')) {
     loadNewModelForm();
     $('#pic').attr('href', '../../' + 1);
     $('#basedID').val('null');
     } else {
     $('#Models_ModelName').change();
     getModelInfo();
     }
     });

     function loadNewModelForm() {
     var modelName = $('#Models_ModelName').val();
     $('#Models_ModelPicture').attr('src', '#');
     $('#modelNameTitle').text('Новая модель № ' + modelName);
     $('#Models_ModelDescription').val('');
     $('#Models_DateModified').text('Дата изменения: ');
     $('#basedID').val('null');
     }

     var Models = null;
     var currentModel = 0;

     //функция вывода информации о модели
     function getModelInfo() {
     var modelName = $('#Models_ModelName').val();
     //пытаемся загрузить указанную модель, если ее не существует, отмечаем флажок и грузим форму создания новой модели
     $.post('/ajax/getmodelinfo', {modelName: modelName}, function (data) {
     var info = $.parseJSON(data);
     if (info[0] == undefined) {
     $('#Models_isNewModel').attr('checked', 'checked');
     loadNewModelForm();
     }
     else {
     Models = info;
     //сохраняем ID модели в скрытое поле
     $('#Models_isNewModel').removeAttr('checked');
     $('#basedID').val(info[0].ModelID);
     $('#Models_ModelPicture').attr('src', '../../' + info[0].ModelPicture);
     $('#pic').attr('href', '../../' + info[0].ModelPicture);
     $('#Models_ModelDescription').val(info[0].ModelDescription);
     $('#modelNameTitle').text('Модель № ' + info[0].ModelName);
     $('#Models_DateModified').text('Дата изменения: ' + info[0].DateModified);
     }
     });
     }

     //кнопка ДАЛЕЕ
     $('#next').click(function (e) {
     $('#ModelForm').hide('drop', {direction: 'left'}, 300);
     var checked = $('#Models_isNewModel').is(':checked');
     if (!checked) {
     if (Models != null && Models.length > 1) {

     if (currentModel != Models.length - 1)
     ++currentModel;
     else
     currentModel = Models.length - 1;

     $('#Models_isNewModel').removeAttr('checked');
     $('#basedID').val(Models[currentModel].ModelID);
     $('#Models_ModelPicture').attr('src', '../../' + Models[currentModel].ModelPicture);
     $('#pic').attr('href', '../../' + Models[currentModel].ModelPicture);
     $('#Models_ModelDescription').val(Models[currentModel].ModelDescription);
     $('#modelNameTitle').text('Модель № ' + Models[currentModel].ModelName);
     $('#Models_DateModified').text('Дата изменения: ' + Models[currentModel].DateModified);
     }
     }

     $('#ModelForm').show('drop', {direction: 'right'}, 300);
     e.preventDefault;
     });

     //кнопка НАЗАД
     $('#previous').click(function (e) {
     $('#ModelForm').hide('drop', {direction: 'right'}, 300);

     var checked = $('#Models_isNewModel').is(':checked');
     if (!checked) {
     if (Models != null && Models.length > 1) {
     if (currentModel != 0)
     --currentModel;
     else
     currentModel = 0;
     $('#Models_isNewModel').removeAttr('checked');
     $('#basedID').val(Models[currentModel].ModelID);
     $('#Models_ModelPicture').attr('src', '../../' + Models[currentModel].ModelPicture);
     $('#pic').attr('href', '../../' + Models[currentModel].ModelPicture);
     $('#Models_ModelDescription').val(Models[currentModel].ModelDescription);
     $('#modelNameTitle').text('Модель № ' + Models[currentModel].ModelName);
     $('#Models_DateModified').text('Дата изменения: ' + Models[currentModel].DateModified);
     }
     }

     $('#ModelForm').show('drop', {direction: 'left'}, 300);
     e.preventDefault;
     });
     */

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#ddd').attr('href', e.target.result).attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#Models_picture').change(function () {
        readURL(this);
    });
    /*
     $('#ModelForm').draggable({
     delay: 150,
     start: function () {
     $(this).css('opacity', 0.6).css('cursor', 'move')
     },
     stop: function () {
     $(this).css('opacity', '').css('cursor', '')
     }
     });
     */
    $('#hint').hide().delay(1000).slideDown(500).delay(1500).fadeOut(800);

    var order_size_left_id = $('#Order_size_left_id');
    order_size_left_id.change(function () {
        $('#Order_size_right_id').val(order_size_left_id.val());
    });

    var urk_left_id = $('#Order_urk_left_id');
    urk_left_id.change(function () {
        $('#Order_urk_right_id').val(urk_left_id.val());
    });

    var height_left_id = $('#Order_height_left_id');
    height_left_id.change(function () {
        $('#Order_height_right_id').val(height_left_id.val());
    });

    var top_volume_left_id = $('#Order_top_volume_left_id');
    top_volume_left_id.change(function () {
        $('#Order_top_volume_right_id').val(top_volume_left_id.val());
    });

    var ankle_volume_left_id = $('#Order_ankle_volume_left_id');
    ankle_volume_left_id.change(function () {
        $('#Order_ankle_volume_right_id').val(ankle_volume_left_id.val());
    });

    var kv_volume_left_id = $('#Order_kv_volume_left_id');
    kv_volume_left_id.change(function () {
        $('#Order_kv_volume_right_id').val(kv_volume_left_id.val());
    });

});

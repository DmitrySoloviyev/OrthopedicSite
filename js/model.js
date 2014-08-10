/**
 * Created by dmitry on 21.03.14.
 */

function getModelInfoById(id) {
    $.get('/ajax/GetModelInfoById', {id: id}, function (data) {
        var name = $('#name');
        var picture = $('#picture');
        var picture_resource = $('#picture_resource');
        var description = $('#description');
        var date_created = $('#date_created');
        var date_modified = $('#date_modified');

        var json_data = $.parseJSON(data);

        name.html('Модель № <a href="/model/view?id=' + json_data.id + '">' + json_data.name + '</a>');
        picture_resource.attr('href', '/upload/OrthopedicGallery/' + json_data.picture);
        picture_resource.attr('src', '/upload/OrthopedicGallery/' + json_data.picture);
        description.html('Описание модели: ' + json_data.description);
        date_created.html('Дата создания: ' + json_data.date_created);
        date_modified.html('Последнее изменение: ' + json_data.date_modified);
    });
}

jQuery(function ($) {
    $('#hint').hide().delay(1000).slideDown(500).delay(1500).fadeOut(800);

});

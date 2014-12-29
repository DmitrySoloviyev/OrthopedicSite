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

        name.html('Модель № <a target=_blank href="/model/view?id=' + json_data.id + '">' + json_data.name + '</a>');
        picture_resource.attr('href', '/upload/OrthopedicGallery/' + json_data.picture);
        picture_resource.attr('src', '/upload/OrthopedicGallery/' + json_data.picture);
        description.html(json_data.description);
        date_created.html(json_data.date_created);
        date_modified.html(json_data.date_modified);
    });
}

var order_size_left = $('#Order_size_left');
order_size_left.change(function () {
    $('#Order_size_right').val(order_size_left.val());
});

var urk_left = $('#Order_urk_left');
urk_left.change(function () {
    $('#Order_urk_right').val(urk_left.val());
});

var height_left = $('#Order_height_left');
height_left.change(function () {
    $('#Order_height_right').val(height_left.val());
});

var top_volume_left = $('#Order_top_volume_left');
top_volume_left.change(function () {
    $('#Order_top_volume_right').val(top_volume_left.val());
});

var ankle_volume_left = $('#Order_ankle_volume_left');
ankle_volume_left.change(function () {
    $('#Order_ankle_volume_right').val(ankle_volume_left.val());
});

var kv_volume_left = $('#Order_kv_volume_left');
kv_volume_left.change(function () {
    $('#Order_kv_volume_right').val(kv_volume_left.val());
});

jQuery(function ($) {
    $('#hint').hide().delay(1000).slideDown(500).delay(1500).fadeOut(800);
});

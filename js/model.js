/**
 * Created by dmitry on 21.03.14.
 */

function getModelInfoById(id) {
    $.get('/ajax/GetModelInfoById', {id: id}, function (data) {
        console.log(data);
    });
}

jQuery(function ($) {
    $('#hint').hide().delay(1000).slideDown(500).delay(1500).fadeOut(800);

});

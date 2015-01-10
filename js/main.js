/**
 * Created by dmitry on 15.03.14.
 */
jQuery(function ($) {
    $('#center').hide().fadeIn(700);

    //перемотка вверх
    var back_top = $('#back-top');
    back_top.hide();
    $(function ($) {
        $(window).scroll(function () {
            if ($(this).scrollTop() >= 400) {
                back_top.slideDown();
            } else {
                back_top.fadeOut();
            }
        });
        // scroll body to 0px on click
        back_top.find('a').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 700);
            return false;
        });
    });//конец перемотка вверх

    var quickSearchVal = $('#quickSearch');
    var quickSearchForm = $('#quickSearchForm');

    quickSearchVal.focus(function () {
        console.log(234);
        quickSearchForm.css({
            'background-color': '#f7f7f7',
            'border-color': 'black'
        });
    });
    quickSearchVal.focusout(function () {
        console.log(234);
        quickSearchForm.css({
            'border-color': '',
            'background-color': '#E4E4E4'
        });
    });

    //пункты меню
    $('#navigation').find('ul li a').mouseup(function (event) {
        if (event.which == 1)
            $(this).parent().addClass('active');
    });
});

$(function ($) {

});
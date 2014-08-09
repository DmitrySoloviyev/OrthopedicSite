/**
 * Created by dmitry on 03.08.14.
 */

jQuery(function ($) {
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#preview').attr('href', e.target.result).attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $('input[type=file]').change(function () {
        readURL(this);
    });

});

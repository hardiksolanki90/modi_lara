$(document).ready(function() {
    $(document).on('submit', '.myForm', function(e) {
        e.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), '', 'json').always(function(data) {
            if (data == 'success') {
                M.toast({ html: 'I am a toast!', classes: 'rounded' });
            }
            if (data == 'error') {
                M.toast({ html: 'I am a toast!', classes: 'rounded' });
            }
        }).fail(function(data) {
            if (data.status === 422) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (key, val) {
                    M.toast({ html: val, classes: 'rounded' });
                });
            }
        });
    });
});
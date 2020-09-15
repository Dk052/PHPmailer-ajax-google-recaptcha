(function ($) {
    'use strict';

    var form = $('#contactform'),
        message = $('#contact-form'),
        form_data;

    // Success function
    function done_func(response) {
        // redirect to thankyou site
        window.location.replace('thankyou.html');
        message.fadeIn().removeClass('alert-danger').addClass('alert-success');
        message.text(response);
        setTimeout(function () {
            message.fadeOut();
        }, 10000);
        form.find('input:not([type="submit"]), textarea').val('');
    }

    // fail function
    function fail_func(data) {
        message.fadeIn().removeClass('alert-success').addClass('alert-success');
        message.text(data.responseText);
        setTimeout(function () {
            message.fadeOut();
        }, 10000);
    }

    form.submit(function (e) {
        e.preventDefault();
        // check if Google recaptcha is solved
        if (!$('#g-recaptcha-response').val().trim().length) {
            alert("Please check reCaptcha")
            return false;
          }
        form_data = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: form_data
        })
        .done(done_func)
        .fail(fail_func);
    });

})(jQuery);

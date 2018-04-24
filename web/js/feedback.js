$(document).ready(function () {


    $('body').on("click", '#contacts-button', function (e) {
        e.preventDefault();
        var formData = new FormData($('#contacts-form')[0]);
        formData.append('type', 'contacts');
        if (validateForm('#contacts-form')) {
            $.ajax({
                contentType: false,
                cache: false,
                processData: false,
                type: "POST",
                url:"feedback/feedback/create",
                data: formData,
                success: function (result) {
                    $('#contacts-form').detach();
                    $('.contact-form').html(result);
                }
            });
    }
    });

    // $('body').on('change', '#contacts-form', function (e) {
    //     e.preventDefault();
    //     validateForm('#contacts-form');
    // });

    function validateForm(string) {
        var $form = $(string),
            data = $form.data("yiiActiveForm");
        $.each(data.attributes, function () {
            this.status = 3;
        });
        $form.yiiActiveForm("validate");

        if ($(string).find(".has-error").length) {
            return false;
        }
        return true;
    }

});
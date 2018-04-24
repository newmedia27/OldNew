$(document).ready(function () {

    $('.submit-comment').click(function (e) {
        e.preventDefault();
        saveComment();
    });


    function validateForm() {
        var $form = $("#write_message_form"),
            data = $form.data("yiiActiveForm");
        $.each(data.attributes, function () {
            this.status = 3;
        });
        $form.yiiActiveForm("validate");

        if ($("#write_message_form").find(".has-error").length) {
            return false;
        }

        return true;
    }


    function clearForm() {
        $('#write_message_form').trigger('reset');
    }

    function saveComment() {

        var formData = new FormData($('#write_message_form')[0]);
        if (validateForm()) {
            $.ajax({
                processData: false,
                contentType: false,
                url: '/comments/comments/create',
                type: 'POST',
                data: formData,
                success: function (res) {
                    clearForm();
                    $('#write_message_form').detach();
                    $('.write-comments').html(res);
                }
            });
        }
        return false;
    }


});
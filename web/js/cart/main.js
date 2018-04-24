$(document).ready(function () {

    $('body').on('click', '.to_cart', function (e) {
        e.preventDefault();
        var el = $(this);
        var count = $('#count_prods' + el.data('id')).val();
        $.ajax({
            url: '/cart/add',
            type: 'POST',
            data: {
                idProd: el.data('id'),
                count: count
            },
            success: function (res) {
                if (!res) {
                    alert('Error occurred.');
                    return false;
                }

                updateTotalCount(true);
                $('.orderSummary').html(res);
            },
        });
    });


    $('body').on('click', '.cart_del', function (e) {
        e.preventDefault();

        var el = $(this);
        $.ajax({
            url: '/cart/delete',
            type: 'POST',
            data: {
                idProd: el.data('id'),
                force: 0
            },
            success: function (res) {
                if (!res) {
                    alert('Error occurred.');
                    return false;
                }

                updateTotalCount(false);
                $('.orderSummary').html(res);
            },
        });
    });

    $('body').on('click', '.del', function (e) {
        e.preventDefault();

        var el = $(this);

        $.ajax({
            url: '/cart/delete',
            type: 'POST',
            data: {
                idProd: el.data('id'),
                type: el.data('type'),
                force: 1
            },
            success: function (res) {
                if (!res) {
                    location.reload();
                    return false;
                }

                updateTotalCount(false);
                $('.orderSummary').html(res);
            },
        });
    });


    $('body').on("click", '.save-order-button', function (e) {
        e.preventDefault();

        var formData = new FormData($('#form-address')[0]);
        $.ajax({
            contentType: false,
            cache: false,
            processData: false,
            url: "/cart/cart/checkouts",
            type: "POST",
            data: formData,
            success: function (res) {
                $('.container-big').html(res);
            }
        });
    });

    $('#orderform-payment_type label').click(function() {
        $('.payment-select').removeClass('error');
    });

    $('.form-control').click(function() {
        $('.shipping').removeClass('error');
    });

    $('body').on('click', '#submit-order-button', function (e) {
        e.preventDefault();

        var data = $(".check-filter input:checked").val();

        if (data == undefined) {
            var _scrollTop = $('.payment-select').offset().top;
            $('html, body').animate({scrollTop: _scrollTop - 50}, 300);
            $('.payment-select').addClass('error');
        } else {
            var form = new FormData($('#form-address')[0]);

            $.ajax({
                url: '/cart/cart/checkouts',
                processData: false,
                contentType: false,
                type: 'POST',
                data: form,
                success: function (res) {
                    var _scrollTop2 = $('.shipping').offset().top;
                    $('html, body').animate({scrollTop: _scrollTop2 - 50}, 300);
                    $('.shipping').addClass('error');
                }
            });
        }
    });

    $('body').on('click', '.repeat', function (e) {
        e.preventDefault();

        var el = $(this);
        $.ajax({
            url: '/cart/cart/repeat',
            type: 'POST',
            data: {
                id: el.data('id')
            },
            success: function (res) {
                updateTotalCount(false);
            }
        });
    });

    $('body').on('click', '.cancel', function (e) {
        e.preventDefault();

        var el = $(this);
        $.ajax({
            url: '/cart/cart/cancel',
            type: 'POST',
            data: {
                id: el.data('id')
            },
            success: function (res) {
                updateTotalCount(false);
            }
        });
    });

    function updateTotalCount() {
        var totalCount = $.ajax({
            async: false,
            url: '/getProdCount',
            type: 'POST',
            data: {},
            dataType: "TEXT"
        }).responseText;

        $('.cart_count-number').html(totalCount);
    }
});
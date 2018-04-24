$(function() {

    initSelect();

    $(window).resize(function() {
        initSelect();
    });

    var minval = parseInt($('#hidden-min').val());
    var maxval = parseInt($('#maxPrice').val());
    var step = maxval / 20;

    $(".slider")
        .slider({
            min: minval,
            max: maxval,
            range: true,
            values: [ minval , maxval ],
            stop: function( event, ui ) {
                SearchCat.ajax('slider', ui);  
            }
        })
        .slider("pips", {
            rest: "false",
            step: step
        })
        .slider("float");
    /* drag on mobile, tablet devices */
    $('.slider').draggable();

    $('.filter-radio input').click(function() {
        var $this = $(this);
        if ($this.hasClass('checked')) {
            this.checked = false;
            $this.removeClass('checked');
            SearchCat.ajax('fields', false);
        } else {
            $('.filter-radio input').removeClass('checked');
            $this.addClass('checked');
        }
    });

    $('.cf-head').click(function() {
        $(this).closest('ul').find('li').toggleClass('active');
    });

    $(".selectize-input input").attr('readonly','readonly');

    $('.sort-kind a').click(function(e) {
        var dataSort = $(this).attr('data-sort');
        e.preventDefault();
        if (dataSort === 'pi-lines') {
            $('.pi-wrap').removeClass('pi-blocks').addClass('pi-lines');
        } else {
            $('.pi-wrap').removeClass('pi-lines').addClass('pi-blocks');
        }
        $('.sort-kind a').removeClass('active');
        $(this).addClass('active');
    });

    $('.subcat-filter h4').click(function() {
       if ($(window).width()<768) {
           $('.filter-self').toggleClass('active');
       }
    });
    $('#main_carousel').owlCarousel({
       items: 1,
       loop: true,
       nav: true,
       autoplay: true,
       smartSpeed: 800,
       navText: ['<span>Предыдущий</span>', '<span>Следующий</span>']
   });

    $('.popup-basket').magnificPopup({
        type: 'inline'
    });
    $(document).on('click', '.popup-modal-dismiss', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
    });

    $('.blog-category a').click(function() {
        if (!$(this).hasClass('active')) {
            $(this).addClass('active');
        }
    });
    $('.blog-category a span').click(function(e) {
        e.stopPropagation();
       $(this).closest('a').removeClass('active');
    });
});

var selectizedInit = false;

function initSelect() {
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        $('.cat-filter-wrap').addClass('mobile-device');
        console.log();
        if (selectizedInit === true) {
            $('.selectized').each(function() {
                $(this)[0].selectize.destroy();
            });
            selectizedInit = false;
        }
    } else {
        $('.cat-filter-wrap').removeClass('mobile-device');
        if (selectizedInit === false) {
            $('.filter-select').selectize();
            selectizedInit = true;
        }
    }
}

function checkDot(el, e) {
    if ((e.charCode >= 48 && e.charCode <= 57 || e.charCode == 0) || (e.charCode == 46 && el.value.indexOf('.') == -1) ) {
        if (el.dataset.type) changeValue(el, 'checkDot');
        return true;
    } else {
        return false;
    }
}

var lockSend = null;

function changeValue($this, instance) {

    var e, eInput, eClass;
    if (instance == 'checkDot') {
        eInput = e = $($this);
        eClass = '';
    } else {
        e = $($this);
        eInput = e.siblings('input');
        eClass = e.attr('class');
        var step = $this.dataset.step;
    }

    switch (eClass) {
        case 'minus':
            if (+eInput.val() <= step) {
                return;
            }
            else {
                if (step !== '1') {
                    eInput.val( (+eInput.val() - +step).toFixed(1) );
                } else {
                    eInput.val( (+eInput.val() - +step) );
                }
            }

            break;
        case 'plus':

            if (step !== '1') {
                eInput.val( (+eInput.val() + +step).toFixed(1)  );
            } else {
                eInput.val( (+eInput.val() + +step));
            }

            break;
        default:
            break;
    }

    if (instance === true || instance == 'checkDot' ) {
        clearTimeout(lockSend);
        lockSend = setTimeout(function () {
            $.ajax({
                url: "/cart/cart/touch",
                type: "POST",
                data: {
                    idProd: e.data('id'),
                    type: e.data('type'),
                    quantity: eInput.val()
                    // step: step
                },
                success: function (result) {
                    updateTotalCount(true);
                    $('.orderSummary').html(result);
                }
            });
        }, 500);
    }
}

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

function clean() {

    $.ajax({
        url: "/cart/cart/clean",
        success: function (res) {
            if (!res) {
                alert('Error occurred.');
                return false;
            }

            updateTotalCount(true);
            $('.orderSummary').html(res);
        }
    });

}

function detOrder($this, e) {
    var eThis = $($this);
    e.preventDefault();
    if (eThis.attr('data-hidden') === '0') {
        eThis.attr('data-hidden', 1);
        eThis.text('подробнее');
        eThis.closest('.his-table').find('.his-body').removeClass('active');
    } else {
        eThis.attr('data-hidden', 0);
        eThis.text('скрыть');
        eThis.closest('.his-table').find('.his-body').addClass('active');
    }
}

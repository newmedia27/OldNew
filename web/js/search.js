var SearchCat = {

    ajax: function (kind, ui) {
        var sort = $("#select-sorting option:selected").val();
        var pageFrom = window.location.href.split('?page=')[1];
        var filters = {};
        var url;
        var price;

        $('#form-filter div.filter-refresh_attr').each(function () {

            var box = $(this).find(".filter-self");

            var attr = $(box).attr("data-attr");

            switch ($(box).attr("data-id")) {
                case 'radio':
                    if ($(box).find(".filter-radio input:checked").val() != undefined) {
                        filters[attr] = $(box).find(".filter-radio input:checked").val();
                    }
                    break;
                case 'select':
                    if ($(box).find(".filter-select option:selected").val() != "") {
                        filters[attr] = $(box).find(".filter-select option:selected").val();
                    }
                    break;
                case 'checkbox':

                    var filter = [];
                    $($(this).find('.filter-checkbox')).each(function(){
                        var arr = {};
                        if (($(this).find("input:checked").val())!= undefined) {
                            filter.push($(this).find("input:checked").val());
                        }
                        filters[attr] = filter ;
                    });
                    break;
                default:
                    break;
            }

        });

        url = window.location.href;
        // if (window.location.href.indexOf('page') > 0) {
        //     url = window.location.href.split('?page=')[0] + '?page=' + page ;
        // } else {
        //     url = window.location.href.split('?')[0] + '?page=' + page;
        // }

        if (kind == 'fields') {
            price = $('.slider').slider('values');
        } else if (kind == 'slider') {
            price = ui.values;
        } else {
            alert("Watch search.js");
        }

        $.ajax({
            type: "POST",
            url: url,
            data: {
                price_from: price[0],
                price_to: price[1],
                filters: filters,
                pageFrom: pageFrom,
                sort: sort
            },
            success: function (result) {
                $('.product-items').html(result);

                // $('.pagination-block').html(pager);
                // $('.pager-active').next().attr('class', 'pager-active');
                // $('.pager-active').first().attr('class', '');
            }
        });
    }
};

$(function () {

    $('body').on("change", '.filter-refresh_ajax', function (e) {

        e.preventDefault();
        // alert();
        SearchCat.ajax('fields', false);

    });

});
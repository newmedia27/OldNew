$(function() {
    var $menu = $("#mobile_menu").mmenu({
        navbar: {
            title: ""
        },
        "extensions": [
            "pagedim-black",
            "border-none"
        ]
    });
    var $icon = $(".hamburger");
    var API = $menu.data("mmenu");

    $icon.on("click", function () {
        API.open();
    });

    API.bind("open:finish", function () {
        $icon.addClass("is-active");
    });
    API.bind("close:finish", function () {
        $icon.removeClass("is-active");
    });
});
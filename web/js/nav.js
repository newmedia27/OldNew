/**/
var myTimeout, myTimeout2;
var showMenu = true;

$(function() {
    $(document).click(function() {
        $('.third-level').removeClass('active');
        $('.submenu-wrap, .sort ul').removeClass('active active-third-level');
    });

    $(window).resize(function() {
       if ($(window).width() > 767 && showMenu === true) {
           $('.hover-submenu a, .third-level').removeClass('active');
           showMenu = false;
       } else if ($(window).width() < 768) {
           showMenu = true;
       }

    });

    $('.tl-head').click(function(e) {
        if ($(window).width()<768) {
            e.stopPropagation();
            $(this).closest('ul').find('li').toggleClass('active');
        }
    });

    $('.hover-submenu').click(function(e) {
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)&&$(window).width()>768) {
            e.preventDefault();
            e.stopPropagation();
            showSubmenu({elem: this});
        } else {
            return;
        }
    });

    $('.hover-submenu > a').click(function(e){
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)||$(window).width()<768) {
            var $this = $(this);
            e.preventDefault();
            e.stopPropagation();
            $('.hover-submenu a, .third-level').removeClass('active');
            $this.addClass('active').siblings('.third-level').addClass('active');
        }
    });

    $('.hover-submenu').hover(function() {
        if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)&&$(window).width()>767) {
            showSubmenu({elem: this});
        } else {
            return;
        }
    }, function() {
        if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)&&$(window).width()>767) {
            hideSubmenu();
        } else {
            return;
        }
    });

    $('.first-level-sub').hover(function() {
        $('.submenu-wrap').addClass('active');
    }, function() {
        $('.submenu-wrap').removeClass('active');
    });

});

function showSubmenu(parameters) {
    var elem = parameters.elem;
    var $this = elem;
    var showedElem = $($this).find('.third-level');
    var elemHeigth = showedElem.height();
    var menuWrap = $('.submenu-wrap');
    $('.third-level').removeClass('active');
    showedElem.addClass('active');
    menuWrap.addClass('active-third-level');
    menuWrap.height(elemHeigth);
    clearTimeout(myTimeout);
}

function hideSubmenu() {
    var menuWrap = $('.submenu-wrap');
    if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        myTimeout = setTimeout(function () {
            $('.third-level').removeClass('active');
            menuWrap.removeClass('active-third-level');
            menuWrap.css('height', 'auto');
        }, 200);
    } else {
        $('.third-level').removeClass('active');
        menuWrap.removeClass('active-third-level');
        menuWrap.css('height', 'auto');
    }
}

function openMenu(parameters) {
    var e = parameters.e;
    if (!$('.submenu-wrap').hasClass('active')) {
        e.preventDefault();
        e.stopPropagation();
        $('.submenu-wrap').addClass('active');
        console.log('asdasd')
    } else {
        return;
    }
}
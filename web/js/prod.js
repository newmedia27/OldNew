document.addEventListener('touchmove', function (event) {
    if (event.scale !== 1) { event.preventDefault(); }
}, false);

function setResizeble(parameters) {
    var $this = parameters.$this;
    if ($($this).hasClass('resizeble')) {
        return;
    } else {
        autosize(comment_text);
        $($this).addClass('resizeble');
    }
}

function scrollToReviews(e) {
    var offsetTop = $('.comments-self').offset().top;
    e.preventDefault();
    $('html, body').animate({scrollTop: offsetTop - 40}, 300)
}

function setXsOwlCar(winWidth) {

    var $ddNav = $('.dd-nav');
    var $ddBody = $('.dd-body');
    var eHasClass = $ddNav.hasClass('owl-carousel');
    if (winWidth >= 768 && eHasClass===true) {
        $ddNav.owlCarousel().trigger('destroy.owl.carousel');
        $ddBody.owlCarousel().trigger('destroy.owl.carousel');
        $ddNav.removeClass('owl-carousel');
        $ddBody.removeClass('owl-carousel');
    } else if (winWidth < 768 && eHasClass===false) {
        $ddNav.addClass('owl-carousel').owlCarousel({
            items: 1,
            center: true,
            loop: true,
            autoWidth: true,
            nav: false,
            margin: 40,
            onTranslated: function(e) {
                var index = $(e.currentTarget).find('.center a').attr('data-desc').slice(-1)-1;
                $('.dd-body').find('.owl-dot').eq(index).click();
            }
        });
        $ddBody.addClass('owl-carousel').owlCarousel({
            items: 1,
            mouseDrag: false,
            touchDrag: false,
            pullDrag: false,
            nav: false,
            dots: true,
            animateOut: 'fadeOut',
            smartSpeed: 0
        });
        $('.gallery-xs').owlCarousel({
            loop: true,
            items: 1
        });
    } else {
        return;
    }
}

function ddNavClick($this) {
    var $this = $($this);
    if ($(window).width() > 767) {
        var target = "." + $this.attr('data-desc');
        $('.dd-nav a, .dd-item').removeClass('active');
        $this.addClass('active');
        $(target).addClass('active');
    } else {
        if (!$this.parent().hasClass('center')) {
            if ($this.parent().nextAll().hasClass('center')) {
                $('.dd-nav').owlCarousel().trigger('prev.owl.carousel');
            } else {
                $('.dd-nav').owlCarousel().trigger('next.owl.carousel');
            }
        }
    }
}

$(function() {
    // $('.product-carousel').owlCarousel({
    //     items: 4,
    //     margin: 30,
    //     loop: true,
    //     nav: true,
    //     navText: ''
    // });

    setXsOwlCar($(window).width());

    $(window).resize(function() {
        setXsOwlCar($(this).width());
    });

    if ($('.product-carousel').find('.item').length>4 && $(window).width()>992 || $('.product-carousel').find('.item').length>3 && $(window).width()>767 && $(window).width()<993 || $('.product-carousel').find('.item').length>1 && $(window).width()<768) {
        $('.product-carousel').removeClass('owl-disabled').addClass('owl-carousel').owlCarousel({
            items: 4,
            responsive: true,
            loop: true,
            nav: true,
            navText: '',
            responsive: {
                320: {
                    items: 1
                },
                440: {
                    items: 2,
                    margin: 30
                },
                768: {
                    items: 3,
                    margin: 30
                },
                992: {
                    items: 4
                }
            }
        });
    }

    $('.popup-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
        },
        image: {
            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
        }
    });

});
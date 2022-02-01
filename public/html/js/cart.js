$(function() {
    $('#checkout-accordion').on('shown.bs.collapse', function (event) {
        let target = event.target
        

        $('html, body').animate({
            scrollTop: $(target).offset().top - $('.header-box').outerHeight() * 2
        }, 300)
    });


    $('.cart-control-confirm ').on('click', function() {
        smoothScroll('.section-checkout', 20);
    });
})
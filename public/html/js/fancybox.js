$(function () {
    $('[data-fancybox]:not([data-fancybox="product-media"])').fancybox({
        loop: true,
        keyboard: true,
        backFocus: false,
        buttons: [
            "close"
        ],
    });
})
function smoothScroll(element, offset) {
    let target = element;
    offset = Number.isInteger(offset) ? offset : 0;

    $('html, body').animate({
        scrollTop: $(target).offset().top - $('.header-box').outerHeight() - offset
    }, 300);
}
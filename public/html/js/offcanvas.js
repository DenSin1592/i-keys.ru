$(function () {
    let offcanvasContainer = $('#offcanvas');
    let offcanvasCloseButton = offcanvasContainer.find('.offcanvas-close');
    let offcanvasOpenButton = $('.header-burger-toggle');

    function openOffcanvas() {
        offcanvasContainer.addClass('open');
        offcanvasContainer.addClass('transition');
    }

    function closeOffcanvas() {
        offcanvasContainer.removeClass('open');
    }

    $(offcanvasOpenButton).on('click', openOffcanvas);
    $(offcanvasCloseButton).on('click', closeOffcanvas);
})

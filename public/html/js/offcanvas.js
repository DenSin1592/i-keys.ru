$(function () {
    let offcanvasContainer = $('#offcanvas');
    let offcanvasCloseButton = offcanvasContainer.find('.offcanvas-close');
    let offcanvasOpenButton = $('.header-burger-toggle');

    function openOffcanvas() {
        offcanvasContainer.addClass('open');
        offcanvasContainer.addClass('transition');
        appendBackdrop();
    }

    function closeOffcanvas() {
        offcanvasContainer.removeClass('open');
        removeBackdrop();
    }

    $(offcanvasOpenButton).on('click', openOffcanvas);
    $(offcanvasCloseButton).on('click', closeOffcanvas);

    $(document).on('click', '.backdrop', closeOffcanvas);

    beforeWindowWidthResizeFunctions.push(function () {
        if (windowSizeHelper.isMobileToDesktopResize()) {
            closeOffcanvas();
        }
    });


    /* offcanvas dropdown catalog */
    $('.offcanvas-catalog-megamenu-toggle').on('click', function(e) {
        let target = $(e.currentTarget);

        target.toggleClass('active');
        target.next().slideToggle();
    });
})

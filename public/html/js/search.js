let headerSearchToggle = $('.header-search-toggle');
let offcanvasSearchInput = $('.offcanvas-search-input');

function focusOffcanvasSearch() {
    $(offcanvasSearchInput).focus();
}

$(function () {
    $(headerSearchToggle).on('click', function() {
        openOffcanvas();

        setTimeout(focusOffcanvasSearch, 400);
    });
})

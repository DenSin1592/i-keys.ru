let initSelect2 = function () {
    $('.custom-select').select2({
        minimumResultsForSearch: Infinity
    });

    $('.custom-select-inline').select2({
        width: 'auto',
        selectionCssClass: 'select2-selection-inline',
        dropdownAutoWidth: true,
        minimumResultsForSearch: Infinity,
        // dropdownCssClass: 'select2-dropdown-inline'
    });
}

let customNumberButtonInit = function () {

    $(".custom-number .custom-number-button").off("click");
    $(".custom-number .custom-number-button").on("click", function (e) {
        let target = $(e.currentTarget);
        let container = target.closest('.custom-number');
        let input = container.find("input");
        let oldValue = parseFloat(input.val());
        let newValue;

        if (target.hasClass('custom-number-increase')) {
            newValue = oldValue + 1;
        } else {
            newValue = oldValue - 1;
        }
        input.val(newValue);
        input.trigger('change');
    });

    $(".custom-number .custom-number-input").off('change');
    $(".custom-number .custom-number-input").on('change', function (e) {
        let input = $(e.currentTarget);
        let inputMinValue = input.data('minValue') ?? 1;
        let oldValue = parseFloat(input.val());
        let newValue;

        newValue = oldValue < inputMinValue ? inputMinValue : oldValue;
        input.val(newValue);
    });
}


document.addEventListener('DOMContentLoaded', function () {

    initSelect2();
    customNumberButtonInit();


    $('.form-option').on('click', function (e) {
        let target = $(e.currentTarget);
        let container = target.closest('.form-options-group');
        let children = container.find('.form-option');

        children.removeClass('active');
        target.addClass('active');
    });
});

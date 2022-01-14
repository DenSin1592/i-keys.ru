let initSelect2 = function () {
    $('.custom-select').select2({
        minimumResultsForSearch: Infinity
    });

    $('.custom-select-inline').select2({
        width: 'auto',
        selectionCssClass: 'select2-selection-inline',
        dropdownAutoWidth: true,
        minimumResultsForSearch: Infinity,
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
        let oldValue = (!isNaN(parseFloat(input.val())) && isFinite(input.val())) ? parseFloat(input.val()) : inputMinValue;

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
        const notActiveInputs = children.parent().find('.form-option:not(.active) .form-control');

        children.removeClass('active');
        target.addClass('active');
        target.find('input[type="radio"]').attr('checked', 'checked'); // фиксит выбор радио при клике на вложенный инпут

        notActiveInputs.prop('disabled', true); // в шаблоне кнопки внутри радиогруппы отключены. Защита от ложных данных
        if (target.hasClass('active')) {
            target.find('.form-control').prop('disabled', false);
        }
        // use required into selection group
        children
            .find('[required]:not([type="radio"])')
            .removeAttr('required')
            .attr('data-option-required', true);
        target
            .find('[data-option-required]')
            .removeAttr('data-option-required')
            .attr('required', true)
        ;
    });
});

let initSelect2 = function () {
    $('.custom-select').select2({
        minimumResultsForSearch: Infinity
    });
}

let customNumberButtonInit = function () {

    $(".custom-number .custom-number-button").on("click", function (e) {
        let target = $(e.currentTarget);
        let container = target.closest('.custom-number');
        let input = container.find("input");
        let oldValue = parseFloat(input.val());
        let newValue;

        if (target.hasClass('custom-number-increase')) {
            newValue = oldValue + 1;
        } else {
            if (oldValue > 1) {
                newValue = oldValue - 1;
            } else {
                newValue = 1;
            }
        }
        input.val(newValue);
        input.trigger('change');
    });


    $(".custom-number .custom-number-input").on("change", function (e) {
        let input = $(e.currentTarget);
        let newValue = parseFloat(input.val());
        newValue = newValue <= 0 ? 1 : newValue;
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

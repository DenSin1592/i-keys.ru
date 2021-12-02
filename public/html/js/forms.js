let initSelect2 = function (){
    $('.custom-select').select2({
        minimumResultsForSearch: Infinity
    });
}

let customNumberButtonInit = function (){
    $(".custom-number .custom-number-button").on("click", function(e) {
        let target = $(e.currentTarget),
            container = target.closest('.custom-number'),
            input = container.find("input"),
            oldValue = parseFloat(input.val()),
            newValue = undefined;

        if (target.hasClass('custom-number-increase')) {
            newValue = oldValue + 1;
        } else {
            if (oldValue > 0) {
                newValue = oldValue - 1;
            } else {
                newValue = 0;
            }
        }
        newValue = newValue <= 0 ? 1 : newValue;

        input.val(newValue);
    });
}

document.addEventListener('DomContentLoaded', function (){

    initSelect2();
    customNumberButtonInit();


    // custom options
    $('.form-option').on('click', function(e) {
        let target = $(e.currentTarget);
        let container = target.closest('.form-options-group');
        let children = container.find('.form-option');

        children.removeClass('active');
        target.addClass('active');
    });

});

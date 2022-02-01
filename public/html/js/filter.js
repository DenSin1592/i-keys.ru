let initFilterRangeSlider = function () {

    $('.filter-range-slider').each(function () {
        let slider, fromInput, toInput, min, max, fromValue, toValue, changeInput, decimals, sliderStep, i;

        slider = $(this);
        fromInput = $(slider.data('from'));
        toInput = $(slider.data('to'));
        min = parseFloat(fromInput.data('border'));
        max = parseFloat(toInput.data('border'));
        fromValue = parseFloat(fromInput.val());
        toValue = parseFloat(toInput.val());
        decimals = slider.data('decimals');
        sliderStep = 1;
        for (i = 0; i < decimals; i += 1) {
            sliderStep = sliderStep / 10;
        }

        slider.slider({
            range: true,
            animate: true,
            min: min,
            max: max,
            step: sliderStep,
            values: [fromValue, toValue],
            disabled: (slider.attr('disabled') === 'disabled'),
            slide: function (event, ui) {
                fromInput.val(ui.values[0].toFixed(decimals));
                toInput.val(ui.values[1].toFixed(decimals));
            },
            stop: function (event, ui) {
                fromInput.trigger('change');
            }
        });



        changeInput = function () {
            let fromVal, toVal, fromValSlider, toValSlider;
            fromVal = parseFloat(fromInput.val());
            toVal = parseFloat(toInput.val());
            fromValSlider = parseFloat(slider.slider('values', 0));
            toValSlider = parseFloat(slider.slider('values', 1));

            if (isNaN(fromVal)) {
                fromVal = fromValSlider;
            }
            if (fromVal < min) {
                fromVal = min;
            } else if (fromVal > max) {
                fromVal = max;
            }

            if (isNaN(toVal)) {
                toVal = toValSlider;
            }
            if (toVal > max) {
                toVal = max;
            } else if (toVal < min) {
                toVal = min;
            }

            if (fromVal > toVal) {
                fromVal = toVal;
            }

            fromInput.val(fromVal);
            toInput.val(toVal);

            slider.slider('values', 0, fromVal);
            slider.slider('values', 1, toVal);
        };

        fromInput.change(changeInput);
        fromInput.focusin(function () {
            if (windowSizeHelper.isMobile()) {
                fromInput.val('');
            }
        });
        fromInput.focusout(function () {
            if (windowSizeHelper.isMobile()) {
                changeInput();
            }
        });

        toInput.change(changeInput);
        toInput.focusin(function () {
            if (windowSizeHelper.isMobile()) {
                toInput.val('');
            }
        });
        toInput.focusout(function () {
            if (windowSizeHelper.isMobile()) {
                changeInput();
            }
        });
    });
}


let filterToggle = $('.filter-toggle'),
    filterContainer = $('#filter');

function setFilterPosition() {
    let yOffset = $('.header-box').outerHeight() * 1.25;
    let y = filterToggle[0].getBoundingClientRect().top + window.pageYOffset - yOffset;

    $('html, body').animate({
        scrollTop: y,
    }, 300)
}

function openFilter() {
    $('body').addClass('filter-open');
    filterContainer.slideDown();
    setFilterPosition();
    appendBackdrop();
}

function closeFilter() {
    $('body').removeClass('filter-open');
    filterToggle.removeClass('active');
    filterContainer.slideUp();
    setFilterPosition();
    removeBackdrop();
}

let initFilterToggle = function (){
    $('.filter-toggle').on('click', function(e) {
        let target = $(e.currentTarget);
        $(target).toggleClass('active');
        if(target.hasClass('active')) {
            openFilter();
        }
        if(!target.hasClass('active')) {
            closeFilter();
        }
    });
}


document.addEventListener('DOMContentLoaded', function (){
    initFilterToggle();
})


document.addEventListener('DOMContentLoaded', function (){
    $(document).on('click', '.backdrop', closeFilter);
    beforeWindowWidthResizeFunctions.push(function () {
        if (windowSizeHelper.isMobileToDesktopResize()) {
            closeFilter();
        }
    });
})

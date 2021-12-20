document.addEventListener("DOMContentLoaded", function(event) {
    window.initClientPhoneMask = function() {
        $('[data-client-phone-mask]').inputmask('+7 (099) 999-99-99', {
            clearMaskOnLostFocus: true,
            definitions: {
                '0': {
                    validator: "[012345679]"
                }
            },
            lazy: false,
            min: 11,
            placeholderChar: ' '
        });
    };

    initClientPhoneMask();
});

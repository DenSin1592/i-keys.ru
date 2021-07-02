(function ($) {
    $(function () {

        window.datetimepickerInit = function () {
            $('[data-datetimepicker]').each(function () {
                var options = {
                    lang: 'ru',
                    dayOfWeekStart: 1,
                    format: 'd.m.Y H:i:s',
                    scrollInput: false
                };

                $(this).datetimepicker(jQuery.extend(options, $(this).data('datetimepicker')))
            });
        };

        datetimepickerInit();
    });
})(jQuery);

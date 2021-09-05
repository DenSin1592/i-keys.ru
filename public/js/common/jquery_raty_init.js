(function ($) {
    $(function () {

        window.jqueryRatyInit = function () {
            $('[data-raty]').each(function () {
                var defaultOptions = {
                    hints        : ['плохо', 'неважно', 'нормально', 'хорошо', 'отлично'],
                    starHalf     : '/images/common/stars-raty/small/star-half.png',
                    starOff      : '/images/common/stars-raty/small/star-off.png',
                    starOn       : '/images/common/stars-raty/small/star-on.png',
                    starType     : 'img',
                    noRatedMsg   : 'Еще не оценено'
                };

                $(this).raty($.extend(defaultOptions, $(this).data('raty')));
            });
        };

        jqueryRatyInit();
    });
})(jQuery);

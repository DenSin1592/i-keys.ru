(function ($) {
    $(function () {
        // Fix width for action bar (with "save" and other buttons)
        (function () {
            $(document).on('action-bar.resize', function () {
                $('.action-bar').outerWidth($('.main-content').outerWidth());
            });

            $(document).trigger('action-bar.resize');
        })();

    });
})(jQuery);

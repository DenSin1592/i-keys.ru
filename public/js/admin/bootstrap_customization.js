(function ($) {
    $(function () {
        /**
         * Add search functionality for select inputs within container.
         * @param container
         */
        window.initSearchSelect = function (container) {
            $(container).find('select[data-with-search]:visible').select2({
                theme: "bootstrap",
                language: "ru"
            });
        };

        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
            initSearchSelect(document);
        });
    });
})(jQuery);

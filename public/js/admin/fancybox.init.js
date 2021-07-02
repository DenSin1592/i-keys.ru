(function ($, window) {
    $(function () {
        window.fancyboxInit = function (block) {
            if (typeof block == 'undefined') {
                block = $(document);
            }
            block.find('[data-fancybox]').fancybox({
                loop: true,
                buttons: [
                    "fullScreen",
                    "zoom",
                    "close"
                ],
                idleTime: false,
                clickContent: function (current, event) {
                    return current.type === "image" ? "zoom" : false;
                }
            });
        };

        fancyboxInit();
    });
})(jQuery, window);
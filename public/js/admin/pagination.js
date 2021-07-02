(function ($) {
    $(document).on('change', '#switch-pagination-limit', function () {
        window.location.href = this.value;
    });
})(jQuery);
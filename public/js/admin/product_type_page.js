(function ($) {
    $(document).on('change', '[data-change-product-list-way]', function () {
        var currentWay;

        currentWay = $(this).data('changeProductListWay');

        $('.products-way-container').removeClass('active');
        $(currentWay).addClass('active');
    });

    $(document).on('keyup', '#filter_query', function () {
        var input, currentValue, oldValue, hint;

        input = $(this);
        hint = $('#filtered-products-update-hint');

        currentValue = input.val();
        oldValue = input.data('oldValue');

        if (currentValue == oldValue) {
            hint.removeClass('visible');
        } else {
            hint.addClass('visible');
        }
    });

    $(document).on('click', '#filtered-products-update-hint a', function (e) {
        var productContainer, filterInput, hint, value;

        filterInput = $('#filter_query');
        hint = $('#filtered-products-update-hint');
        productContainer = $('#filtered-products-container');
        productContainer.html('<span class="glyphicon glyphicon-refresh"></span>');
        value = filterInput.val();

        $.ajax({
            cache: false,
            url: this.href,
            data: {filter_query: value}
        }).then(function (result) {
            productContainer.html(result);
            hint.removeClass('visible');
            filterInput.data('oldValue', value);
        });

        e.preventDefault();
    });

    $('#products-way-filtered .show-filter-products').click(function () {
        var self = $(this);
        self.parents('#products-way-filtered').find('#filtered-products-update-hint a').click();
        self.removeClass('show-filter-products');
    });

    $(document).on('click',
        '#filtered-products-container .product-type-page-products .product-name,' +
        '.product-type-page-products .product-manual > [type="checkbox"]:checked + .product-name',
        function () {
            var toggle, loadAssociationUrl, associationContainer;

            toggle = $(this);
            loadAssociationUrl = toggle.data('productAssociationUrl');
            associationContainer = toggle.next();

            if (associationContainer.length === 0) {
                if (toggle.data('wait') != 1) {
                    toggle.data('wait', 1);
                    $.ajax({
                        cache: false,
                        url: loadAssociationUrl
                    }).then(function (result) {
                        associationContainer = $(result);
                        associationContainer.insertAfter(toggle);
                        toggle.data('wait', 0);
                    });
                }
            } else {
                associationContainer.toggleClass('opened');
            }
        });
})(jQuery);
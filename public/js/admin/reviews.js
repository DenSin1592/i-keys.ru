(function ($, window) {
    $(document).ready(function () {
        var reviewProducts = $('form#review_form [data-review-products-search-url]');
        var productLinks = $('form#review_form #product_links');
        var editLink = productLinks.find('a[data-edit-link]');
        var siteLink = productLinks.find('a[data-site-link]');
        var editLinkInitialHref = editLink.attr('href');
        var siteLinkInitialHref = siteLink.attr('href');

        if (reviewProducts.length > 0) {
            var setProductLinks = function (edit_link, site_link) {
                editLink.attr('href', edit_link);
                siteLink.attr('href', site_link);
                if (site_link == '#') {
                    siteLink.hide();
                } else {
                    siteLink.show();
                }
            };

            var reviewProductsSearchUrl = reviewProducts.data('reviewProductsSearchUrl');
            reviewProducts.select2({
                theme: "bootstrap",
                language: "ru",
                ajax: {
                    url: reviewProductsSearchUrl,
                    dataType: 'json',
                    delay: 1500,
                    data: function (params) {
                        var query = {
                            search: params.term,
                            page: params.page || 1
                        };

                        // Query parameters will be ?search=[term]&page=[page]
                        return query;
                    }
                },
                templateSelection: function (repo) {
                    if (typeof repo.edit_link == 'undefined' && typeof repo.site_link == 'undefined') {
                        setProductLinks(editLinkInitialHref, siteLinkInitialHref);
                    } else {
                        productLinks.css('display', 'inline-block');
                        setProductLinks(repo.edit_link, repo.site_link);
                    }
                    return repo.text;
                },
                placeholder: 'Выберите товар',
                minimumInputLength: 10
            });
        }
    });
})(jQuery, window);

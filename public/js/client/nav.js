$(document).ready(function () {
// добавление класса active в выпадающем меню категорий
    (function() {
        var locationPathname = window.location.pathname.replace(/\/page-\d+$/, '');
        var locationSearch = window.location.search.replace(/&additional=\w*$/, '').replace(/(\?|&)sort=\w*$/, '');
        var currentUrl = decodeURIComponent(locationPathname + locationSearch);

        $('.megamenu-list li a').each(function () {
            var href = $(this).attr('href');

            if (typeof href != 'undefined' && href != '') {
                href = href.replace(/(\?|&)sort=\w*$/, '');
                if (href == currentUrl) {
                    $(this).parents('li').eq(0).addClass('active');
                }
            }
        });
    })();
});

document.addEventListener('DOMContentLoaded', function () {


    const URL_REFRESH_SIZE_CYLINDER = '/change-product-page-when-changing-size-cylinder';
    const URL_REFRESH_COLOR = '/change-product-page-when-changing-color';


    $(document).on('change', 'select.change-product-page-size-cylinder-first, select.change-product-page-size-cylinder-second', (e) => {
        try {
            e.preventDefault();

            let selectFirstSizeSelect = $('select.change-product-page-size-cylinder-first');
            let selectSecondSizeSelect = $('select.change-product-page-size-cylinder-second');
            let productId = selectFirstSizeSelect.closest('[data-product-id]').data('product-id');
            let selectedSelectNumber = $(e.currentTarget).hasClass('change-product-page-size-cylinder-first') ? 1 : 2;

            let data = {
                productId: productId,
                firstSize: selectFirstSizeSelect.val(),
                secondSize: selectSecondSizeSelect.val(),
                selectedSelectNumber: selectedSelectNumber,
            };

            changeContent(data, URL_REFRESH_SIZE_CYLINDER);

        } catch (error) {
            document.modalMessageErrorShow();
            console.warn('change_product_page_when_changing_size_cylinder.js: ', error)
        }
    });


    $(document).on('change', 'input.reset-card', (e) => {
        try {
            e.preventDefault();
            let input = $(e.currentTarget);
            let productId = parseInt(input.data('product-id'));

            let data = {
                productId: productId,
            };

            changeContent(data, URL_REFRESH_COLOR);

        } catch (error) {
            document.modalMessageErrorShow();
            console.warn('change_product_page_when_changing_size_cylinder.js: ', error)
        }
    });


    let changeContent = (data, url) => {
         $.ajax({
            method: 'POST',
            url: url,
            data: data,
            cache: false
        }).done((response) => {
            $('main').replaceWith(response['content']);
            $('#modalAddKeys').replaceWith(response['modal_add_keys']);
            history.pushState({}, '', response['new_url']);
            initSelect2();
            customNumberButtonInit();
            showOrHideLabelAdditionalKeys();
            document.initChangeCountAdditionalKeys();
            document.swiperProductsInit();
        }).fail(() => {
            document.modalMessageErrorShow();
        });
    };


    addEventListener('popstate', (event) => {
        window.location.reload();
    });


});

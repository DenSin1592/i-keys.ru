document.addEventListener('DOMContentLoaded', function () {

    const URL_REFRESH = '/change-product-page-when-changing-size-cylinder'

    $(document).on('change', 'select.change-product-page-size-cylinder-first, select.change-product-page-size-cylinder-second', (e) => {
        try{
            e.preventDefault();

            let selectFirstSizeSelect = $('select.change-product-page-size-cylinder-first');
            let selectSecondSizeSelect  = $('select.change-product-page-size-cylinder-second');
            let productId = selectFirstSizeSelect.closest('[data-product-id]').data('product-id');
            let selectedSelectNumber = $(e.currentTarget).hasClass('change-product-page-size-cylinder-first') ? 1 : 2;

            let data = {
                productId: productId,
                firstSize: selectFirstSizeSelect.val(),
                secondSize: selectSecondSizeSelect.val(),
                selectedSelectNumber: selectedSelectNumber,
            };

            $.ajax({
                method: 'POST',
                url: URL_REFRESH,
                data: data,
                cache: false
            }).done((response) => {
                document.location.href = response;
            });
        }catch (error){
            document.modalMessageErrorShow();
            console.warn('change_product_page_when_changing_size_cylinder.js: ', error)
        }


    });
});

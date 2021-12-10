document.addEventListener('DOMContentLoaded', function () {

    const CART_UPDATE_URI = '/cart/update';


    $(document).on('change', ".custom-number .custom-number-input", (e) => {

        let input = $(e.currentTarget);
        let itemCard = input.closest('[data-cart-product-id]');
        let productId = itemCard.data('cartProductId')
        let count = parseFloat(input.val())

        let data = {
            productId: productId,
            count: count,
        };

        promiseQueue.add('change-cart', () => {
            let promise = $.ajax({
                method: 'PUT',
                url: CART_UPDATE_URI,
                data: data,
                cache: false
            }).done((response) => {
                itemCard.find('.card-order-total-container').replaceWith(response['itemSummaryContent']);
                document.updateCartIcon(response['cartItemCount']);
            }).fail(() => {
                document.modalMessageErrorShow();
            });

            promise.then(() => {
                document.updateCartSummary();
            })
        });
    });
});



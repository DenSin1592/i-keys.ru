document.addEventListener('DOMContentLoaded', function () {
    let modalCartRemove = $('#modalRemoveInCart')
    let countItemsInCart;


    $(document).on('click', 'button[data-cart-action="remove"]', function (e) {
        modalCartRemove.modal('show');
        modalCartRemove.data('productId', $(e.currentTarget).closest('[data-cart-product-id]').data('cartProductId'));
    });


    modalCartRemove.on('click', '[data-card-remove]', () => {
        const url = modalCartRemove.data('url');
        const productId = modalCartRemove.data('productId');
        let cartItem = $('[data-cart-product-id=' + productId + ']');

        let data = {
            productId: productId,
        };
        modalCartRemove.modal('hide');

        promiseQueue.add('change-cart', () => {
            let promise = $.ajax({
                method: 'DELETE',
                url: url,
                data: data,
                cache: false,
            }).done((response) => {
                cartItem.remove();
                document.updateCartIcon(response['countItemsInCart']);
                countItemsInCart = response['countItemsInCart'];
            }).fail(() => {
                document.modalMessageErrorShow();
            });

            promise.then(() => {
                if (countItemsInCart === 0) {
                    window.location.reload();
                } else {
                    document.updateCartSummary();
                }
            });
        })


    });
});




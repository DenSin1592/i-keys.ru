document.addEventListener('DOMContentLoaded', function () {

    const CART_ADD_URI = '/cart/add';

    $(document).on('click', 'button.event-add-to-cart', (e) => {
        let button = $(e.currentTarget);
        button.prop('disabled', true);
        button.addClass('loader');

        let productId = button.data('product-id');
        let data = {
            productId: productId,
        };
        document.modalMessage.modal('show');

        promiseQueue.add('change-cart', () => {
            $.ajax({
                method: 'POST',
                url: CART_ADD_URI,
                data: data,
                cache: false,
            }).done((response) => {
                button.replaceWith(response['button_in_cart']);
                document.modalMessageShow(response['modal_title'], response['modal_body']);
                customNumberButtonInit();
                document.updateCartIcon(response['cartItemCount']);
                }
            ).fail(() => {
                button.replaceWith('');
                document.modalMessageErrorShow();
                }
            )

        });
    });

});



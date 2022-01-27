document.addEventListener('DOMContentLoaded', function () {

    const CART_ADD_URI = '/cart/add';

    $(document).on('click', 'button.event-add-to-cart', (e) => {
        let button = $(e.currentTarget);
        button.prop('disabled', true);
        button.addClass('loader');

        let data = {
            productId: button.data('product-id'),
            pageInfo:  button.data('page-info'),
            countAdditionalKeys:  $('span.count-additional-keys').data('count') ?? 0,
        };

        promiseQueue.add('change-cart', () => {
            $.ajax({
                method: 'POST',
                url: CART_ADD_URI,
                data: data,
                cache: false,
            }).done((response) => {
                document.modalMessageShowNow(response['modal_title'], response['modal_body']);
                button.replaceWith(response['button_in_cart']);
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

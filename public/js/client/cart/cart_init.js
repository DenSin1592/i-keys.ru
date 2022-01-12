document.addEventListener('DOMContentLoaded', function () {


    const CART_UPDATE_SUMMARY_URI = '/cart/update-summary';


    document.updateCartIcon = (count) => {
        $('.cart-item-count').text(count);
    };


    document.updateCartSummary = () => {
        promiseQueue.add('cart-summary', () => {
            $.ajax({
                method: 'GET',
                url: CART_UPDATE_SUMMARY_URI,
                cache: false
            }).done((response) => {
                $('#summary-container').replaceWith(response);
            }).fail(() => {
                document.modalMessageErrorShow();
            });
        });
    };

    document.clearCart = () => {
        document.updateCartIcon(0);
        document.updateCartSummary();
        document.querySelectorAll('.order-list .order-item')
            .forEach(function (item) {
            item.remove();
        })
    }
});



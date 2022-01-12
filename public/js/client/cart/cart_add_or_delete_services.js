const CART_ADD_SERVICE_URI = '/cart/add-service';

if(document.location.pathname === '/cart'){

    document.addEventListener('DOMContentLoaded', function () {
        $('input.cart-add-keys-service-count').on('change', (e) => {
            setPriceAdditionalKeys();
        });

        $('.card-order-services-block input').on('change', (e) => {
            let input = $(e.currentTarget);
            let productId = input.closest('.order-item').data('cart-product-id');
            let serviceId = input.data('service-id');
            let count = parseInt(input.val() - (input.data('min-value') ?? 0));

            if(isNaN(count)){
                count = input.prop('checked') ? 1 : 0;
            }

            let data = {
                productId: productId,
                serviceId: serviceId,
                count: count,
            };

            promiseQueue.add('change-cart', () => {
                $.ajax({
                    method: 'POST',
                    url: CART_ADD_SERVICE_URI,
                    data: data,
                    cache: false,
                }).done((response) => {}
                ).fail(() => {
                    document.modalMessageErrorShow();
                    setTimeout(() => {document.location.reload();}, 1000)
                })
            });
        });

    });

    let setPriceAdditionalKeys = () => {
        $('input.cart-add-keys-service-count').each((_ , elem) => {
            let input = $(elem);
            let itemCard = input.closest('.order-item');
            let inputLabelPrice = itemCard.find('.cart-add-keys-service-price');

            if (inputLabelPrice.length > 0){
                inputLabelPrice.text( (input.val() - input.data('min-value')) * inputLabelPrice.data('price'));
            }
        });
    };

    setPriceAdditionalKeys();

}


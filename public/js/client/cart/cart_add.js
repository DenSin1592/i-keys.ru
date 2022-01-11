document.addEventListener('DOMContentLoaded', function () {

    const CART_ADD_URI = '/cart/add';

    $(document).on('click', 'button.event-add-to-cart', (e) => {
        let button = $(e.currentTarget);
        button.prop('disabled', true);
        button.addClass('loader');
        document.modalMessage.modal('show');

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




document.addEventListener('DOMContentLoaded', function () {

    let modal = $('#modalAddKeys')
    let labelAdditionalKeys = $('span.count-additional-keys');

    modal.on('click', '.change-count-additional-keys', (e) => {
        let count = modal.find('input#modalAddKeysQuantity').val()
        labelAdditionalKeys.text(' + ' + count);
        labelAdditionalKeys.data('count', count);
        showOrHideLabelAdditionalKeys();
    });

});

let showOrHideLabelAdditionalKeys = () => {
    let labelAdditionalKeys = $('span.count-additional-keys');
    if(!labelAdditionalKeys) return;
    if(labelAdditionalKeys.data('count') > 0){
        labelAdditionalKeys.show();
    } else {
        labelAdditionalKeys.hide();
    }
};

showOrHideLabelAdditionalKeys();

document.addEventListener('DOMContentLoaded', function () {
    let modalMessage = $('#modalMessage');

    $(document).on('click', 'button.event-add-to-cart', (e) => {
        let button = $(e.currentTarget);
        button.prop('disabled', true);
        button.addClass('loader');
        // button.html('');

        let productId = button.data('product-id');
        let url = modalMessage.data('url-cart-add');
        let data = {
            productId: productId,
        };
        modalMessage.modal('show');

        promiseQueue.add('change-cart', () => {
            $.ajax({
                method: 'POST',
                url: url,
                data: data,
                cache: false,
            }).done((response) => {
                button.replaceWith(response['button_in_cart']);
                modalMessage.find('h3').text(response['modal_title']);
                modalMessage.find('.modal-body').replaceWith(response['modal_body']);
                customNumberButtonInit();
                }
            ).fail(() => {
                button.replaceWith('');
                modalMessageErrorShow();
                }
            )

        });
    });

});



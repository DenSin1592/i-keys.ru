document.addEventListener('DOMContentLoaded', function (){

    let modalMessage = $('#modalMessage');
    let updateCartIcon = (count) => {
        $('.cart-item-count').text(count);
    };

    let modalQuickOrderContainer = $('#modalQuickOrder', document);
    let quickOrderForm = modalQuickOrderContainer.find('form#quick-order');


    if (quickOrderForm.length === 1) {

        modalQuickOrderContainer.on('click', '[data-type-submit]', function (e) {
            e.preventDefault();
            quickOrderForm.trigger('submit');
        });

        quickOrderForm.submit(function (e) {
            e.preventDefault();
            let self = $(this);
            let submitBtn = modalQuickOrderContainer.find('[data-type-submit]');
            if (!$(quickOrderForm).data('process')) {
                $(quickOrderForm).data('process', true);
                submitBtn.addClass('btn-loading');

                $.ajax({
                    url: self.data('action'),
                    type: self.data('method'),
                    data: quickOrderForm.serialize(),
                    success: function (response) {
                        if (response['status'] === 'success') {
                            modalQuickOrderContainer.modal('hide')
                            modalMessage.find('h3').text(response['modal_title']);
                            modalMessage.find('.modal-body').replaceWith(response['modal_body']);
                            customNumberButtonInit();
                            updateCartIcon(0);
                            modalMessage.modal('show');
                        } else if (response['status'] === 'error') {
                            let errors = response['errors'];
                            let errorsObj = {};
                            for (let field in errors) {
                                errorsObj[field] = errors[field].join('<br>');
                            }
                        }
                        $(quickOrderForm).data('process', false);
                        submitBtn.removeClass('btn-loading');
                    },
                    error: function () {
                        $(quickOrderForm).data('process', false);
                        submitBtn.removeClass('btn-loading');
                    }
                });
            }

            return false;
        });

        $(document).on('cart:removed', function (event, data) {
            if (data['summary_count'] === 0) {
                modalQuickOrderContainer.modal('hide');
            }
        });
    }

})



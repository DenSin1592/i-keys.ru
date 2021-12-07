(function ($, document) {
    $(function () {
        let modalMessage = $('#modalMessage');
        let updateCartIcon = (count) => {
            $('.cart-item-count').text(count);
        };

        var modalQuickOrderContainer = $('#modalQuickOrder', document);
        var quickOrderForm = modalQuickOrderContainer.find('form#quick-order');

        // Quick order form handling
        if (quickOrderForm.length === 1) {

            modalQuickOrderContainer.on('click', '[data-type-submit]', function (e) {
                e.preventDefault();
                quickOrderForm.trigger('submit');
            });

            quickOrderForm.submit(function (e) {
                e.preventDefault();
                console.log('1111')
                var self = $(this);
                var submitBtn = modalQuickOrderContainer.find('[data-type-submit]');
                if (!$(quickOrderForm).data('process')) {
                    $(quickOrderForm).data('process', true);
                    submitBtn.addClass('btn-loading');
                    console.log('222')

                    $.ajax({
                        url: self.data('action'),
                        type: self.data('method'),
                        data: quickOrderForm.serialize(),
                        success: function (response) {
                            console.log(response)
                            if (response['status'] === 'success') {
                                console.log(response['status'])
                                modalQuickOrderContainer.modal('hide')
                                modalMessage.find('h3').text(response['modal_title']);
                                modalMessage.find('.modal-body').replaceWith(response['modal_body']);
                                customNumberButtonInit();
                                updateCartIcon(0);
                                modalMessage.modal('show');
                            } else if (response['status'] === 'error') {
                                var errors = response['errors'];
                                var errorsObj = {};
                                for (var field in errors) {
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
    });
})(jQuery, document);

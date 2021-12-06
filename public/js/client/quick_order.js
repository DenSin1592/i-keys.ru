(function ($, document) {
    $(function () {
        var modalQuickOrderContainer = $('#modalQuickOrder', document);
        var modalQuickOrderSentContainer = $('#modalQuickOrderSuccess', document);
        var quickOrderForm = modalQuickOrderContainer.find('form#quick-order');

        // Quick order form handling
        if (quickOrderForm.length === 1) {
            // var quickOrderValidator = quickOrderForm.validate({
            //     ignore: '',
            //     rules: {
            //         name: {
            //             required: true
            //         },
            //         phone: {
            //             required: true,
            //             phoneNumber: true
            //         },
            //         email: {
            //             email: true
            //         },
            //         privacy: 'required'
            //     }
            // });

            modalQuickOrderContainer.on('click', '[data-type-submit]', function (e) {
                e.preventDefault();
                quickOrderForm.trigger('submit');
            });

            quickOrderForm.submit(function (e) {
                e.preventDefault();
                console.log('1111')
                var self = $(this);
                // if (quickOrderForm.valid()) {
                    var submitBtn = modalQuickOrderContainer.find('[data-type-submit]');
                    if (!$(quickOrderForm).data('process')) {
                        $(quickOrderForm).data('process', true);
                        submitBtn.addClass('btn-loading');
                        console.log(self)
                        console.log(self.data)
                        console.log(self.data('action'))
                        console.log(self.data('method'))
                        console.log(quickOrderForm.serialize())


                        $.ajax({
                            url: self.data('action'),
                            type: self.data('method'),
                            data: quickOrderForm.serialize(),
                            success: function (response) {
                                if (response['status'] === 'success') {
                                    quickOrderForm.trigger('reset');
                                    cart.updateCartData(response);
                                    cart.cartChangeHandler.remove();
                                    modalQuickOrderSentContainer.find('.modal-body').html(response['order_complete_content']);
                                    modalQuickOrderSentContainer.modal('show');

                                } else if (response['status'] === 'error') {

                                    var errors = response['errors'];
                                    var errorsObj = {};
                                    for (var field in errors) {
                                        errorsObj[field] = errors[field].join('<br>');
                                    }
                                    // try {
                                    //     quickOrderValidator.showErrors(errorsObj);
                                    // } catch (e) {
                                    //     // ignore errors
                                    // }
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
                // }

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

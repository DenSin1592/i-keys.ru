document.addEventListener('DOMContentLoaded', function () {

    let modalQuickOrderContainer = $('#modalQuickOrder');
    let quickOrderForm = modalQuickOrderContainer.find('form#quick-order');
    let submitBtn = modalQuickOrderContainer.find('[type=submit]');
    let errorBlock = modalQuickOrderContainer.find('.error')

    submitBtn.on('click', function (e) {
        e.preventDefault();
        errorBlock.html('');

        submitBtn.prop('disabled', true);
        submitBtn.addClass('loader');

        let promise = $.ajax({
            url: quickOrderForm.data('action'),
            type: quickOrderForm.data('method'),
            data: quickOrderForm.serialize(),
            success: function (response) {
                if (response['status'] === 'success') {
                    modalQuickOrderContainer.modal('hide')
                    document.modalMessageShow(response['modal_title'], response['modal_body']);
                    document.updateCartIcon(0);
                    window.location.reload();
                }
                if (response['status'] === 'error') {
                    let errors = response['errors'];
                    for (let field in errors) {
                        for (let key in errors[field]) {
                            errorBlock.append(errors[field][key] + '<br>');
                        }
                    }
                }
                submitBtn.prop('disabled', false);
                submitBtn.removeClass('loader');
            },
            error: function () {
                submitBtn.prop('disabled', false);
                submitBtn.removeClass('loader');
            }
        });
    });

})



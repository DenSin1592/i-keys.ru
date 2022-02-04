document.addEventListener('DOMContentLoaded', function () {

    document.initChangeCountAdditionalKeys = () => {
        let modal = $('#modalAddKeys');

        modal.on('click', '.change-count-additional-keys', (e) => {
            let count = modal.find('input#modalAddKeysQuantity').val();

            if(!document.querySelector('[data-in-cart="true"]')){
                setLabelAdditionalKeys(count);
                return;
            }

            let data = {
                productId: modal.data('product-id'),
                serviceId: modal.data('service-id'),
                count: count,
            };

            promiseQueue.add('change-cart', () => {
                $.ajax({
                    method: 'POST',
                    url: CART_ADD_SERVICE_URI,
                    data: data,
                    cache: false,
                }).done((response) => {
                        setLabelAdditionalKeys(response['count']);
                    }
                ).fail(() => {
                    document.modalMessageErrorShow();
                })
            });

        });
    };


    showOrHideLabelAdditionalKeys();
    document.initChangeCountAdditionalKeys();

});


let setLabelAdditionalKeys = (count) => {
    let labelAdditionalKeys = $('span.count-additional-keys');
    if(!labelAdditionalKeys) return;

    labelAdditionalKeys.text(' + ' + count);
    labelAdditionalKeys.data('count', count);
    showOrHideLabelAdditionalKeys();
};

let showOrHideLabelAdditionalKeys = () => {
    let labelAdditionalKeys = $('span.count-additional-keys');
    if(!labelAdditionalKeys) return;
    if(labelAdditionalKeys.data('count') > 0){
        labelAdditionalKeys.show();
    } else {
        labelAdditionalKeys.hide();
    }
};



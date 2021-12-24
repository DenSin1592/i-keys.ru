class OrderForm {
    /**
     * Используйте debug чтобы разблокировать кнопки
     * @param debug
     * @param data
     */
    constructor(debug = false, data = []) {
        this.data = data;
        this.debug = debug;
    }

    init () {
        if (this.debug) {
            const buttons = $('#order-form button[data-order-step]');
            buttons.prop('disabled', false);
            this.testData();
        }
        this.prevStep();
        this.nextStep();
        this.checkFormElement();
    }

    checkFormElement () {
        const data = this.getFormsData();
        const attrKey = $('[data-order-if-key]').attr('data-order-if-key');
        const attrVal = $('')

        if (typeof attrKey !== 'undefined' && attr !== false) {

        }
        console.log(data['_token']);
    }

    getFormsData () {
        const forms = $('#order-form form');
        forms.each((index, item) => {
            const serialize = $(item).serializeObject();
            this.data.push(serialize);
        });

        const resultObject = Object.assign(Object.assign(this.data)).reduce(function(result, currentObject) {
            for(let key in currentObject) {
                if (currentObject.hasOwnProperty(key) && currentObject[key] !== '') {
                    if (Array.isArray(currentObject[key])) {
                        const filtred = currentObject[key].filter(function (el) {
                            return el !== '' && el !== null;
                        });
                        if (filtred.length > 1 && typeof filtred !== 'undefined') {
                            result[key] = filtred;
                        } else if (filtred.length === 1) {
                            result[key] = filtred[0];
                        }
                    } else {
                        result[key] = currentObject[key];
                    }
                }
            }
            return result;
        }, {});
        return resultObject;
    }

    disableButtons () {
        const prev = $('#order-form .checkout-control-back');
        const buttons = $('#order-form button[data-order-step]:not([disabled]),' +
            ' #order-form button[data-order-step].valid,' +
            ' #order-form button[data-order-step].invalid');
        if (!this.debug) {
            buttons.prop('disabled', true);
            prev.prop('disabled', true);
        }
    }

    enableButtons () {
        const prev = $('#order-form .checkout-control-back');
        const buttons = $('#order-form button[data-order-step]:not([disabled]),' +
            ' #order-form button[data-order-step].valid,' +
            ' #order-form button[data-order-step].invalid');
        buttons.prop('disabled', false);
        prev.prop('disabled', false);
    }



    prevStep () {
        $( ".checkout-control-back" ).click(function(event) {
            event.preventDefault();
            const accordion = $(this).parents('.checkout-accordion');
            const accordionItemIndex = $(this).parents('div[data-step]').attr('data-step');

            const prevStepClass = 'div[data-step='+ (parseInt(accordionItemIndex)-1).toString()  +']';
            const prevStep = accordion.find(prevStepClass).find('.collapse');

            prevStep.collapse('toggle');
        });
    }

    nextStep () {
        const order = this;
        $( ".checkout-control-next" ).click(function(event) {
            event.preventDefault();
            const accordion = $(this).parents('.checkout-accordion');
            const accordionItemIndex = $(this).parents('div[data-step]').attr('data-step');
            const accordionSize = accordion.find('div[data-step]').length;

            const accordionButtonClass = 'button[data-order-step='+ (parseInt(accordionItemIndex)).toString()  +']';
            const accordionNextButtonClass = 'button[data-order-step='+ (parseInt(accordionItemIndex)+1).toString()  +']';
            const accordionButtons = $('button[data-order-step]');

            const form = $(this).parents('.collapse').find('form');

            const nextStepClass = 'div[data-step='+ (parseInt(accordionItemIndex)+1).toString()  +']';
            const nextStep = accordion.find(nextStepClass).find('.collapse');

            const isLastStep = parseInt(accordionItemIndex) === (accordionSize - 1)

            if (form.valid() && !isLastStep) {
                $(accordionButtonClass)
                    .removeClass('invalid')
                    .addClass('valid');
                $(accordionNextButtonClass)
                    .addClass('invalid')
                    .removeAttr('disabled');
                nextStep.collapse('toggle');
            } else if (form.valid() && isLastStep) {
                const url = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: url,
                    data: order.getFormsData(),
                    success: function(response) {
                        if (response.status === 'success') {
                            nextStep.find('.checkout-content').html("<h3>"+response.modal_title+"</h3><p>"+response.modal_body+"</p>");
                        } else {
                            nextStep.find('.checkout-content').html("<pre>"+JSON.stringify(response.errors, null, 4)+"</pre>");
                        }
                    },
                    error:  function(xhr, str){
                        nextStep.find('.checkout-content').html("<h3>Произошла ошибка</h3><p>"+xhr.responseText+"</p>");
                    },
                    complete: function () {
                        nextStep.collapse('toggle');
                        order.disableButtons();
                        accordionButtons
                            .addClass('complete');
                    }
                });
            }
        });
    }
    testData () {
        const order = this;
        const msg = document.createElement('div');
        // $.ajax({
        //     type: "POST",
        //     url: '/order/store',
        //     data: {
        //         "name": "Danil Golota",
        //         "phone": "+7 (444) 444-44-44",
        //         "email": "test@example.com",
        //         "city": "fggfgf",
        //         "street": "gf",
        //         "building": "gfg",
        //         "flat": "g",
        //         "delivery_method": "courier",
        //         "_token": "Y3T7s1e8ugBJUbhRVi6jE323ncZKXRGXb6ur6dSL",
        //         "payment_method": "cash"
        //     },
        //     success: function(response) {
        //         msg.innerHTML = response;
        //         document.querySelector('#checkout-accordion').prepend(msg);
        //     },
        //     error:  function(xhr, str){
        //         msg.innerHTML = xhr + '<br>' + str;
        //         document.querySelector('#checkout-accordion').prepend(msg);
        //     }
        // });
    }
}


document.addEventListener("DOMContentLoaded", function(event) {
    try {
        const order = new OrderForm(true);
        order.init();

        const forms = $('#order-form form');
        forms.each(function (index, form) {
            $(form).validate( {
                highlight: function(element) {
                    $(element).parent().addClass("field-error");
                    order.disableButtons();
                },
                unhighlight: function(element) {
                    $(element).parent().removeClass("field-error");
                    order.enableButtons();
                },

                rules: {
                    name: {
                        required: true,
                        isText: true
                    },
                    email: {
                        email: true
                    },
                    phone: {
                        requiredPhone: true,
                        minLenghtPhone: 10
                    },
                    delivery_method: {
                        required: true
                    },
                    city: {
                        isText: true
                    },
                    street: {
                        isText: true
                    }
                },
                messages: {
                    delivery_method: {
                        required: 'Выберите один из способов доставки'
                    },
                    payment_method: {
                        required: 'Выберите один из методов оплаты'
                    },
                    file_upload: {
                        accept: 'Неверный формат файла'
                    }
                }
            });
        })
    } catch (e) {
        console.warn('orderSteps.js not working', e);
    }
});

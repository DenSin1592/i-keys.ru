
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
        }
        this.prevStep();
        this.nextStep();
    }

    disableButtons () {
        const prev = $('#order-form .checkout-control-back');
        const buttons = $('#order-form button[data-order-step].valid');
        if (!this.debug) {
            buttons.prop('disabled', true);
            prev.prop('disabled', true);
        }

    }

    enableButtons () {
        const prev = $('#order-form .checkout-control-back');
        const buttons = $('#order-form button[data-order-step].valid');
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
        $( ".checkout-control-next" ).click(function(event) {
            event.preventDefault();
            const accordion = $(this).parents('.checkout-accordion');
            const accordionItemIndex = $(this).parents('div[data-step]').attr('data-step');
            const accordionSize = accordion.find('div[data-step]').length;

            const accordionButtonClass = 'button[data-order-step='+ (parseInt(accordionItemIndex)).toString()  +']';
            const accordionNextButtonClass = 'button[data-order-step='+ (parseInt(accordionItemIndex)+1).toString()  +']';

            const form = $(this).parents('.collapse').find('form');

            const nextStepClass = 'div[data-step='+ (parseInt(accordionItemIndex)+1).toString()  +']';
            const nextStep = accordion.find(nextStepClass).find('.collapse');

            const isLastStep = parseInt(accordionItemIndex) === (accordionSize - 1)

            if (form.valid() && !isLastStep) {
                nextStep.collapse('toggle');
                $(accordionButtonClass).addClass('valid');
                $(accordionNextButtonClass).removeAttr('disabled');
            } else if (form.valid() && isLastStep) {
                const url = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serializeArray(),
                    success: function(response) {
                        console.log(response);
                        nextStep.find('.checkout-content').html(response.data);
                    },
                    error:  function(xhr, str){
                        console.log(xhr, str);
                        nextStep.find('.checkout-content').html(str);
                    },
                    complete: function () {
                        nextStep.collapse('toggle');
                    }
                });
            }
        });
    }
}

const forms = $('#order-form form');
forms.validate( {
    highlight: function(element) {
        $(element).parent().addClass("field-error");
        // order.disableButtons();
    },
    unhighlight: function(element) {
        $(element).parent().removeClass("field-error");
        // order.enableButtons();
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
        delivery: {
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
        delivery: {
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

document.addEventListener("DOMContentLoaded", function(event) {
    const order = new OrderForm(true);
    order.init();
});

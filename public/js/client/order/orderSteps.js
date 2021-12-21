class OrderForm {
    constructor(data = []) {
        this.data = data;
    }

    init () {
        this.prevStep();
        this.nextStep();
        this.buttonsCheckValid();
    }

    buttonsCheckValid () {
        $( "#order-form button[data-order-step]" ).click(function(event) {
            const buttonsValid = $(this).parent('.checkout-nav-list').find('.valid');
            buttonsValid.each(function (index, item) {
                console.log(item);
                const step = $(item).attr('data-order-step');
                const formClass = '#order-form div[data-step="'+step+'"] form';
                console.log($(formClass).valid());
            })

        });
    }


    prevStep () {
        $( ".checkout-control-back" ).click(function(event) {
            event.preventDefault();
            const accordion = $(this).parents('.checkout-accordion');
            const accordionItemIndex = $(this).parents('div[data-step]').attr('data-step');

            const prevStepClass = 'div[data-step='+ (parseInt(accordionItemIndex)-1).toString()  +']';
            const prevStep = accordion.find(prevStepClass).find('.collapse');

            // changeState()
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

            const form = $(this).parents('.collapse').find('form');

            const nextStepClass = 'div[data-step='+ (parseInt(accordionItemIndex)+1).toString()  +']';
            const nextStep = accordion.find(nextStepClass).find('.collapse');

            const isLastStep = parseInt(accordionItemIndex) === (accordionSize - 1)

            if (form.valid() && !isLastStep) {
                // changeState(form.valid(), accordionItemIndex)
                nextStep.collapse('toggle');
                order.data.push(form.serializeArray());
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

document.addEventListener("DOMContentLoaded", function(event) {
    const forms = $('#order-form form');
    forms.validate( {
        highlight: function(element) {
            $(element).parent().addClass("field-error");
        },
        unhighlight: function(element) {
            $(element).parent().removeClass("field-error");
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

    const order = new OrderForm();
    order.init();
});

'use strict'

document.addEventListener("DOMContentLoaded", function(event) {
    try {
        const order = new cartStepsOrder(false),
              forms = $('#order-form form');
        order.init();

        order.onCheckedHideOption($('.form-option-radio[name="delivery_method"]'),
            [ 'cdek', 'courier', 'self_cdek'],
            $('.form-option-radio[value="cash"]'));

        forms.each(function (index, form) {
            $(form).validate({
                highlight: function(element) {
                    $(element).parent().addClass("field-error");
                    order.disableButtons();
                },
                unhighlight: function(element) {
                    $(element).parent().removeClass("field-error");
                    order.enableButtons();
                },

                showErrors: function (errorMap, errorList) {
                     if (typeof errorList[0] !== "undefined") {
                        const position = $(errorList[0].element).offset().top;
                        $('html, body').animate({
                            scrollTop: position - 180
                        }, 300);
                    }
                    this.defaultShowErrors(); // keep error messages next to each input element
                },

                // спец. методы проверки в validMethods.js
                rules: {
                    email: {
                        email: true
                    },
                    phone: {
                        requiredPhone: true,
                        minLenghtPhone: 10
                    },
                    delivery_method: {
                        required: true
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
        });

        const QuikOrder = $('#quick-order');
        QuikOrder.validate({
            highlight: function(element) {
                $(element).parent().addClass("field-error");
            },
            unhighlight: function(element) {
                $(element).parent().removeClass("field-error");
            },
            rules: {
                email: {
                    email: true
                },
                phone: {
                    requiredPhone: true,
                    minLenghtPhone: 10
                },
            }
        });
    } catch (e) {
        console.warn('main.js not working', e);
    }
});

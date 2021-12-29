class cartStepsOrder {
    /**
     * Переключение шагов формы в корзине. Используйте debug чтобы разблокировать кнопки
     * @param debug
     * @param data
     */
    constructor(debug = false, data = []) {
        this.data = data;
        this.debug = debug;

        this.accordion = $('.checkout-accordion');
        this.stepButtons = $('#order-form button[data-order-step]');
        this.forms = $('#order-form form');
        this.prev = $('#order-form .checkout-control-back');
        this.buttons = $('#order-form button[data-order-step]:not([disabled]),' +
            ' #order-form button[data-order-step].valid,' +
            ' #order-form button[data-order-step].invalid');
    }

    init () {
        if (this.debug) {
            this.stepButtons.prop('disabled', false);
            this.testData();
        }
        this.prevStep();
        this.nextStep();
    }

    /**
     * Отслеживает опции и скрывает выбранные
     * @param {Object} elements Jquery
     * @param {Array} value Array of input values
     * @param {Object} hideOptions Jquery
     */
    onCheckedHideOption (elements, value, hideOptions) {
        elements.on('change', function () {
            value.forEach(item => {
                if ($(this).val() === item) {
                    hideOptions.prop('disabled', true);
                    hideOptions.parent().css('display', 'none');
                } else {
                    hideOptions.prop('disabled', false);
                    hideOptions.parent().css('display', 'flex');
                }
            });
        });
    }

    pasteUserInfoToFastOrder () {
        for (const [key, value] of Object.entries(this.getFormsData())) {
            if (key !== '_token') {
                $('#quick-order').find('input[name="'+key+'"]').val(value);
            }
        }
    }

    /**
     * Склеивает данные с форм и выплевывает JSON Object
     * @returns {Object}
     */
    getFormsData () {

        this.forms.each((index, item) => {
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

        const file = $("#checkout-attached-files").prop("files"); // костыль, jquery не понимает file input. Надо проводить через форму
        if (file) {
            resultObject['file_upload'] = file;
        }
        return resultObject;
    }

    /**
     * Отключает пагинацию слева и кнопку назад
     */
    disableButtons () {
        const buttons = $('#order-form button[data-order-step]:not([disabled]),' +
            ' #order-form button[data-order-step].valid,' +
            ' #order-form button[data-order-step].invalid');
        if (!this.debug) {
            buttons.prop('disabled', true);
            $(this.prev).prop('disabled', true);
        }
    }

    /**
     * Отменяет предыдущее
     */
    enableButtons () {
        const buttons = $('#order-form button[data-order-step]:not([disabled]),' +
            ' #order-form button[data-order-step].valid,' +
            ' #order-form button[data-order-step].invalid');
        buttons.prop('disabled', false);
        $(this.prev).prop('disabled', false);
    }


    prevStep () {
        $( ".checkout-control-back" ).click(event => {
            event.preventDefault();
            const accordion = $(event.target).parents('.checkout-accordion'),
            accordionItemIndex = $(event.target).parents('div[data-step]').attr('data-step'),
            prevStepClass = 'div[data-step='+ (parseInt(accordionItemIndex)-1).toString()  +']',
            prevStep = accordion.find(prevStepClass).find('.collapse');

            prevStep.collapse('toggle');
        });
    }

    nextStep () {
        $( ".checkout-control-next" ).click(event => {
            event.preventDefault();
            const accordionItemIndex = $(event.target).parents('div[data-step]').attr('data-step'),
                form = $(event.target).parents('.collapse').find('form'),
                accordionSize = this.accordion.find('div[data-step]').length,
                accordionButtonClass = 'button[data-order-step='+ (parseInt(accordionItemIndex)).toString()  +']',
                accordionNextButtonClass = 'button[data-order-step='+ (parseInt(accordionItemIndex)+1).toString()  +']',
                nextStepClass = 'div[data-step='+ (parseInt(accordionItemIndex)+1).toString()  +']',
                nextStep = this.accordion.find(nextStepClass).find('.collapse'),
                isLastStep = parseInt(accordionItemIndex) === (accordionSize - 1);

            if ($(event.target.form).valid() && !isLastStep) {
                if(accordionItemIndex === '1') {
                    this.pasteUserInfoToFastOrder();
                }

                $(accordionButtonClass)
                    .removeClass('invalid')
                    .addClass('valid');
                $(accordionNextButtonClass)
                    .addClass('invalid')
                    .removeAttr('disabled');
                nextStep.collapse('toggle');
            } else if ($(event.target.form).valid() && isLastStep) {
                console.log(this.getFormsData(), $(event.target.form).serializeArray());
                $(event.target).html('Идет отправка...');
                const url = form.attr('action');

                const fd = new FormData();
                $.each(this.getFormsData(), function(key, value){
                    fd.append(key, value);
                })

                $.ajax({
                    type: "POST",
                    url: url,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    data: fd,
                    success: function(response) {
                        if (response.status === 'success') {
                            document.updateCartIcon(0);
                            nextStep.find('.checkout-content').html("<h3>"+response.modal_title+"</h3><p>"+response.modal_body+"</p>");
                        } else {
                            nextStep.find('.checkout-content').html("<h3>Произошла ошибка при создании заказа</h3><p>Приносим свои извинения. Обновите страницу и попробуйте снова</p>");
                            console.warn(JSON.stringify(response.errors, null, 4))
                        }
                    },
                    error:  function(xhr, str){
                        nextStep.find('.checkout-content').html("<h3>Произошла ошибка при создании заказа</h3><p>Приносим свои извинения. Обновите страницу и попробуйте снова</p>");
                        console.warn(xhr.responseText)
                    },
                    complete: (() => {
                       nextStep.collapse('toggle');
                        this.disableButtons();
                        this.stepButtons
                            .addClass('complete');
                    })
                });
            }
        });
    }

    /**
     * Используется для быстрого теста (if debug true). Ajax отправляется сразу
     */

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

const formsData = [];
document.addEventListener("DOMContentLoaded", function(event) {
    $( ".checkout-control" ).click(function(event) {
        event.preventDefault();
        const accordion = $(this).parents('.checkout-accordion');
        const accordionItemIndex = $(this).parents('div[data-step]').attr('data-step');
        const accordionSize = accordion.find('div[data-step]').length;

        const form = $(this).parents('.collapse').find('form');
        const nextStepClass = 'div[data-step='+ (parseInt(accordionItemIndex)+1).toString()  +']';
        const nextStep = accordion.find(nextStepClass).find('.collapse');


        console.log(accordionSize);
        const validator = form.data('validator');
        form.validate({
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
                }
            }
        });

        if (form.valid()) {
            nextStep.collapse('toggle');
            formsData.push(form.serializeArray());
            console.log(formsData);
        }

        // $.ajax({
        //     type: "POST",
        //     url: "/order/fast/store",
        //     data: data,
        //     success: function(response) {
        //
        //     },
        //     error:  function(xhr, str){
        //
        //     }
        // });
    });

});

document.addEventListener("DOMContentLoaded", function(event) {
    $( ".checkout-control" ).click(function() {
        const accordion = $(this).parents('.checkout-accordion');
        const accordionItemIndex = $(this).parents('div[data-step]').attr('data-step');
        const form = $(this).parents('.collapse').find('form');
        const nextStepClass = 'div[data-step='+ (parseInt(accordionItemIndex)+1).toString()  +']';
        const nextStep = accordion.find(nextStepClass).find('.collapse');


        const validator = form.data('validator');
        form.validate({
            rules: {
                name: {
                    min: 2
                },
                phone: {
                    requiredPhone: true,
                    minLenghtPhone: 10
                }
            }
        });

        if (form.valid()) {
            nextStep.collapse('toggle');
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

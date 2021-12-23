document.addEventListener('DOMContentLoaded', function () {

    const TIME_OPACITY = 500;
    const TIME_OPACITY_TIMEOUT = TIME_OPACITY - 300;
    const URL_CHANGE_CARD = '/change-product-card'

    $(document).on('change', 'input.change-card', (e) => {
        e.preventDefault();
        let input = $(e.currentTarget);
        let productCard = input.closest('.product-item');
        let productCardContent = input.closest('.card-product');

        productCard.find('input.change-card').attr("disabled", "disabled");
        productCard.find('a').attr('href', 'javascript:;')
        productCard.stop().animate({opacity: 0}, TIME_OPACITY)

        let data = {
            productId: input.data('productId'),
            cardNumber: productCardContent.data('cardNumber'),
        }

        $.ajax({
            method: 'POST',
            url: URL_CHANGE_CARD,
            data: data,
            cache: false
        }).done((response) => {
            setTimeout(() => {
                productCardContent.replaceWith(response['content']);
                productCard.animate({opacity: 1}, TIME_OPACITY)}, TIME_OPACITY_TIMEOUT)
        }).fail(() => {
            productCard.remove();
        });
    });
});


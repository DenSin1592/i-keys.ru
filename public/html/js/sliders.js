$(function () {
    $('.swiper-products').each(function (_, container) {
        let jContainer = $(container);
        new Swiper(jContainer, {
            observer: true,
            observeParents: true,
            slidesPerView: 'auto',
            breakpointsInverse: true,
            breakpoints: {
                // when window width is >= 480px
                480: {
                  slidesPerView: 2,
                },
                // when window width is >= 750px
                750: {
                  slidesPerView: 3,
                },
                // when window width is >= 970px
                970: {
                  slidesPerView: 4,
                }
            }
        });
    });

    $('.swiper-related-products').each(function (_, container) {
        let jContainer = $(container);
        new Swiper(jContainer, {
            observer: true,
            observeParents: true,
            slidesPerView: 'auto',
            breakpointsInverse: true,
            breakpoints: {
                // when window width is >= 480px
                480: {
                  slidesPerView: 2,
                },
                // when window width is >= 750px
                750: {
                  slidesPerView: 3,
                  touchRatio: 0,
                },
            }
        });
    });
})
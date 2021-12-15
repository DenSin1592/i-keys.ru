$(function () {
    // product gallery
    $('.product-thumbnail-container').each(function (_, container) {
        let sliderContainer, mainSwiper, thumbsSwiper,
            thumbnails, prev, next,
            thumbsSwiperContainer, mainSwiperContainer;

        sliderContainer = $(container);
        next = sliderContainer.find('.swiper-product-thumbnails-button-next');
        prev = sliderContainer.find('.swiper-product-thumbnails-button-prev');
        // pagination = sliderContainer.find('.swiper-product-gallery-pagination');


        // Swiper containers
        mainSwiperContainer = sliderContainer.find('.swiper-product-gallery');
        thumbsSwiperContainer = sliderContainer.find('.swiper-product-thumbnails');


        // Init thumbs swiper
        thumbsSwiper = new Swiper(thumbsSwiperContainer, {
            slidesPerView: 'auto',
            breakpointsInverse: true,
            
            breakpoints: {
                // when window width is >= 480px
                480: {
                    direction: 'vertical',
                },
                // when window width is >= 750px
                750: {
                    direction: 'horizontal',
                },
                // when window width is >= 1680px
                1680: {
                    // slidesPerView: 6
                }
            },

            navigation: {
                nextEl: next,
                prevEl: prev,
            },

            on: {
                resize: function () {
                    thumbsSwiper.update();
                }
            },
        })

        if (thumbsSwiperContainer.length === 1) {
            thumbnails = thumbsSwiperContainer.find('.swiper-slide');
            thumbnails.click(function (e) {
                var index = thumbnails.index(e.currentTarget);
                
                mainSwiper.slideTo(index);
                e.preventDefault();
            });
        }


        // Init main swiper
        mainSwiper = new Swiper(mainSwiperContainer, {
            slidesPerView: 1,

            navigation: {
                nextEl: next,
                prevEl: prev,
            },

            on: {
                init: function () {
                    if (thumbnails) {
                        thumbnails.eq(this.realIndex).addClass('active');
                    }
                    mainSwiperContainer.addClass('initialized');
                },
                slideChange: function () {
                    if (thumbnails) {
                        thumbnails.removeClass('active');
                        thumbnails.eq(this.realIndex).addClass('active');
                    }
                    if (thumbsSwiper) {
                        thumbsSwiper.slideTo(this.realIndex);
                    }
                }
            },
            hashnav: true,
            hashnavWatchState: true
        });
    })
})
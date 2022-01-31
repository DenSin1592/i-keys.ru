$(function () {
    // product gallery
    $('.product-thumbnail-container').each(function (_, container) {
        let sliderContainer, mainSwiper, thumbsSwiper,
            slides, thumbnails, prev, next,
            thumbsSwiperContainer, mainSwiperContainer;

        sliderContainer = $(container);
        next = sliderContainer.find('.swiper-product-thumbnails-button-next');
        prev = sliderContainer.find('.swiper-product-thumbnails-button-prev');


        // Swiper containers
        mainSwiperContainer = sliderContainer.find('.swiper-product-gallery');
        thumbsSwiperContainer = sliderContainer.find('.swiper-product-thumbnails');
        slides = mainSwiperContainer.find('.swiper-slide');

        
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

                if(slides.length > 1) {
                    index += 1;
                }
                
                mainSwiper.slideTo(index);
                e.preventDefault();
            });
        }


        // Init main swiper
        mainSwiper = new Swiper(mainSwiperContainer, {
            slidesPerView: 1,
            loop: slides.length > 1 ? true : false,
            touchRatio: slides.length > 1 ? 1 : 0,

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

        // product fancybox
        $().fancybox({
            selector : '.swiper-product-gallery .swiper-slide:not(.swiper-slide-duplicate) .product-media-link',
            backFocus : false,
            loop: true,
            keyboard: true,
            buttons: [
                "close"
            ],
            
            // change active swiper slide after change active fancybox slide 
            afterShow : function( instance, current ) {
                mainSwiper.slideToLoop(current.index);
            }
        });

        // remove dublication swiper slides in fancybox gallery
        $(document).on('click', '.swiper-product-gallery .swiper-slide-duplicate', function(e) {
            var $slides = $(this)
                .parent()
                .children('.swiper-slide:not(.swiper-slide-duplicate)');

            $slides
                .eq( ( $(this).attr("data-swiper-slide-index") || 0) % $slides.length )
                .find('a.product-media-link')
                .trigger("click.fb-start", { $trigger: $(this) });

            return false;
        });
    })
})
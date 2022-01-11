$(function () {
    $('.section-compare').each(function (_, container) {
        let compareContainer, compareContainerBG, mainSwiper, prev, next;
        
        compareContainer = $(container);
        compareContainerBG = compareContainer.find('.section-compare-backdrop'),
        mainSwiper = compareContainer.find('.swiper-compare');
        next = compareContainer.find('.swiper-compare-button-next');
        prev = compareContainer.find('.swiper-compare-button-prev');
        compareToggle = compareContainer.find('#switchCompare'),
        compareSpecificationsListAll = compareContainer.find('.compare-specifications-all'),
        compareSpecificationsListDiff = compareContainer.find('.compare-specifications-diff'),

        new Swiper(mainSwiper, {
            observer: true,
            observeParents: true,
            slidesPerView: 2,
            observerUpdate: true,
            breakpointsInverse: true,
            breakpoints: {
                // when window width is >= 750px
                750: {
                  slidesPerView: 3,
                },
                // when window width is >= 970px
                970: {
                  slidesPerView: 4,
                },
                // when window width is >= 1200px
                1200: {
                    slidesPerView: 'auto',
                }
            },

            navigation: {
                nextEl: next,
                prevEl: prev,
            },
        });

        /**
         * Match height on compare page.
         */
        let matchHeight = function () {
            // Match headers
            let maxHeaderHeight = 0;
            compareContainer.find('.compare-header').each(function (_, header) {
                $(header).css('min-height', '');
            }).each(function (_, header) {
                let jHeader = $(header);
                let height = Math.round(jHeader.outerHeight());
                if (height > maxHeaderHeight) {
                    maxHeaderHeight = height;
                }
            }).each(function (_, header) {
                $(header).css('min-height', maxHeaderHeight + 'px');
            });


            // Set section background
            $(compareContainerBG).css('top', compareContainer.find('.swiper-compare')[0].offsetTop + maxHeaderHeight + 'px');


            // Match parameters
            let maxItemHeights = [];
            compareContainer.find('.compare-content').each(function (_, body) {
                $(body).find('.compare-specification-item').css('min-height', '');
            }).each(function (_, body) {
                $(body).find('.compare-specification-item').each(function (_, item) {
                    let jItem = $(item);
                    let height = Math.round(jItem.outerHeight());
                    if (typeof maxItemHeights[_] === 'undefined') {
                        maxItemHeights.push(height);
                    } else if (height > maxItemHeights[_]) {
                        maxItemHeights[_] = height;
                    }
                });
            }).each(function (_, body) {
                $(body).find('.compare-specification-item').each(function (_, item) {
                    let jItem = $(item);
                    jItem.css('min-height', maxItemHeights[_] + 'px');
                });
            });
        };

        $(compareToggle).on('change', function(event) {
            if(compareToggle[0].checked) {
                console.log('checked');

                compareSpecificationsListAll.addClass('d-none');
                compareSpecificationsListDiff.removeClass('d-none');

                matchHeight();
            }

            if(!compareToggle[0].checked) {
                compareSpecificationsListDiff.addClass('d-none');
                compareSpecificationsListAll.removeClass('d-none');

                matchHeight();
            }
        })

        // Init match height on document ready and resize
        let matchHeightTimeout = null;

        beforeWindowWidthResizeFunctions.push(function () {
            if (windowSizeHelper.isHorizontalResize()) {
                if (matchHeightTimeout) {
                    clearTimeout(matchHeightTimeout);
                }

                setTimeout(function () {
                    matchHeight();
                }, 50);
            }
        });

        let initCompareBlock = function () {
            matchHeight();
        };

        initCompareBlock();
    });
})
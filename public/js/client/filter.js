document.addEventListener('DOMContentLoaded', () => {


    let categoryContent = $('#category-content');
    let headerFix = $('.header-box');

    if (categoryContent.length !== 1) {
        return;
    }
    let filterContainer = $('#filter');

    let loaderFactory = (function (container) {
        let loading = null;
        let jWindow = $(window);

        let positionLoading = function () {

            let contentTopOffset = container.offset().top;
            let contentLeftOffset = container.offset().left;

            contentLeftOffset = (contentLeftOffset > 0)? contentLeftOffset : (contentLeftOffset * -2);
            let contentHeight = container.height();
            let contentWidth = container.width();
            let scrollTop = jWindow.scrollTop();
            let windowHeight = jWindow.height();
            let topWindowOffset = contentTopOffset - scrollTop;
            if (topWindowOffset < 0) {
                topWindowOffset = 0;
            }

            let bottomWindowOffset = contentTopOffset + contentHeight - scrollTop;
            if (bottomWindowOffset > windowHeight) {
                bottomWindowOffset = windowHeight;
            }
            let topPosition = (bottomWindowOffset - topWindowOffset) / 2 + topWindowOffset;
            let leftPosition = (contentWidth / 2) + contentLeftOffset;

            loading.css({left: leftPosition + 'px', top: topPosition + 'px'});
        };


        let appendLoading = function () {
            let zIndex = parseInt(container.css('z-index'), 10);
            if (isNaN(zIndex)) {
                zIndex = 0;
            }
            zIndex += 1;
            loading = $('<img src="/images/common/loaders/loading-red.svg" alt="" />');
            loading.css({
                position: 'fixed', zIndex: zIndex,
                backgroundColor: 'rgba(255, 255, 255, 0.0)',
                borderRadius: '64px',
                width: '64px', height: '64px',
                marginLeft: '-32px', marginTop: '-32px'
            });
            loading.appendTo(document.body);
            positionLoading();
            jWindow.on('scroll', positionLoading);
        };

        let removeLoading = function () {
            if (loading) {
                loading.remove();
            }
            jWindow.off('scroll', positionLoading);
        };

        return {
            start: appendLoading,
            stop: removeLoading
        }
    });

    let contentLoader = loaderFactory(categoryContent);
    let filterLoader = loaderFactory(filterContainer);


    let categoryPage = (function () {
        let initializerList = [];

        return {
            lock: function () {
                categoryContent.css({opacity: 0.4});
                contentLoader.start();
                if ($('body').hasClass('filter-open')) {
                    filterLoader.start();
                }

            },
            unlock: function () {
                categoryContent.css({opacity: ''});
                contentLoader.stop();
                filterLoader.stop();
            },
            updateState: function () {
                history.replaceState({categoryPage: true}, '', document.location.href);
            },
            changeUrl: function (url) {
                if (window.location.href !== url) {
                    history.pushState({categoryPage: true}, '', url);
                }
            },
            change: function (url) {
                let that = this;

                // Collect list of expanded parameters
                let filterExpandedParams = {};
                filterContainer.find('.filter-more.active').each(function (_, collapseToggle) {
                    filterExpandedParams[$(collapseToggle).data('id')] = true;
                });

                // Check if filter is expanded
                let filterExpanded = !filterContainer.find('.filter-expand').hasClass('collapsed');

                this.changeUrl(url);
                return $.ajax({
                    url: url,
                    data: {filterExpanded: filterExpanded, filterExpandedParams: filterExpandedParams},
                    method: 'get',
                    cache: false,
                }).then(function (response) {
                    that.initializers.cleanUp();
                    $('#breadcrumbs').html(response['breadcrumbsContent']);
                    filterContainer.html(response['filterContent']);
                    filterContainer.find('[name="sorting"]').val(response['sorting']);
                    categoryContent.html(response['categoryContent']);
                    $('h1').text(response['h1']);
                    that.initializers.init();
                }).promise();
            },
            initializers: {
                push: function (initializer) {
                    initializerList.push(initializer);
                },
                init: function () {
                    initializerList.forEach(function (i) {
                        i.init();
                    });
                },
                cleanUp: function () {
                    initializerList.forEach(function (i) {
                        i.cleanUp();
                    });
                },
            },
        };
    })();


    /**
     * Apply filter and open category page. Return promise which resolved, when filter applied and processed.
     *
     * @param url
     * @param method
     * @param data
     * @returns {*}
     */
    let applyFilter = function (url, method, data) {
        method = method || 'get';
        data = data || {};
        let filterDeferred = $.Deferred();
        let filterPromise = filterDeferred.promise();
        promiseQueue.add('category-page.load', function () {
            categoryPage.updateState();
            categoryPage.lock();
            return $.ajax({
                url: url,
                data: data,
                method: method,
                cache: false,
            }).then(function (response) {
                return categoryPage.change(response['url']).then(function () {
                    categoryPage.unlock();
                }).then(function () {
                    filterDeferred.resolve();
                });
            }).promise();
        });

        return filterPromise;
    };

    let scrollToProducts = () => {
        $('html').animate({
            scrollTop: (categoryContent.offset().top - headerFix.outerHeight())
        }, 1000)
    };


    /**
     * Open category page. Return promise.
     *
     * @param url
     * @param updateState
     * @param scroll
     * @returns {PromiseLike<any> | Promise<any> | t}
     */
    let openPage = function (url, updateState, scroll) {
        updateState = typeof updateState === 'undefined' ? true : updateState;
        promiseQueue.add('category-page.load', function () {
            if (updateState) {
                categoryPage.updateState();
            }
            categoryPage.lock();
            return categoryPage.change(url).then(function () {
                categoryPage.unlock();
                if (!!scroll) {
                    scrollToProducts();
                }
            });
        });
    };

    // Pop URL: back, forward
    addEventListener('popstate', function (event) {
        if (event.state && typeof event.state['categoryPage'] !== 'undefined') {
            openPage(window.location.href, false, true);
        }
    });


    // Init custom selects (select2) on page change
    categoryPage.initializers.push((function () {
        return {
            init: () => { initSelect2(); initFilterRangeSlider(); },
            cleanUp: () => {},
        };
    })());


    // Init sorting
    categoryPage.initializers.push((function () {
        let applySorting = function (url, direct) {
            direct = parseInt(direct, 10);
            if (direct === 1) {
                openPage(url);
            } else {
                applyFilter(url);
            }
        };
        let sortingHandler = function (e) {
            let option = e.currentTarget.options[e.currentTarget.selectedIndex];
            let url = option.value;
            let direct = $(option).data('direct');
            applySorting(url, direct);
        };

        return {
            init: () => { $('#products-sort').on('change', sortingHandler); },
            cleanUp: ()  => {},
        };
    })());


    // Init pagination
    categoryPage.initializers.push((function () {
        let paginationHandler = function (e) {
            e.preventDefault();
            openPage(e.currentTarget.href, true, true);
        };

        return {
            init: () => { categoryContent.find('.pagination').on('click', 'a.page-link', paginationHandler); },
            cleanUp: () => { categoryContent.find('.pagination').off('click', 'a.page-link', paginationHandler); }
        };
    })());


    // Init filter sliders
    categoryPage.initializers.push((function () {
        return {
            init: () => {},
            cleanUp: () => {}
        };
    })());


    // Call initializers on page load
    categoryPage.initializers.init();

    // Filter reset
    (function () {
        categoryContent.on('click', '#filter-reset .catalog-selection-remove', function (e) {
            let currentVariant = $(e.currentTarget).closest('[data-type]');
            let type = currentVariant.data('type');
            let current = $(e.currentTarget);


            switch (type) {
                case 'choice':
                    let control = $('#' + current.data('attributeId'));
                    control.get(0).checked = false;
                    control.trigger('change');
                    break;
                case 'range':
                    let controlFrom = $('#' + currentVariant.data('idFrom'));
                    let controlTo = $('#' + currentVariant.data('idTo'));
                    controlFrom.val(controlFrom.data('border'));
                    controlTo.val(controlTo.data('border'));
                    controlFrom.trigger('change');
                    controlTo.trigger('change');
                    break;
                case 'cylinder_size':
                    let controlFirst = document.querySelector('#' + currentVariant.data('idFirst'));
                    let controlSecond = document.querySelector('#' + currentVariant.data('idSecond'));
                    controlFirst.selectedIndex = 0
                    controlSecond.selectedIndex = 0
                    controlFirst.dispatchEvent(new MouseEvent('change'));
                    controlSecond.dispatchEvent(new MouseEvent('change'));
                    break;
            }
            currentVariant.remove();
            filterContainer.find('form').submit();
        });

        categoryContent.on('click', '#filter-reset [data-reset-filter]', function (e) {
            openPage($(e.currentTarget).data('url'));
        });
    })();


    // Filter submit
    (function () {
        let formProcessing = false;

        let submitForm = function (container) {
            if (!formProcessing) {
                formProcessing = true;
                let filterForm = container.find('form');
                // Disable input which does not have proper value - value matches it's border
                filterForm.find('[data-border]').each(function (_, inputDomElement) {
                    let inputElement = $(inputDomElement);
                    let border = parseInt(inputElement.data('border'), 10);
                    let value = parseInt(inputElement.val(), 10);
                    if (border === value) {
                        inputElement.prop('disabled', true);
                    }
                });

                let formUrl = filterForm.get(0).action;
                let formMethod = filterForm.get(0).method;
                let formData = filterForm.serialize();


                filterForm.find('input').prop('disabled', true);
                applyFilter(formUrl, formMethod, formData).then(function () {
                    formProcessing = false;
                });
            }
        };

        filterContainer.on('submit', 'form', function (e) {
            e.preventDefault();
            submitForm(filterContainer);
        });

        filterContainer.on('change', 'form', function () {
            submitForm(filterContainer);
        });

    })();
});

(function ($) {

    // It's better to make class for editor with multiple methods
    // to show modal, hide and so on.

    /**
     * Function to add new element in editor.
     *
     * @param currentProductsList
     * @param productId
     * @param productName
     * @returns {*|HTMLElement}
     */
    function appendProductElement(currentProductsList, productId, productName) {
        var newProductElement, productElementTemplate;

        productElementTemplate =
            '<li class="product-list-element" data-associated-products="product-element" data-product-id="">' +
            '<span class="product-control glyphicon glyphicon-minus text-danger" data-associated-products="remove"></span>' +
            (currentProductsList.data('sorting') == 'disabled' ? '' : '<span class="product-sorting glyphicon glyphicon-resize-vertical" data-associated-products="sortable-handler"></span>') +
            '<span data-associated-products="current-product-name"></span>' +
            '</li>';
        newProductElement = $(productElementTemplate);
        newProductElement.attr('data-product-id', productId);
        newProductElement.attr('data-product-name', productName);
        newProductElement.find('[data-associated-products="current-product-name"]').text(productName);

        currentProductsList.append(newProductElement);

        return newProductElement;
    }


    function addProduct(availableProductsContainer, currentProductsList, productId, productName) {
        var existingProductElement, availableProductElement;

        existingProductElement = currentProductsList.find(
            '[data-associated-products="product-element"][data-product-id="' + productId + '"]'
        );

        availableProductElement = availableProductsContainer.find(
            '[data-associated-products="product-element"][data-product-id="' + productId + '"]'
        );

        if (existingProductElement.length === 0) {
            appendProductElement(currentProductsList, productId, productName);
            availableProductElement.addClass('selected');
        }

        addProductId(productId, currentProductsList);
    }


    function removeProduct(availableProductsContainer, currentProductsList, productId) {
        var existingProductElement, availableProductElement;

        existingProductElement = currentProductsList.find(
            '[data-associated-products="product-element"][data-product-id="' + productId + '"]'
        );

        availableProductElement = availableProductsContainer.find(
            '[data-associated-products="product-element"][data-product-id="' + productId + '"]'
        );

        existingProductElement.remove();
        if (availableProductElement.length > 0) {
            availableProductElement.removeClass('selected');
        }

        removeProductId(productId, currentProductsList);
    }

    /**
     * Reset selected product id.
     *
     * @param currentProductsList
     */
    function resetSelectedProductIds(currentProductsList) {
        currentProductsList.data('selectedProductIds', []);
    }

    /**
     * Add product id to selected.
     *
     * @param productId
     * @param currentProductsList
     */
    function addProductId(productId, currentProductsList) {
        var selectedProductIds;

        productId = parseInt(productId, 10);
        selectedProductIds = currentProductsList.data('selectedProductIds') || [];

        if (selectedProductIds.indexOf(productId) === -1) {
            selectedProductIds.push(productId);
        }

        currentProductsList.data('selectedProductIds', selectedProductIds);
    }

    /**
     * Remove product id from selected.
     *
     * @param productId
     * @param currentProductsList
     */
    function removeProductId(productId, currentProductsList) {
        var selectedProductIds, productIdIndex;

        selectedProductIds = currentProductsList.data('selectedProductIds');

        if (selectedProductIds) {
            productIdIndex = selectedProductIds.indexOf(productId);
            if (productIdIndex !== -1) {
                selectedProductIds.splice(productIdIndex, 1);
            }

            currentProductsList.data('selectedProductIds', selectedProductIds);
        }
    }

    /**
     * Get selected product ids.
     *
     * @param currentProductsList
     * @returns {*|Array}
     */
    function getSelectedProductIds(currentProductsList) {
        return currentProductsList.data('selectedProductIds') || [];
    }

    /**
     * Get category for active tab of available products.
     *
     * @param productListContainer
     * @returns {*}
     */
    function getCategoryId(productListContainer) {
        return productListContainer.data('categoryId');
    }

    /**
     * Get active product list container.
     *
     * @param productsTabsContainer
     * @returns {*}
     */
    function getActiveProductListContainer(productsTabsContainer) {
        var productsTabs, productListContainer;

        productsTabs = productsTabsContainer.children();
        productListContainer = productsTabs.filter(':visible');

        return productListContainer;
    }

    /**
     * Get product list container.
     *
     * @param filterInput
     * @returns {*|HTMLElement}
     */
    function getProductListContainer(filterInput) {
        return $(filterInput.data('productListFilter'))
    }

    /**
     * Check that filter empty.
     *
     * @param filterInput
     * @returns {boolean}
     */
    function isFilterEmpty(filterInput) {
        return filterInput.val() === '';
    }

    /**
     * Mark tabs as dirty (i.e. need to be updated).
     *
     * @param productListTabContainer
     */
    function markAllTabsAsDirty(productListTabContainer) {
        productListTabContainer.children().data('dirty', true);
    }

    /**
     * Lock available products navigation tabs.
     *
     * @param editor
     */
    function lockAvailableProductsTabs(editor) {
        editor.find('.available-products-tabs').children().addClass('disabled');
    }

    /**
     * Unlock available products navigation tabs.
     *
     * @param editor
     */
    function unlockAvailableProductsTabs(editor) {
        editor.find('.available-products-tabs').children().removeClass('disabled');
    }

    /**
     * Function to filter available products.
     *
     * @param filterValue
     * @param filterUrl
     * @param categoryId
     * @param selectedProductIds
     * @param productListContainer
     * @returns {*}
     */
    function filterAvailable(filterValue, filterUrl, categoryId, selectedProductIds, productListContainer) {
        var xhr;

        productListContainer.find('.product-list').addClass('wait');

        xhr = $.ajax({
            cache: false,
            url: filterUrl,
            type: 'POST',
            dataType: 'json',
            data: {
                query: filterValue,
                categoryId: categoryId,
                selectedProductIds: selectedProductIds
            }
        });

        xhr.then(function (response) {
            productListContainer.data('dirty', false);
            productListContainer.find('.product-list').removeClass('wait');
            productListContainer.html(response['content']);
        });

        return xhr;
    }

    /**
     * Function to filter selected products.
     * @param filterValue
     * @param filterUrl
     * @param selectedProductIds
     * @param productsContainer
     */
    function filterSelected(filterValue, filterUrl, selectedProductIds, productsContainer) {
        var xhr;

        productsContainer.addClass('wait');

        xhr = $.ajax({
            cache: false,
            url: filterUrl,
            type: 'POST',
            dataType: 'json',
            data: {
                query: filterValue,
                selectedProductIds: selectedProductIds
            }
        });

        xhr.then(function (response) {
            productsContainer.removeClass('wait');
            productsContainer.html(response['content']);
        });

        return xhr;
    }

    window.associatedProductEditorsInit = function () {
        var associatedProductEditors;

        associatedProductEditors = $('[data-associated-products="editor"]');
        if (associatedProductEditors.length === 0) {
            return;
        }

        associatedProductEditors.each(function (index, editorDomObj) {
            var editor, availableProductsContainer, availableProductsUrl, currentProductsList, targetContainer,
                filterHandler, filterAvailableHandler, filterSelectedHandler;

            editor = $(editorDomObj);

            targetContainer = $(editor.data('targetContainer'));
            availableProductsContainer = editor.find('[data-associated-products="available-products-container"]');
            availableProductsUrl = availableProductsContainer.data('availableProductsUrl');
            currentProductsList = editor.find('[data-associated-products="current-products"]');

            filterHandler = function (filterInput, filterCallback) {
                var filterValue, filterUrl,
                    productsContainer,
                    filterTimeout, xhr, deferred;

                deferred = $.Deferred();

                filterTimeout = filterInput.data('filterTimeout');
                xhr = filterInput.data('xhr');

                if (filterTimeout) {
                    clearTimeout(filterTimeout);
                }

                if (xhr) {
                    xhr.abort();
                }

                filterValue = filterInput.val();
                filterUrl = filterInput.data('filterUrl');
                productsContainer = getProductListContainer(filterInput);

                filterTimeout = setTimeout(function () {
                    lockAvailableProductsTabs(editor);
                    xhr = filterCallback(filterValue, filterUrl, productsContainer);

                    xhr.then(function () {
                        unlockAvailableProductsTabs(editor);
                        deferred.resolve();
                    });

                    filterInput.data('xhr', xhr);
                }, 150);

                filterInput.data('filterTimeout', filterTimeout);

                return deferred;
            };

            filterAvailableHandler = function () {
                var filterInput = editor.find('[data-associated-products="filter-available"]');

                return filterHandler(filterInput, function (filterValue, filterUrl, productsTabsContainer) {
                    var productListContainer, categoryId, selectedProductIds;

                    productListContainer = getActiveProductListContainer(productsTabsContainer);
                    categoryId = getCategoryId(productListContainer);
                    selectedProductIds = getSelectedProductIds(currentProductsList);

                    return filterAvailable(filterValue, filterUrl, categoryId, selectedProductIds, productListContainer)
                });
            };

            filterSelectedHandler = function () {
                var filterInput = editor.find('[data-associated-products="filter-selected"]');

                return filterHandler(filterInput, function (filterValue, filterUrl, productsContainer) {
                    var selectedProductIds;

                    selectedProductIds = getSelectedProductIds(currentProductsList);

                    return filterSelected(filterValue, filterUrl, selectedProductIds, productsContainer);
                });
            };

            editor.on('show.bs.modal', function () {
                var selectedProductIds;

                availableProductsContainer.html('<img src="/images/common/ajax-loader/small_black.gif" class="loading" alt="..." />');
                currentProductsList.html('');
                resetSelectedProductIds(currentProductsList);

                targetContainer.find('[data-associated-products="current-product-element"]').each(function (index, element) {
                    var productElement, productId;
                    productElement = $(element);
                    productId = productElement.find('[data-product-element="product_id"]').val();

                    addProductId(productId, currentProductsList);
                });

                selectedProductIds = getSelectedProductIds(currentProductsList);

                $.ajax({
                    cache: false,
                    url: availableProductsUrl,
                    type: 'POST',
                    dataType: 'json',
                    data: {selectedProductIds: selectedProductIds}
                }).then(function (response) {
                    availableProductsContainer.html(response['available_content']);
                    currentProductsList.html(response['selected_content']);

                    heightResize.initResizeBlocks(
                        '[data-associated-products="editor"]',
                        '.top-padding',
                        ['.categories-list'],
                        {resizeRootElements: true},
                        {}
                    );
                });
            });

            $(availableProductsContainer).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
                var productListContainer;

                productListContainer = $(e.target.hash);

                if (productListContainer.data('dirty') === true) {
                    filterAvailableHandler();
                }
            });

            editor.on('click', '[data-associated-products="add"]', function () {
                var productElement, productId, productName, filterSelectedInput;

                productElement = $(this).parents('[data-associated-products="product-element"]').eq(0);
                productId = productElement.data('productId');
                productName = productElement.data('productName');

                filterSelectedInput = editor.find('[data-associated-products="filter-selected"]');

                addProduct(availableProductsContainer, currentProductsList, productId, productName);

                if (!isFilterEmpty(filterSelectedInput)) {
                    filterSelectedHandler();
                }
            });


            editor.on('click', '[data-associated-products="remove"]', function () {
                var productElement, productId;

                productElement = $(this).parents('[data-associated-products="product-element"]').eq(0);
                productId = productElement.data('productId');

                removeProduct(availableProductsContainer, currentProductsList, productId);
            });


            editor.on('click', '[data-associated-products="save"]', function () {
                var button, url, currentProductsData, position;

                button = $(this);
                url = button.data('url');

                currentProductsData = [];
                position = 0;
                currentProductsList.find('[data-associated-products="product-element"]').each(function (index, element) {
                    var productElement, productId;
                    productElement = $(element);
                    productId = productElement.data('productId');
                    currentProductsData.push({product_id: productId, position: position += 10});
                });

                button.button('loading');

                editor.trigger('associated-products.saving');
                $.ajax({
                    cache: false,
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {products: currentProductsData}
                }).then(function (result) {
                    targetContainer.html(result['content']);
                    editor.modal('hide');
                    editor.trigger('associated-products.saved');
                    button.button('reset');
                });
            });

            editor.on('click', '[data-associated-products="apply-filter"]', function () {
                  var button;

                  button = $(this);

                  $(button.data('target')).trigger('keyup');
            });

            editor.on('keyup', '[data-associated-products="filter-available"]', function () {
                var filterInput, productListTabContainer;

                filterInput = $(this);

                productListTabContainer = getProductListContainer(filterInput);
                markAllTabsAsDirty(productListTabContainer);

                filterAvailableHandler();
            });

            editor.on('keyup', '[data-associated-products="filter-selected"]', function () {
                filterSelectedHandler();
            });

            editor.on('click', '[data-associated-products="add-all"]', function () {
                var productElements, addAllButton,
                    availableProductListTabsContainer,
                    availableProductListContainer,
                    filterAvailableInput;

                addAllButton = $(this);

                if (addAllButton.data('process')) {
                    return;
                }

                filterAvailableInput = editor.find('[data-associated-products="filter-available"]');

                availableProductListTabsContainer = getProductListContainer(filterAvailableInput);
                availableProductListContainer = getActiveProductListContainer(availableProductListTabsContainer);

                productElements = availableProductListContainer.find('[data-associated-products="product-element"]');

                productElements.each(function () {
                    var productElement, productId;

                    productElement = $(this).eq(0);
                    productId = productElement.data('productId');

                    addProductId(productId, currentProductsList);
                });

                addAllButton.data('process', true);
                $.when(
                    filterSelectedHandler(),
                    filterAvailableHandler()
                ).done(function () {
                    addAllButton.data('process', false);
                });
            });

            editor.on('click', '[data-associated-products="remove-all"]', function () {
                var removeAllButton, productElements,
                    filterAvailableInput, filterSelectedInput,
                    availableProductListContainer;

                removeAllButton = $(this);

                if (removeAllButton.data('process')) {
                    return;
                }

                filterAvailableInput = editor.find('[data-associated-products="filter-available"]');
                filterSelectedInput = editor.find('[data-associated-products="filter-selected"]');

                availableProductListContainer = getProductListContainer(filterAvailableInput);

                if (!isFilterEmpty(filterSelectedInput)) {
                    productElements = currentProductsList.find('[data-associated-products="product-element"]');

                    productElements.each(function () {
                        var productElement, productId;

                        productElement = $(this).eq(0);
                        productId = productElement.data('productId');

                        removeProductId(productId, currentProductsList);
                    });

                } else {
                    resetSelectedProductIds(currentProductsList);
                }

                removeAllButton.data('process', true);
                $.when(
                  filterSelectedHandler(),
                  filterAvailableHandler()
                ).done(function () {
                    removeAllButton.data('process', false);
                    markAllTabsAsDirty(availableProductListContainer);
                });
            });

            currentProductsList.sortable({handle: '[data-associated-products="sortable-handler"]'});
        });
    };

    $(function () {
        associatedProductEditorsInit();
    });
})(jQuery);

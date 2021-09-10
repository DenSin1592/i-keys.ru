(function ($) {
    $(function () {

        // Order items (with popup window)
        (function () {
            var orderItemsContainer = $('#order-items-container');
            var totalPriceContainer = $('#total-price-container');

            var popupContainer = $('#popup-order-items');
            var headerContainer = popupContainer.find('[data-element-list="header"]');
            var availableListContainer = popupContainer.find('[data-element-list="available"]');
            var selectedListContainer = popupContainer.find('[data-element-list="selected"]');
            var categoryTreeContainer = popupContainer.find('#category-tree-container');

            $(document).on('click', '#popup-order-items [data-action="get-products"]', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                var self = $(this);

                if (!self.hasClass('active')) {
                    if (!$(document).data('block')) {
                        $(document).data('block', true);

                        availableListContainer.addClass('wait');
                        popupContainer.find('.toggleable').removeClass('active');
                        self.addClass('active');

                        $.ajax({
                            url: self.data('url'),
                            type: self.data('method'),
                            success: function (response) {
                                $(document).data('block', false);

                                availableListContainer.removeClass('wait');
                                availableListContainer.html(response['products']);

                                if (self.data('itemType') !== 'catalog-category') {
                                    headerContainer.hide();
                                } else {
                                    headerContainer.show();
                                }
                            }
                        });
                    }
                }
            });

            $(document).on('click', '#popup-order-items button.add[data-item-type="product"]', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                var self = $(this);

                var availableRowElement = availableListContainer.find('[data-element-list="element"]').has(self);
                var productId = parseInt(availableRowElement.data('product-id'), 10);
                var count = parseInt(availableRowElement.find('[data-count]').val(), 10);
                if (isNaN(count)) {
                    count = 1;
                }

                var selectedRowElement = selectedListContainer.find('[data-product-id="' + productId + '"]');

                var currentCount = parseInt(selectedRowElement.data('count'), 10);
                if (isNaN(currentCount)) {
                    currentCount = 0;
                }

                count = count + currentCount;

                if (count >= 1) {

                    if (!$(document).data('block')) {
                        $(document).data('block', true);

                        $.ajax({
                            url: self.data('url'),
                            type: self.data('method'),
                            data: {count: count},
                            success: function (response) {
                                $(document).data('block', false);

                                var element = response['added_product'];
                                if (selectedRowElement.length > 0) {
                                    selectedRowElement.replaceWith(element);
                                } else {
                                    selectedListContainer.append(element);
                                }
                            }
                        });
                    }
                }
            });

            $(document).on('click', '#popup-order-items button.delete', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                var self = $(this);
                popupContainer.find('[data-element-list="selected"] .added-item').has(self).remove();
            });

            $(document).on('click', '#popup-order-items button.save', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                var self = $(this);

                var addedProductElements = selectedListContainer.find('[data-item-type="product"]');
                var addedServiceElements = selectedListContainer.find('[data-item-type="service"]');

                popupContainer.find('.save-wait').show();

                var getAjaxData = function () {
                    var ajaxData = [];

                    // Fill ajax data for added product.
                    $.each(addedProductElements, function (i, v) {
                        v = $(v);

                        var fieldName = 'append_products';

                        ajaxData.push({name: fieldName + '[' + i + '][product_id]', value: v.data('product-id')});
                        ajaxData.push({name: fieldName + '[' + i + '][count]', value: v.data('count')});
                    });

                    // Fill ajax data for added services or others.
                    $.each(addedServiceElements, function (i, v) {
                        v = $(v);

                        var fieldName = 'append_services';
                        ajaxData.push({name: fieldName + '[' + i + '][name]', value: v.data('name')});
                    });

                    // Get data for existed order items.
                    var orderItemsData = orderItemsContainer.find('input').serializeArray();

                    ajaxData = $.merge(ajaxData, orderItemsData);

                    return ajaxData;
                };

                $.ajax({
                    url: self.data('url'),
                    type: self.data('method'),
                    data: getAjaxData(),
                    success: function (response) {
                        selectedListContainer.children().remove();

                        popupContainer.find('.save-wait').hide();
                        popupContainer.find('[data-dismiss]').click();

                        orderItemsContainer.html(response['order_items_elements']);

                        var totalPriceWrapper = totalPriceContainer
                            .find('[data-price="total"]');

                        totalPriceWrapper.html(response['total_price_element']);

                        removeHighlighted();
                    }
                });
            });

            $(document).on('click', '#popup-order-items [data-action="get-service"]', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                var self = $(this);

                if (!self.hasClass('active')) {
                    if (!$(document).data('block')) {
                        $(document).data('block', true);

                        availableListContainer.addClass('wait');
                        popupContainer.find('.toggleable').removeClass('active');
                        self.addClass('active');

                        $.ajax({
                            url: self.data('url'),
                            type: self.data('method'),
                            success: function (response) {
                                $(document).data('block', false);

                                availableListContainer.removeClass('wait');
                                availableListContainer.html(response['service_block']);
                                headerContainer.hide();
                            }
                        });
                    }
                }
            });

            $(document).on('click', '#popup-order-items button.add[data-item-type="service"]', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                var self = $(this);

                var availableRowElement = availableListContainer.find('[data-element-list="element"]').has(self);
                var name = $.trim(availableRowElement.find('input[data-name]').val());

                var selectedRowElement = selectedListContainer.find('[data-name="' + name + '"]');
                var count = selectedRowElement.length;

                if (name !== '' && count === 0) {
                    if (!$(document).data('block')) {
                        $(document).data('block', true);
                        $.ajax({
                            url: self.data('url'),
                            type: self.data('method'),
                            data: {name: name},
                            success: function (responce) {
                                $(document).data('block', false);

                                var element = responce['added_service'];
                                selectedListContainer.append(element);
                            }
                        });
                    }
                }
            });

            var addHighlighted = function (element) {
                $(element).addClass('highlighted');
            };

            var removeHighlighted = function () {
                var highlighted = $(document).find('form .highlighted');

                $.each(highlighted, function () {
                    $(this).removeClass('highlighted', 1000);
                });
            };

            var updatePrices = function (currentRowElement) {

                var previousAjaxRequest = $(document).data('previousAjaxRequest');
                if (previousAjaxRequest) {
                    previousAjaxRequest.abort();
                    $(document).data('block', false);
                }

                clearTimeout($(document).data('timeoutID'));
                var timeoutID = setTimeout(function () {

                    var ajaxData = orderItemsContainer.find('input').serializeArray();

                    if (!!currentRowElement) {
                        ajaxData.push({name: 'current_order_item_id', value: currentRowElement.data('orderItemId')});
                    }

                    if (!$(document).data('block')) {
                        $(document).data('block', true);

                        var ajaxRequest = $.ajax({
                            url: orderItemsContainer.data('url'),
                            type: orderItemsContainer.data('method'),
                            data: ajaxData,
                            success: function (response) {
                                $(document).data('block', false);

                                if (!!currentRowElement) {
                                    currentRowElement
                                        .find('[data-price="summary"]')
                                        .replaceWith(response['summary_price_element']);
                                }

                                var totalPriceWrapper = totalPriceContainer
                                    .find('[data-price="total"]');

                                totalPriceWrapper.html(response['total_price_element']);

                                addHighlighted(totalPriceWrapper.find('[data-price="total"]'));
                                removeHighlighted();
                            }
                        });

                        $(document).data('previousAjaxRequest', ajaxRequest)
                    }
                }, 10);
                $(document).data('timeoutID', timeoutID);
            };

            orderItemsContainer.on('click', '.order-item a.delete', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                var self = $(this);

                var currentRowElement = orderItemsContainer.find('.order-item').has(self);

                var productId = currentRowElement.data('product-id');
                var name = currentRowElement.data('name');

                if (confirm(self.data('confirm'))) {
                    var orderItemElement = orderItemsContainer.find('.order-item').has(self);
                    var orderItemErrors = orderItemElement.next('.validation-errors');

                    orderItemElement.remove();
                    orderItemErrors.remove();

                    var filterCallback = function () {
                        var v = $(this);

                        switch (v.data('item-type')) {
                            case 'product':
                                return v.data('product-id') == productId;
                            case 'other':
                                return v.data('name') == name;

                            default:
                                return false
                        }
                    };
                    popupContainer
                        .find('[data-element-list="selected"] .added-item')
                        .filter(filterCallback)
                        .first()
                        .remove();

                    updatePrices();

                }
            });

            orderItemsContainer.on('keyup', 'input[name*="count"], input[name*="price"]', function (e) {
                e.preventDefault();

                if (e.keyCode === 13) {
                    return;
                }

                var currentRowElement = orderItemsContainer.find('tr').has(this);
                updatePrices(currentRowElement);
            });


            popupContainer.on('shown.bs.modal', function () {
                if (!categoryTreeContainer.data('loaded')) {
                    if (!$(document).data('block')) {
                        $(document).data('block', true);
                        categoryTreeContainer.addClass('wait');

                        $.ajax({
                            url: categoryTreeContainer.data('url'),
                            type: 'get',
                            success: function (response) {
                                $(document).data('block', false);
                                categoryTreeContainer.data('loaded', true);
                                categoryTreeContainer.removeClass('wait');
                                categoryTreeContainer.html(response['category_tree'])
                            }
                        })
                    }
                }
            })
        })();

        // Show/hide delivery related fields
        (function () {
            var orderForm = $('form#order-form');
            if (orderForm.length > 0) {
                var toggleDeliveryInfoRelatedContainer = function (selectInput) {
                    if (selectInput.length === 0) {
                        return;
                    }

                    var elementContainer = orderForm.find('#delivery-address');
                    var allowedInputs = elementContainer.find('input,select');

                    if (selectInput.val() !== '' && $.inArray(selectInput.val(), selectInput.data('withAddress')) === -1) {
                        elementContainer.hide();
                        allowedInputs.prop('disabled', true);
                    } else {
                        elementContainer.show();
                        allowedInputs.prop('disabled', false);
                    }
                };

                toggleDeliveryInfoRelatedContainer(orderForm.find('select#delivery_method'));
                orderForm.on('change', 'select#delivery_method', function () {
                    toggleDeliveryInfoRelatedContainer($(this));
                });
            }
        })();

        // Send email with psbank payment link for order
        (function () {
            $(document).on('click', '[data-action="orders.send-psbank-payment-link"]', function (e) {
                e.preventDefault();

                var self = $(this);

                if (confirm('Вы уверены, что хотите отправить письмо?')) {
                    if (!self.data('process')) {
                        self.data('process', true);

                        self.addClass('wait');
                        $.ajax({
                            cache: false,
                            url: $(this).data('url'),
                            type: $(this).data('method'),

                            success: function (response) {
                                self.data('process', false);
                                self.removeClass('wait');

                                if (response['status'] == 'success') {
                                    var paymentLinkSentInfoBlock = $('#psbank_payment_link_sent_info');
                                    if (!!response['sent_link_info_block'] && paymentLinkSentInfoBlock.length === 1) {
                                        paymentLinkSentInfoBlock.replaceWith(response['sent_link_info_block']);
                                    }
                                    alert('Письмо отправлено.');
                                }  else {
                                    alert('Произошла ошибка при отправке письма.');
                                }
                            }
                        });
                    }
                }
            });
        })();
    });
})(jQuery);

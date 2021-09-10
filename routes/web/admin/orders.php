<?php
Route::prefix('orders/items')
    ->name('orders.items.')
    ->namespace('Orders')
    ->group(
        function () {
            Route::post('refresh-prices', 'OrderItemsController@refreshPrices')->name('refresh-prices');
            Route::post('save', 'OrderItemsController@save')->name('save');
            Route::get('load-category-tree', 'OrderItemsController@loadCategoryTree')->name('load-category-tree');

            Route::prefix('products')->name('products.')->group(
                function () {
                    Route::post('add/{productId}', 'OrderItemsController@addProduct')->name('add');
                    Route::get('list/{categoryId}', 'OrderItemsController@productList')->name('list');
                }
            );
            Route::prefix('services')->name('services.')->group(
                function () {
                    Route::post('add', 'OrderItemsController@addService')->name('add');
                    Route::get('new', 'OrderItemsController@newService')->name('new');
                }
            );
        }
    );

Route::resource('orders', 'OrdersController')->except(['show']);

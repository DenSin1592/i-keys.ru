<?php
// Catalog, category page and product page
Route::namespace('Catalog')
    ->group(
        function () {
            Route::get('catalog/{categoryQuery}', 'CatalogController@showCategory')
                ->where('categoryQuery', '.+')
                ->name('category');
            /*Route::get('product/{id}', 'ProductsController@show')->name('product')
                ->where('id', '[1-9]\d*');*/
        }
    );

// Filter proxy
//Route::get('filter-proxy', 'FilterProxyController@redirectToFilterUrl')->name('filter_proxy');

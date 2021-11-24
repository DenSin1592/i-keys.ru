<?php
// Catalog, category page and product page
Route::namespace('Catalog')
    ->group(
       static function () {


            Route::get('catalog/{categoryQuery}', 'CatalogController@showCategory')
                ->where('categoryQuery', '.+')
                ->name('category');


           Route::get('types/{url}', 'ProductTypePagesController@showPage')
               ->where('url', '.+')
               ->name('product_types_page');


           Route::get('filter-proxy', 'FilterProxyController@redirectToFilterUrl')
               ->name('filter-proxy');


            Route::get('product/{id}', 'ProductsController@show')
                ->where('id', '[1-9]\d*')
                ->name('product');








        }
    );


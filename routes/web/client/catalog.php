<?php
// Catalog, category page and product page
Route::namespace('Catalog')
    ->group(
       static function () {

           Route::get('catalog/{url}', 'CatalogProxyController')->name('catalog')->where('url', '.*');

           Route::get('types/{url}', 'ProductTypePagesController@showPage')
               ->where('url', '.+')
               ->name('product_types_page');

           Route::get('filter-proxy', 'FilterProxyController@redirectToFilterUrl')
               ->name('filter-proxy');

           Route::post('change-product-card','CatalogController@getNewProductCard');
        }
    );


<?php
// Products
Route::prefix('categories/{categories}/products')->name('products.')->group(
    function () {
        Route::put('toggle/{id}/{attribute}', 'ProductsController@toggleAttribute')->name('toggle-attribute');
        Route::put('update-positions', 'ProductsController@updatePositions')->name('update-positions');
        Route::get('images/create', 'Products\ImagesController@create')->name('images.create');
        Route::get('attributes/{products?}', 'Products\AttributesController@show')->name('attributes.show');
    }
);

Route::resource('categories.products', 'ProductsController')->except(['show'])->names(
    [
        'index' => 'products.index',
        'create' => 'products.create',
        'edit' => 'products.edit',
        'store' => 'products.store',
        'update' => 'products.update',
        'destroy' => 'products.destroy',
    ]
);

Route::namespace('Products')
    ->prefix('associated-products')
    ->name('associated-products.')
    ->group(
        function () {
            Route::post('available-products/{fieldGroup}/{productId?}', 'AssociatedProductsController@availableProducts')
                ->where('productId', '[1-9]\d*')
                ->name('available-products');
            Route::post('new-associations/{fieldGroup}', 'AssociatedProductsController@newAssociations')
                ->name('new-associations');
            Route::post('filter-available/{productId?}', 'AssociatedProductsController@filterAvailable')
                ->name('filter-available');
            Route::post('filter-selected/{productId?}', 'AssociatedProductsController@filterSelected')
                ->name('filter-selected');
        }
    );

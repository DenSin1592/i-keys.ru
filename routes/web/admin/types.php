<?php

// Types
Route::prefix('product-type-pages')
    ->name('product-type-pages.')
    ->group(
        function () {
            Route::put('toggle/{id}/{attribute}', 'ProductTypePagesController@toggleAttribute')
                ->name('toggle-attribute');
            Route::put('update-positions', 'ProductTypePagesController@updatePositions')
                ->name('update-positions');
        }
    );

Route::resource('product-type-pages', 'ProductTypePagesController')->except(['show']);

Route::prefix('product-type-pages/products')
    ->name('product-type-pages.products.')
    ->namespace('ProductTypePages')
    ->group(
        function () {
            Route::get('association-block/{productId}/{type}/{productTypePageId?}', 'Products@getAssociationBlock')
                ->name('association-block');
            Route::get('filtered-products/{productTypePageId?}', 'Products@getFilteredProducts')
                ->name('filtered-products');
            Route::get('manual-tree/{productTypePageId?}', 'Products@getManualTree')
                ->name('manual-tree');
            Route::get('manual-subtree/{categoryId}/{productTypePageId?}', 'Products@getManualSubTree')
                ->name('manual-subtree');
        }
    );

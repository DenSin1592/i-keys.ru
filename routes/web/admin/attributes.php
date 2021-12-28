<?php

// Attributes

Route::prefix('attributes')->name('attributes.')->group(function () {
    Route::put('update-positions', 'AttributesController@updatePositions')->name('update-positions');
    Route::get('allowed-values/create/{id?}', 'Attributes\AllowedValuesController@create')
        ->name('allowed-values.create');
    Route::put('toggle/{id}/{attribute}', 'AttributesController@toggleAttribute')->name('toggle-attribute');
    Route::get('available', 'Attributes\CategoriesController@available')
        ->name('categories.available');
    Route::get('rebuild-current', 'Attributes\CategoriesController@rebuildCurrent')
        ->name('categories.rebuild-current');
});

Route::resource('attributes', 'AttributesController')->except(['show'])->names([
    'index' => 'attributes.index',
    'create' => 'attributes.create',
    'edit' => 'attributes.edit',
    'store' => 'attributes.store',
    'update' => 'attributes.update',
    'destroy' => 'attributes.destroy',
]);

Route::resource('products-series', 'Attributes\ProductsSeriesController');


Route::prefix('products-series/services')->name('products-series.services.')->group(function () {
    Route::get('available', 'Attributes\Series\ServicesController@available')
        ->name('available');

    Route::get('rebuild-current', 'Attributes\Series\ServicesController@rebuildCurrent')
        ->name('rebuild-current');
});

<?php

// Attributes

Route::prefix('attributes')->name('attributes.')->group(function () {
    Route::put('update-positions', 'AttributesController@updatePositions')->name('update-positions');
    Route::get('type-data/show/{id?}', 'Attributes\TypesController@show')->name('type-data.show');
    Route::get('allowed-values/create/{id?}', 'Attributes\AllowedValuesController@create')
        ->name('allowed-values.create');
});

Route::resource('categories.attributes', 'AttributesController')->except(['show'])->names([
    'index' => 'attributes.index',
    'create' => 'attributes.create',
    'edit' => 'attributes.edit',
    'store' => 'attributes.store',
    'update' => 'attributes.update',
    'destroy' => 'attributes.destroy',
]);

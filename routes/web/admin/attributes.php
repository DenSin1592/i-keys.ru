<?php

// Attributes

Route::prefix('attributes')->name('attributes.')->group(function () {
    Route::put('toggle/{id}/{attribute}', 'AttributesController@toggleAttribute')->name('toggle-attribute');
    Route::put('update-positions', 'AttributesController@updatePositions')->name('update-positions');
    Route::get('type-data/show/{id?}', 'Attributes\TypesController@show')->name('type-data.show');
});

Route::resource('attributes', 'AttributesController')->except(['show']);

// Allowed values for attributes

Route::prefix('attributes/{attrId}/allowed-values')->name('attributes.allowed-values.')->group(function () {
    Route::put('toggle/{id}/{attribute}', 'Attributes\AllowedValuesController@toggleAttribute')
        ->name('toggle-attribute');
    Route::put('update-positions', 'Attributes\AllowedValuesController@updatePositions')
        ->name('update-positions');
});

Route::resource('attributes.allowed-values', 'Attributes\AllowedValuesController')->except(['show'])->names([
    'index' => 'attributes.allowed-values.index',
    'create' => 'attributes.allowed-values.create',
    'edit' => 'attributes.allowed-values.edit',
    'store' => 'attributes.allowed-values.store',
    'update' => 'attributes.allowed-values.update',
    'destroy' => 'attributes.allowed-values.destroy',
]);

<?php

// Categories
Route::prefix('categories')->name('categories.')->group(function () {
    Route::put('toggle/{id}/{attribute}', 'CategoriesController@toggleAttribute')->name('toggle-attribute');
    Route::put('update-positions', 'CategoriesController@updatePositions')->name('update-positions');
    Route::get('create/{parentId?}', 'CategoriesController@create')->name('create');
});
Route::resource('categories', 'CategoriesController')->except(['create']);

// Products
Route::prefix('categories/{categories}/products')->name('products.')->group(function () {
    Route::put('toggle/{id}/{attribute}', 'ProductsController@toggleAttribute')->name('toggle-attribute');
    Route::put('update-positions', 'ProductsController@updatePositions')->name('update-positions');
});
Route::resource('categories.products', 'ProductsController')->except(['show', 'create', 'store'])->names([
    'index' => 'products.index',
    'edit' => 'products.edit',
    'update' => 'products.update',
    'destroy' => 'products.destroy',
]);

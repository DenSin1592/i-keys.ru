<?php

// Categories
Route::prefix('categories')->name('categories.')->group(function () {
    Route::put('toggle/{id}/{attribute}', 'CategoriesController@toggleAttribute')->name('toggle-attribute');
    Route::put('update-positions', 'CategoriesController@updatePositions')->name('update-positions');
    Route::get('create/{parentId?}', 'CategoriesController@create')->name('create');
    Route::post('store/{parentId?}', 'CategoriesController@store')->name('store');
});
Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('reload-list/{categoryId?}', 'CategoriesController@reloadList')->name('reload-list');
});
Route::resource('categories', 'CategoriesController')->except(['create', 'store']);

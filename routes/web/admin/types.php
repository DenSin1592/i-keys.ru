<?php

// Types

Route::prefix('types')->name('types.')->group(function () {
    Route::put('toggle/{id}/{attribute}', 'TypesController@toggleAttribute')->name('toggle-attribute');
    Route::put('update-positions', 'TypesController@updatePositions')->name('update-positions');
    Route::get('create/{parentId?}', 'TypesController@create')->name('create');
});
Route::resource('types', 'TypesController')->except(['create']);

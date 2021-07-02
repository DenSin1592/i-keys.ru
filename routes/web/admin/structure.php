<?php

Route::prefix('structure')->name('structure.')->group(function () {
    Route::put('toggle/{id}/{attribute}', 'StructureController@toggleAttribute')->name('toggle-attribute');
    Route::put('update-positions', 'StructureController@updatePositions')->name('update-positions');
});

Route::get('/', 'StructureController@index')->name('home');
Route::resource('structure', 'StructureController')->except(['show']);
Route::resource('home-pages', 'HomePagesController')->only(['edit', 'update']);
Route::resource('text-pages', 'TextPagesController')->only(['edit', 'update']);
Route::resource('meta-pages', 'MetaPagesController')->only(['edit', 'update']);

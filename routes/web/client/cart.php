<?php

Route::prefix('cart')->name('cart.')->group(function () {
    Route::post('add', 'CartController@add')->name('add');
    Route::delete('remove', 'CartController@remove')->name('remove');
//    Route::put('update', 'CartController@update')->name('update');
    Route::get('/update-summary', 'CartController@updateSummary')->name('update-summary');
    Route::get('/', 'CartController@show')->name('show');
});

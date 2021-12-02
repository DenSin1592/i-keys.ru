<?php

Route::prefix('cart')->name('cart.')->group(function () {
    Route::post('add', 'CartController@add')->name('add');
//    Route::post('add-child', 'CartController@addChild')->name('add.child');
//    Route::delete('remove', 'CartController@remove')->name('remove');
//    Route::delete('remove-child', 'CartController@removeChild')->name('remove-child');
//    Route::put('update', 'CartController@update')->name('update');
//    Route::put('update-child', 'CartController@updateChild')->name('update-child');
    Route::get('/', 'CartController@show')->name('show');
});

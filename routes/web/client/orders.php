<?php
Route::post('order/fast', 'OrdersController@storeFast')->name('order.fast.store');
Route::post('order/store', 'OrdersController@store')->name('order.store');

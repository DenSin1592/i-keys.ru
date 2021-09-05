<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Admin routes
Route::prefix('cc')->name('cc.')->namespace('Admin')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', 'SessionsController@create')->name('login');
        Route::post('login', 'SessionsController@store')->name('login');
    });

    Route::middleware('auth')->group(function () {
        Route::delete('logout', 'SessionsController@destroy')->name('logout');

        require 'web/admin/access_control.php';
        require 'web/admin/structure.php';
        require 'web/admin/settings.php';
        require 'web/admin/catalog.php';
        require 'web/admin/attributes.php';
        require 'web/admin/types.php';
        require 'web/admin/product.php';
        require 'web/admin/reviews.php';

        // all others should show 404 page for admin
        Route::any('/{url}', 'NotFoundController')->where('url', '.*');
    });
});


// Client routes
Route::namespace('Client')->group(function () {
    Route::get('/', 'HomeController')->name('home');
    Route::get('/{url}', 'HomeController')->name('dynamic_page')->where('url', '.*');
});

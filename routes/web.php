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
        Route::post('login', 'SessionsController@store');
    });

    Route::middleware('auth')->group(function () {
        Route::delete('logout', 'SessionsController@destroy')->name('logout');

        require_once 'web/admin/access_control.php';
        require_once 'web/admin/structure.php';
        require_once 'web/admin/settings.php';
        require_once 'web/admin/catalog.php';
        require_once 'web/admin/attributes.php';
        require_once 'web/admin/types.php';
        require_once 'web/admin/product.php';
        require_once 'web/admin/reviews.php';
        require_once 'web/admin/orders.php';
        require_once 'web/admin/exchange.php';
        require_once 'web/admin/subdomains.php';
        require_once 'web/admin/services.php';

        // all others should show 404 page for admin
        Route::any('/{url}', 'NotFoundController')->where('url', '.*');
    });
});


// Client routes
Route::namespace('Client')->group(function () {

    Route::get('/', 'HomeController')->name('home');
    Route::get('/services', 'ServicesController@index')->name('services');
    Route::get('/services/{alias}', 'ServicesController@show')->name('service.show');
    Route::get('/search', 'SearchController@show')->name('search');

    require_once 'web/client/catalog.php';
    require_once 'web/client/cart.php';
    require_once 'web/client/orders.php';
});

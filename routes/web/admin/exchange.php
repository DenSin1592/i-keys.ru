<?php

Route::prefix('exchange')->name('exchange.')->group(
    function () {
        Route::get('/', 'ExchangeController@show')->name('show');

        Route::prefix('import')->name('import.')->group(
            function () {
                Route::get('status', 'ExchangeController@importStatus')->name('status');
                Route::get('logs', 'ExchangeController@importLogs')->name('logs');

            }
        );

        Route::prefix('export')->name('export.')->group(
            function () {
                Route::get('status', 'ExchangeController@exportStatus')->name('status');
                Route::get('logs', 'ExchangeController@exportLogs')->name('logs');
            }
        );
    }
);
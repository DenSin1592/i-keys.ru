<?php

// Settings

Route::name('settings.')->group(function () {
    Route::get('settings', 'SettingsController@edit')->name('edit');
    Route::put('settings', 'SettingsController@update')->name('update');
});

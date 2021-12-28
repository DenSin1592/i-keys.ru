<?php

// Услуги

Route::resource('services', 'ServicesController')->except(['show'])->names([
    'index' => 'services.index',
    'create' => 'services.create',
    'edit' => 'services.edit',
    'store' => 'services.store',
    'update' => 'services.update',
    'destroy' => 'services.destroy',
]);

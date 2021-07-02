<?php

// Admin users

Route::resource('admin-users', 'AdminUsersController', ['except' => 'show']);

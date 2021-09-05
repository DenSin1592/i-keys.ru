<?php

Route::prefix('reviews')->name('reviews.')->group(function () {
    Route::put('toggle/{id}/{attribute}', 'ReviewsController@toggleAttribute')->name('toggle-attribute');
    Route::get('get_searched_review_product_values', 'ReviewsController@getSearchedReviewProductValues')->name('get-searched-review-product-values');
});

Route::resource('reviews', 'ReviewsController')->except(['show']);

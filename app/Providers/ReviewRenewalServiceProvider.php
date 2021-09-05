<?php namespace App\Providers;

use App\Services\ReviewRenewal\Adapter\ReviewRenewalMailer;
use App\Services\ReviewRenewal\Adapter\ReviewStorageAdapter;
use App\Services\ReviewRenewal\ReviewRenewal;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class ReviewRenewalServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('review_renewal', function (Application $app) {
            return new ReviewRenewal(
                new ReviewStorageAdapter(
                    $app->make('App\Services\Repositories\Review\EloquentReviewRepository'),
                    $app->make('App\Services\Repositories\ReviewDateChange\EloquentReviewDateChangeRepository')
                ),
                new ReviewRenewalMailer(
                    \Arr::get($_ENV, 'MAIL_REVIEW_RENEWAL_REPORT', 'diol.tech.info@gmail.com'),
                    $app->make('App\Services\Repositories\ReviewDateChange\EloquentReviewDateChangeRepository')
                )
            );
        });
    }
}

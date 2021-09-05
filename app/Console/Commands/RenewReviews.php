<?php namespace App\Console\Commands;

use App\Services\ReviewRenewal\ReviewRenewal;
use Illuminate\Console\Command;


class RenewReviews extends Command
{
    protected $name = 'app:renew-reviews';
    protected $description = 'Renew reviews.';

    public function handle()
    {
        /** @var ReviewRenewal $reviewRenewal */
        $reviewRenewal = \App::make('review_renewal');
        $reviewRenewal->renewAll();
    }
}

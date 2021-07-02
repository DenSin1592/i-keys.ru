<?php

namespace App\Providers;

use Laravel\Telescope\EntryType;
use Laravel\Telescope\Telescope;
use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Telescope::night();

        $this->hideSensitiveRequestDetails();

        Telescope::filter(function (IncomingEntry $entry) {
            if ($this->app->isLocal()) {
                return true;
            }

            return $entry->isReportableException() ||
                $entry->isFailedRequest() ||
                $entry->isFailedJob() ||
                $entry->isScheduledTask() ||
                $entry->hasMonitoredTag();
        });

        Telescope::tag(function (IncomingEntry $entry) {
            switch ($entry->type) {
                case EntryType::REQUEST:
                    return [
                        date('d.m.Y H:i'),
                        date('d.m.Y H:i:s'),
                        request()->server('HTTP_REFERER'),
                        $entry->content['uri'],
                        url($entry->content['uri']),
                        $entry->content['method'],
                        'status:'.$entry->content['response_status'],
                    ];

                case EntryType::MODEL:
                    return [
                        date('d.m.Y H:i'),
                        date('d.m.Y H:i:s'),
                        $entry->content['action'],
                    ];

                case EntryType::MAIL:
                    return [
                        date('d.m.Y H:i'),
                        date('d.m.Y H:i:s'),
                        $entry->content['subject'],
                    ];

                default:
                    return [];
            }
        });
    }

    /**
     * Prevent sensitive request details from being logged by Telescope.
     *
     * @return void
     */
    protected function hideSensitiveRequestDetails()
    {
        if ($this->app->isLocal()) {
            return;
        }

        Telescope::hideRequestParameters(['_token']);

        Telescope::hideRequestHeaders([
            'cookie',
            'x-csrf-token',
            'x-xsrf-token',
        ]);
    }

    /**
     * Register the Telescope gate.
     *
     * This gate determines who can access Telescope in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewTelescope', function () {
            return false;
        });
    }
}

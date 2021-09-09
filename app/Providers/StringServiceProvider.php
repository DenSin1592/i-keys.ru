<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class StringServiceProvider
 * @package  App\Services\Providers
 */
class StringServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('transliterator.russian', function () {
            return \Transliterator::create('Russian-Latin/BGN');
        });
    }

    public function boot()
    {
        $this->initStringMacros();
    }

    private function initStringMacros()
    {
        \Str::macro(
            'transliterate',
            function ($str) {
                return app('transliterator.russian')->transliterate($str);
            }
        );

        \Str::macro(
            'alias',
            function ($str) {
                $str = \Str::transliterate($str);
                $str = mb_strtolower($str);

                $str = preg_replace('/[()]/', '', $str);
                $str = preg_replace('/[^a-z0-9_]/', '-', $str);
                $str = preg_replace('/-(-)+/', '-', $str);
                $str = preg_replace('/(^-|-$)/', '', $str);

                return $str;
            }
        );

        \Str::macro(
            'highlight',
            function ($text, $words) {
                $words = trim($words);

                if (empty($words)) {
                    return $text;
                }

                $words = preg_quote($words);
                $highlighted = preg_replace("/($words)/ui", "<span class=\"highlight\">$1</span>", $text);

                return $highlighted;
            }
        );

        \Str::macro(
            'formatDate',
            function ($dateString, $format = 'Y-m-d') {
                return date($format, strtotime($dateString));
            }
        );
    }
}

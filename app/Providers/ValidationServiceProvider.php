<?php namespace App\Providers;

use App\Services\Validation\ValidationRules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

/**
 * Class ValidationServiceProvider
 * @package App\Services\Providers
 */
class ValidationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Validator::extend('subset', ValidationRules\Common::class . '@validateSubset');
        Validator::replacer('subset', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':variants', implode(', ', $parameters), $message);
        });


        Validator::extend('multi_key_exists', ValidationRules\Common::class . '@validateMultiKeyExists');


        Validator::extend('multi_exists', ValidationRules\Common::class . '@validateMultiExists');


        Validator::extend('phone', ValidationRules\Common::class . '@validatePhone');
        Validator::replacer('phone', function ($message) {
            return str_replace(':value', '', $message);
        });


        Validator::extend('email_list', ValidationRules\Common::class . '@validateEmailList');


        Validator::extend('more_than', ValidationRules\Common::class . '@validateMoreThan');
        Validator::replacer('more_than', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':value', $parameters[0], $message);
        });


        Validator::extend('unique_among', ValidationRules\Common::class . '@validateUniqueAmong');


        Validator::extend('regular_expression', ValidationRules\Redirects::class . '@validateRegularExpression');

        Validator::extend('local_or_remote_file', ValidationRules\File::class . '@validateLocalOrRemoteFile');
        Validator::replacer(
            'local_or_remote_file',
            function ($message, $attribute, $rule, $parameters) {
                return '';
            }
        );
    }
}

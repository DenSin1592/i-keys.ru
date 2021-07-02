<?php namespace App\Services\Validation\ValidationRules;

/**
 * Class Redirects
 * @package App\Services\Validation\ValidationRules
 */
class Redirects
{
    public function validateRegularExpression($attribute, $value, $parameters)
    {
        $hasErrors = false;

        set_error_handler(function () use (&$hasErrors) {
            $hasErrors = true;
        });

        preg_match("@{$value}@", '');

        restore_error_handler();

        return !$hasErrors && preg_last_error() === PREG_NO_ERROR;
    }
}

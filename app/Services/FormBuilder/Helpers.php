<?php namespace App\Services\FormBuilder;

use Illuminate\Support\ViewErrorBag;
use Arr;

/**
 * Class Helpers
 * Helpers for form builder.
 * @package App\Services\FormBuilder
 */
class Helpers
{
    /**
     * @var ViewErrorBag|null
     */
    private $errors;

    /**
     * Get name for label.
     *
     * @param $name
     * @param null $labelName
     * @return array|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function getLabelName($name, $labelName = null)
    {
        if (is_null($labelName)) {
            $labelName = trans("validation.attributes.{$name}");
        }

        return $labelName;
    }


    /**
     * Build options for form.
     *
     * @param $options
     * @return mixed
     */
    public function buildFormOptions($options)
    {
        if (\Arr::get($options, 'scrollable', true)) {
            unset($options['scrollable']);
            \Arr::set($options, 'class', 'scrollable-container' . ' ' . \Arr::get($options, 'class'));
        }

        return $options;
    }


    /**
     * Get block with field description for field.
     *
     * @param array $options
     * @return string
     */
    public function getFieldHintBlock(array $options)
    {
        if (!empty($options['hint'])) {
            $hintBlock = "<div class=\"field-hint-block\">{$options['hint']}</div>";
        } else {
            $hintBlock = '';
        }

        return $hintBlock;
    }


    /**
     * Add css class to options.
     *
     * @param array $options
     * @param $className
     * @return array
     */
    public function addClass(array $options, $className)
    {
        if (isset($options['class'])) {
            $options['class'] = $className . ' ' . $options['class'];
        } else {
            $options['class'] = $className;
        }

        return $options;
    }


    public function addAlertMessage(&$ret, ViewErrorBag $errors)
    {
        $alertClass = null;
        $alertMessage = null;

        if (null !== $errors && $errors->any()) {
            $alertMessage = \Session::get('alert_error') ?: trans('alerts.validation_error');
            \Session::forget('alert_error');
            $alertClass = 'alert-danger';

        } elseif (\Session::has('alert_success')) {
            $alertMessage = \Session::get('alert_success');
            \Session::forget('alert_success');
            $alertClass = 'alert-success';

        } elseif (\Session::has('alert_warning')) {
            $alertMessage = \Session::get('alert_warning');
            \Session::forget('alert_warning');
            $alertClass = 'alert-warning';
        }

        if (null !== $alertClass) {
            $ret .= <<<ALERT
<div class="alert {$alertClass}">
    {$alertMessage}
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div>
ALERT;
        }
    }

    public function setErrors(ViewErrorBag $errors): void
    {
        $this->errors = $errors;
    }

    public function getErrors(): ?ViewErrorBag
    {
        return $this->errors;
    }
}

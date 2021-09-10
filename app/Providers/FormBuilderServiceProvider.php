<?php namespace App\Providers;

use App\Services\FormBuilder\Helpers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\ViewErrorBag;
use Form;
use Arr;
use Str;

class FormBuilderServiceProvider extends ServiceProvider
{
    /**
     * Ext form data cache.
     * @var array
     */
    private $extFormData = [];

    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->app->singleton(Helpers::class);
    }

    public function boot()
    {
        $this->initTbFormWithErrors();
        $this->initTbModelWithErrors();
        $this->initTbResultFormOpen();
        $this->initTbFields();
        $this->initTbFormGroup();
        $this->initFieldBlocks();
        $this->initFormHelpers();
    }


    private function initTbFormWithErrors()
    {
        Form::macro(
            'tbFormWithErrorsOpen',
            function (ViewErrorBag $errors, $options) {
                $helpers = app(Helpers::class);
                $helpers->setErrors($errors);
                $ret = Form::open($helpers->buildFormOptions($options));
                $helpers->addAlertMessage($ret, $errors);

                return $ret;
            }
        );
    }

    private function initTbModelWithErrors()
    {
        Form::macro(
            'tbModelWithErrors',
            function ($model, ViewErrorBag $errors, $options) {
                $helpers = app(Helpers::class);
                $helpers->setErrors($errors);
                $ret = Form::model($model, $helpers->buildFormOptions($options));
                $helpers->addAlertMessage($ret, $errors);

                return $ret;
            }
        );
    }

    private function initTbResultFormOpen()
    {
        Form::macro(
            'tbRestfulFormOpen',
            function ($model, ViewErrorBag $errors, $baseRoute, $options = []) {
                $options['files'] = true;
                if (isset($model['id']) && !empty($model['id'])) {
                    $options['url'] = route($baseRoute . '.update', [$model['id']]);
                    $options['method'] = 'put';
                } else {
                    $options['url'] = route($baseRoute . '.store');
                    $options['method'] = 'post';
                }

                return Form::tbModelWithErrors($model, $errors, $options);
            }
        );
    }

    private function initTbFields()
    {
        Form::macro(
            'tbLabel',
            function ($name, $value = null, $options = []) {
                $helpers = app(Helpers::class);

                return Form::label($name, $value, $helpers->addClass($options, 'control-label')) .
                    $helpers->getFieldHintBlock($options);
            }
        );

        Form::macro(
            'tbText',
            function ($name, $value = null, $options = []) {
                return Form::text($name, $value, app(Helpers::class)->addClass($options, 'form-control'));
            }
        );

        Form::macro(
            'tbPassword',
            function ($name, $options = []) {
                return Form::password($name, app(Helpers::class)->addClass($options, 'form-control'));
            }
        );

        Form::macro(
            'tbSelect',
            function ($name, $list = [], $selected = null, $options = []) {
                $options = app(Helpers::class)->addClass($options, 'form-control input-sm half');
                $editLinkHtml = null;
                $editUrl = \Arr::get($options, 'edit_url');
                if ($editUrl) {
                    $editLinkHtml = \Html::link($editUrl, '', [
                        'title' => trans('validation.attributes.edit_variants'),
                        'target' => '_blank',
                        'class' => 'glyphicon glyphicon-pencil',
                        'style' => 'margin-left: 7px;',
                    ]);

                    unset($options['edit_url']);
                    $options['style'] = 'display: inline-block';

                    return '<div class="field-wrapper">'
                        . Form::select($name, $list, $selected, $options)
                        . $editLinkHtml
                        . '</div>';

                } else {
                    return Form::select($name, $list, $selected, $options);
                }
            }
        );

        Form::macro(
            'tbSelect2',
            function ($name, $list = [], $selected = null, $options = []) {
                $options['data-with-search'] = true;

                return Form::tbSelect(
                    $name,
                    $list,
                    $selected,
                    app(Helpers::class)->addClass($options, 'form-control input-sm half')
                );
            }
        );

        Form::macro(
            'tbTextarea',
            function ($name, $value = null, $options = []) {
                return Form::textarea($name, $value, app(Helpers::class)->addClass($options, 'form-control'));
            }
        );

        Form::macro(
            'tbTinymceTextarea',
            function ($name, $value = null, $options = []) {
                $options['data-tinymce'] = '';
                if (!isset($options['rows'])) {
                    $options['rows'] = 15;
                }

                return Form::textarea($name, $value, app(Helpers::class)->addClass($options, 'form-control'));
            }
        );

        Form::macro(
            'tbNumber',
            function ($name, $value = null, $options = []) {
                return Form::number($name, $value, app(Helpers::class)->addClass($options, 'form-control'));
            }
        );

        Form::macro(
            'tbStateCheckbox',
            function ($name, $fieldName, $checked = null, $options = []) {
                $hintBlock = app(Helpers::class)->getFieldHintBlock($options);

                return '<input type="hidden" name="' . $name . '" value="0" />' .
                    '<label class="checkbox-inline">' .
                    Form::checkbox($name, 1, $checked, $options) .
                    '<span class="bold">' . $fieldName . '</span>' .
                    '</label>' .
                    $hintBlock;
            }
        );

        Form::macro(
            'tbStateRadioButton',
            function ($name, $fieldName, $value = null, $checked = null, $options = []) {
                $hintBlock = app(Helpers::class)->getFieldHintBlock($options);

                return '<label class="radio-inline">' .
                    Form::radio($name, $value, $checked, $options) .
                    '<span class="bold">' . $fieldName . '</span>' .
                    '</label>' .
                    $hintBlock;
            }
        );
    }

    private function initTbFormGroup()
    {
        Form::macro(
            'tbFormGroupOpen',
            function ($name = null) {
                $this->extFormData['formGroupName'][] = $name;
                $classes = ['form-group'];
                $errors = app(Helpers::class)->getErrors();
                if ($errors && !is_null($name) && $errors->has($name)
                ) {
                    $classes[] = 'has-error';
                }

                return '<div class="' . implode(' ', $classes) . '">';
            }
        );

        Form::macro(
            'tbFormGroupClose',
            function () {
                $ret = '';
                $name = array_pop($this->extFormData['formGroupName']);
                $ret .= Form::tbFormFieldError($name);
                $ret .= '</div>';

                return $ret;
            }
        );

        Form::macro(
            'tbFormFieldError',
            function ($key) {
                $ret = '';
                $errors = app(Helpers::class)->getErrors();
                if ($errors && $errors->has($key)) {
                    $ret .= '<div class="validation-errors">'
                        . implode(
                            '<br />',
                            $errors->get($key)
                        )
                        . '</div>';
                }

                return $ret;
            }
        );
    }

    private function initFieldBlocks()
    {
        Form::macro(
            'tbTextBlock',
            function ($name, $labelName = null, $value = null, $options = []) {
                return
                    Form::tbFormGroupOpen($name) .
                    Form::tbLabel($name, app(Helpers::class)->getLabelName($name, $labelName)) .
                    Form::tbText($name, $value, $options) .
                    Form::tbFormGroupClose();
            }
        );

        Form::macro(
            'tbPasswordBlock',
            function ($name, $labelName = null) {
                return
                    Form::tbFormGroupOpen($name) .
                    Form::tbLabel($name, app(Helpers::class)->getLabelName($name, $labelName)) .
                    Form::tbPassword($name) .
                    Form::tbFormGroupClose();
            }
        );

        Form::macro(
            'tbCheckboxBlock',
            function ($name, $labelName = null, $checked = null, $options = []) {
                return
                    Form::tbFormGroupOpen($name) .
                    Form::tbStateCheckbox(
                        $name,
                        app(Helpers::class)->getLabelName($name, $labelName),
                        $checked,
                        $options
                    ) .
                    Form::tbFormGroupClose();
            }
        );

        Form::macro(
            'tbTextareaBlock',
            function ($name, $labelName = null, $value = null) {
                return
                    Form::tbFormGroupOpen($name) .
                    Form::tbLabel($name, app(Helpers::class)->getLabelName($name, $labelName)) .
                    Form::tbTextarea($name, $value) .
                    Form::tbFormGroupClose();
            }
        );

        Form::macro(
            'tbTinymceTextareaBlock',
            function ($name, $labelName = null, $value = null, $options = []) {
                return
                    Form::tbFormGroupOpen($name) .
                    Form::tbLabel($name, app(Helpers::class)->getLabelName($name, $labelName)) .
                    Form::tbTinymceTextarea($name, $value, $options) .
                    Form::tbFormGroupClose();
            }
        );

        Form::macro(
            'tbSelectBlock',
            function ($name, array $variants = [], $labelName = null, $value = null, $options = []) {
                return
                    Form::tbFormGroupOpen($name) .
                    Form::tbLabel($name, app(Helpers::class)->getLabelName($name, $labelName)) .
                    Form::tbSelect($name, $variants, $value, $options) .
                    Form::tbFormGroupClose();
            }
        );

        Form::macro(
            'tbSelect2Block',
            function ($name, array $variants = [], $labelName = null, $value = null, $options = []) {
                return
                    Form::tbFormGroupOpen($name) .
                    Form::tbLabel($name, app(Helpers::class)->getLabelName($name, $labelName)) .
                    Form::tbSelect2($name, $variants, $value, $options) .
                    Form::tbFormGroupClose();
            }
        );
    }

    public function initFormHelpers()
    {
        Form::macro('errorContains', function ($needles) {
            $contains = false;

            $errors = app(Helpers::class)->getErrors();
            if ($errors) {
                $contains = count(array_filter(array_keys($errors->getMessages()), function ($v) use ($needles) {
                        return Str::contains($v, $needles);
                    })) > 0;
            }

            return $contains;
        });
    }
}

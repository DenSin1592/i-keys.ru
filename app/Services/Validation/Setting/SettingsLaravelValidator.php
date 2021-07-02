<?php namespace App\Services\Validation\Setting;

use App\Services\Settings\SettingContainer;
use App\Services\Settings\SettingValue;
use App\Services\Validation\AbstractLaravelValidator;
use Arr;
use Illuminate\Validation\Factory as ValidatorFactory;

/**
 * Class SettingsLaravelValidator
 * @package App\Services\Validation\Setting
 */
class SettingsLaravelValidator extends AbstractLaravelValidator
{
    private $settingContainer;

    public function __construct(
        ValidatorFactory $validatorFactory,
        SettingContainer $settingContainer
    ) {
        parent::__construct($validatorFactory);
        $this->settingContainer = $settingContainer;
    }

    private function getSettingLaravelValidator($settingKey, $value)
    {
        switch ($this->settingContainer->getTypeBy($settingKey)) {
            case SettingValue::TYPE_REDIRECTS:
                $data = [];
                Arr::set($data, "setting.{$settingKey}", $value);

                $validator = $this->validatorFactory->make($data, []);

                $allRules = array_map(function ($v) {
                    return $v['rule'];
                }, $value);

                $validator->setRules(array_merge($validator->getRules(), [
                    "setting.{$settingKey}.*.rule" => [
                        'required',
                        'unique_among:' . implode(',', $allRules),
                        'regular_expression',
                    ],
                    "setting.{$settingKey}.*.url" => ['required']
                ]));

                $validator->setAttributeNames(array_merge($validator->customAttributes, [
                    "setting.{$settingKey}.*.rule" => trans('validation.attributes.rule'),
                    "setting.{$settingKey}.*.url" => trans('validation.attributes.url')
                ]));
                break;

            default:
                $validator = $this->validatorFactory->make(
                    [$settingKey => $value],
                    [$settingKey => $this->settingContainer->getRulesBy($settingKey)]
                );

                $validator->setAttributeNames([$settingKey => '']); // remove field key from error message
        }

        return $validator;
    }

    public function passes()
    {
        return $this->passesSettings();
    }

    public function passesSettings()
    {
        $settings = \Arr::get($this->data, 'setting', []);

        if (is_array($settings)) {
            $allPasses = true;
            foreach ($settings as $settingKey => $value) {
                $settingLaravelValidator = $this->getSettingLaravelValidator($settingKey, $value);
                $passes = $settingLaravelValidator->passes();

                if (!$passes) {
                    $messagesList = $settingLaravelValidator->messages()->toArray();

                    if ($this->settingContainer->getTypeBy($settingKey) === SettingValue::TYPE_REDIRECTS) {
                        foreach ($messagesList as $messageKey => $messages) {
                            $this->errors[$messageKey] = $messages;
                        }
                    } else {
                        $this->errors["setting.{$settingKey}"] = $messagesList[$settingKey];
                    }
                }

                $allPasses = $allPasses && $passes;
            }
        } else {
            $allPasses = false;
        }

        return $allPasses;
    }
}

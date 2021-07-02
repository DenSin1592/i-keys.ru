<?php namespace App\Services\DataProviders\SettingsForm;

use App\Services\Settings\SettingGetter;


/**
 * Class SettingsForm
 * @package App\Services\DataProviders\SettingsForm
 */
class SettingsForm
{
    /**
     * @var SettingGetter
     */
    private $settingGetter;

    public function __construct(
        SettingGetter $settingGetter
    ) {
        $this->settingGetter = $settingGetter;
    }

    public function provideData()
    {
        return [
            'group_list' => $this->settingGetter->groups(),
        ];
    }
}

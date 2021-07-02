<?php

namespace App\Services\Settings;

use App\Services\Repositories\Setting\EloquentSettingRepository;
use App\Services\Settings\Exception\NotFoundKeyException;

/**
 * Class Setting
 * @package Settings
 */
class SettingGetter
{
    /**
     * @var SettingContainer
     */
    private $settingContainer;

    /**
     * @var EloquentSettingRepository
     */
    private $settingRepository;

    /**
     * @var SettingValue[]
     */
    private $settings = [];

    public function __construct(SettingContainer $settingContainer, EloquentSettingRepository $settingRepository)
    {
        $this->settingContainer = $settingContainer;
        $this->settingRepository = $settingRepository;

        $this->fill();
    }

    /**
     * Fill settings values.
     *
     */
    private function fill(): void
    {
        foreach ($this->settingContainer->getSettingList() as $setting) {
            $this->settings[$setting->getKey()] = $setting;
        }

        foreach ($this->settingRepository->all() as $settingModel) {
            if (array_key_exists($settingModel->key, $this->settings)) {
                $setting = $this->settings[$settingModel->key];

                if ($setting->getType() === SettingValue::TYPE_REDIRECTS) {
                    $setting->setValue($settingModel->array_value);

                } else {
                    $setting->setValue($settingModel->value);
                }
            }
        }
    }

    /**
     * Get setting.
     *
     * @param string $key
     * @return string|array
     * @throws NotFoundKeyException
     */
    public function get(string $key)
    {
        if (!array_key_exists($key, $this->settings)) {
            throw new NotFoundKeyException("Key {$key} is not found.");
        }

        return $this->settings[$key]->getValue();
    }

    /**
     * @return SettingGroup[]
     */
    public function groups(): array
    {
        return $this->settingContainer->getSettingGroupList();
    }
}

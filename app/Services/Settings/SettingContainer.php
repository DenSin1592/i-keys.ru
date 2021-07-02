<?php

namespace App\Services\Settings;

use App\Services\Settings\Exception\NotFoundKeyException;
use App\Services\Settings\Exception\NotUniqueKeyException;

/**
 * Class SettingContainer
 * Container to manage config which will be sent in database.
 * @package App\Service\Settings
 */
class SettingContainer
{
    /**
     * @var SettingGroup[]
     */
    private $settingGroupList = [];

    /**
     * Add group of settings.
     * @param SettingGroup $settingGroup
     * @throws NotUniqueKeyException
     */
    public function addSettingGroup(SettingGroup $settingGroup): void
    {
        if ($this->checkKeyAreUnique($settingGroup)) {
            $settingGroup->setKey(count($this->settingGroupList));
            $this->settingGroupList[] = $settingGroup;
        } else {
            throw new NotUniqueKeyException;
        }
    }

    /**
     * Check if adding keys are unique.
     * @param SettingGroup $settingGroup
     * @return bool
     */
    private function checkKeyAreUnique(SettingGroup $settingGroup): bool
    {
        $unique = true;
        $existingKeys = $this->getKeyArray();

        foreach ($settingGroup->getSettingValueList() as $value) {
            if (in_array($value->getKey(), $existingKeys, true)) {
                $unique = false;
                break;
            }
        }

        return $unique;
    }

    /**
     * Get group of settings.
     * @return SettingGroup[]
     */
    public function getSettingGroupList(): array
    {
        return $this->settingGroupList;
    }

    /**
     * Get array of keys.
     * @return array
     */
    public function getKeyArray(): array
    {
        $keyList = [];
        foreach ($this->settingGroupList as $group) {
            foreach ($group->getSettingValueList() as $value) {
                $keyList[] = $value->getKey();
            }
        }

        return $keyList;
    }

    /**
     * Get array of settings.
     * @return SettingValue[]
     */
    public function getSettingList(): array
    {
        $settingList = [];

        foreach ($this->settingGroupList as $group) {
            foreach ($group->getSettingValueList() as $value) {
                $settingList[] = $value;
            }
        }

        return $settingList;
    }

    /**
     * Get rules for setting value by key.
     *
     * @param $key
     * @return array
     * @throws NotFoundKeyException
     */
    public function getRulesBy($key): array
    {
        return $this->findSettingBy($key)->getRules();
    }


    /**
     * Get type for setting value by key.
     *
     * @param $key
     * @return string
     * @throws NotFoundKeyException
     */
    public function getTypeBy($key): string
    {
        return $this->findSettingBy($key)->getType();
    }

    /**
     * Find setting by key.
     *
     * @param $key
     * @return SettingValue
     * @throws NotFoundKeyException
     */
    private function findSettingBy($key): SettingValue
    {
        $preparedKey = SettingValue::prepareKey($key);
        $settingList = $this->getSettingList();

        foreach ($settingList as $setting) {
            if ($setting->getPreparedKey() === $preparedKey) {
                return $setting;
            }
        }

        throw new NotFoundKeyException("Key {$key} is not found");
    }
}

<?php

namespace App\Services\Settings;

/**
 * Class SettingGroup
 * @package App\Service\Settings
 */
class SettingGroup
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $groupName;

    /**
     * @var SettingValue[]
     */
    private $settingValueList = [];

    /**
     * @param string $groupName
     */
    public function __construct($groupName)
    {
        $this->groupName = $groupName;
    }

    /**
     * Add setting value.
     * @param SettingValue $settingValue
     */
    public function addSettingValue(SettingValue $settingValue): void
    {
        $settingValue->setSettingGroup($this);
        $this->settingValueList[] = $settingValue;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->groupName;
    }

    /**
     * @return SettingValue[]
     */
    public function getSettingValueList(): array
    {
        return $this->settingValueList;
    }

    /**
     * @param $key
     * @return int
     */
    public function setKey($key): int
    {
        return $this->key = $key;
    }

    /**
     * @return int
     */
    public function getKey(): int
    {
        return $this->key;
    }

    /**
     * Get setting keys.
     *
     * @param $prefix
     * @return array
     */
    public function getSettingKeys($prefix)
    {
        return array_map(function (SettingValue $settingValue) use ($prefix) {
            return $prefix . $settingValue->getPreparedKey();
        }, $this->settingValueList);
    }
}

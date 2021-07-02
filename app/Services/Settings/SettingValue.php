<?php

namespace App\Services\Settings;

use App\Services\Settings\Exception\IllegalDefaultValue;
use Validator;

/**
 * Class SettingValue
 * @package App\Services\Settings
 */
class SettingValue
{
    const TYPE_TEXT = 'text';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_TEXTAREA_TINYMCE = 'textarea_tinymce';
    const TYPE_REDIRECTS = 'redirects';
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|array
     */
    private $value;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $defaultValue;

    /**
     * @var array
     */
    private $rules = [];


    /**
     * @var SettingGroup
     */
    private $settingGroup;

    /**
     * @param $key
     * @param $name
     * @param string $defaultValue
     * @param string $description
     * @param string $type
     * @param array $rules
     *
     * @throws IllegalDefaultValue
     */
    public function __construct(
        $key,
        $name,
        $defaultValue = '',
        $description = '',
        $type = self::TYPE_TEXT,
        array $rules = []
    ) {
        if (Validator::make(['defaultValue' => $defaultValue], ['defaultValue' => $this->getRules()])->fails()) {
            throw new IllegalDefaultValue(
                "Illegal default value '{$this->defaultValue}' for setting with '{$key}' key."
            );
        }

        $this->key = $key;
        $this->name = $name;
        $this->defaultValue = $defaultValue;
        $this->description = $description;
        $this->type = $type;
        $this->rules = $rules;
    }

    /**
     * Prepare key.
     *
     * @param $key
     * @return mixed
     */
    public static function prepareKey($key)
    {
        return str_replace('.', '-', $key);
    }

    /**
     * Original key.
     *
     * @param $preparedKey
     * @return mixed
     */
    public static function originalKeyFor($preparedKey)
    {
        return str_replace('-', '.', $preparedKey);
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getPreparedKey(): string
    {
        return self::prepareKey($this->key);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getDefaultValue(): ?string
    {
        return $this->defaultValue;
    }

    /**
     * @param array|string $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return string|array
     */
    public function getValue()
    {
        return $this->value ?? $this->defaultValue;
    }

    public function getRules(): array
    {
        return $this->rules;
    }

    public function setSettingGroup(SettingGroup $settingGroup): void
    {
        $this->settingGroup = $settingGroup;
    }
}

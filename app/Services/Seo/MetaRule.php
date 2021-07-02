<?php namespace App\Services\Seo;

/**
 * Class MetaRule
 * Rule to build meta-data for page.
 * @package App\Services\Seo
 */
class MetaRule
{
    /**
     * @var callable
     */
    private $rule;


    /**
     * MetaRule constructor.
     * @param callable $rule
     */
    public function __construct(callable $rule)
    {
        $this->rule = $rule;
    }


    /**
     * Get data for object.
     *
     * @param $object
     * @param null $name - alternative name
     * @param array $additionalData
     * @return array
     */
    public function metaForObject($object, $name = null, array $additionalData = [])
    {
        if (!empty($object->header)) {
            $h1 = $object->header;
        } elseif (!empty($object->name)) {
            $h1 = $object->name;
        } elseif (!is_null($name)) {
            $h1 = $name;
        } else {
            $h1 = '';
        }

        if (!empty($object->meta_title)) {
            $metaTitle = $object->meta_title;
        } else {
            $metaTitle = '';
        }

        if (!empty($object->meta_keywords)) {
            $metaKeywords = $object->meta_keywords;
        } else {
            $metaKeywords = '';
        }

        if (!empty($object->meta_description)) {
            $metaDescription = $object->meta_description;
        } else {
            $metaDescription = '';
        }

        $metaData = [
            'h1' => $h1,
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'meta_keywords' => $metaKeywords,
        ];

        $rule = \Closure::bind($this->rule, $this, get_called_class());
        $metaData = $rule($metaData, [
            'object' => $object,
            'name' => $name,
            'additionalData' => $additionalData,
        ]);

        return $metaData;
    }


    /**
     * Get meta data for name.
     *
     * @param $name
     * @param array $additionalData
     * @return array
     */
    public function metaForName($name, array $additionalData = [])
    {
        $metaData = [
            'h1' => $name,
            'meta_title' => '',
            'meta_description' => '',
            'meta_keywords' => '',
        ];

        $rule = \Closure::bind($this->rule, $this, get_called_class());
        $metaData = $rule($metaData, [
            'name' => $name,
            'additionalData' => $additionalData,
        ]);

        return $metaData;
    }
}

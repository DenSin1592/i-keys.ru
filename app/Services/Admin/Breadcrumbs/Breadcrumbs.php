<?php namespace App\Services\Admin\Breadcrumbs;

use App\Services\Admin\Breadcrumbs\Exception\BuilderNotFound;

/**
 * Class Breadcrumbs
 * @package App\Services\Admin\Breadcrumbs
 */
class Breadcrumbs
{
    /**
     * @var Builder[]
     */
    private $builders = [];

    public function addBuilder($key, callable $pathBuilder)
    {
        $this->builders[$key] = new Builder($pathBuilder);
    }

    public function getFor($key, $options)
    {
        /**
         * @var Builder $foundBuilder
         */
        $foundBuilder = \Arr::get($this->builders, $key);
        if (null === $foundBuilder) {
            throw new BuilderNotFound("Breadcrumbs builder for key '{$key}' is not found");
        }

        $foundBuilder->setOptions($options);

        return $foundBuilder;
    }
}

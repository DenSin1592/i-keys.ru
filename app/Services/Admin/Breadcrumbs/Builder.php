<?php namespace App\Services\Admin\Breadcrumbs;

/**
 * Class Builder
 * @package App\Services\Admin\Breadcrumbs
 */
class Builder implements \IteratorAggregate
{
    /**
     * @var callable
     */
    private $pathBuilder;

    /**
     * @var array
     */
    private $options;

    /**
     * @var Path
     */
    private $path;

    public function __construct(callable $pathBuilder)
    {
        $this->pathBuilder = $pathBuilder;
    }

    public function setOptions($value)
    {
        if (is_array($value)) {
            $options = $value;

        } else {
            $options = [$value];
        }

        $this->options = $options;
    }

    private function buildPath()
    {
        return call_user_func_array($this->pathBuilder, $this->options);
    }

    public function getIterator()
    {
        if (null === $this->path) {
            $this->path = $this->buildPath();
        }

        return new \ArrayIterator($this->path->get());
    }
}

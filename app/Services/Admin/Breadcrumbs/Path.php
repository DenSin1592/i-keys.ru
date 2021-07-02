<?php namespace App\Services\Admin\Breadcrumbs;

/**
 * Class CrumbsPath
 * @package App\Services\Admin\Breadcrumbs
 */
class Path implements \Countable
{
    private $path = [];

    public function add($name, $url = null)
    {
        $this->path[] = ['name' => $name, 'url' => $url];
    }

    public function get()
    {
        return $this->path;
    }

    public function count()
    {
        return count($this->path);
    }
}

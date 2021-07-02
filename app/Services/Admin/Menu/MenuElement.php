<?php namespace App\Services\Admin\Menu;

use App\Services\Admin\Menu\Exception\ActionNotFound;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

/**
 * Class MenuElement
 * Menu element container.
 * @package App\Services\Admin\Menu
 */
class MenuElement
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $icon;

    /**
     * @var callable
     */
    private $url;

    /**
     * @var callable
     */
    private $activeResolver;

    /**
     * Create menu element.
     *
     * @param string $name
     * @param string $icon
     * @param callable|string $url
     * @param callable|array|string $activeResolver
     */
    public function __construct(
        $name,
        $icon,
        $url,
        $activeResolver
    ) {
        $this->name = $name;
        $this->icon = $icon;
        $this->url = $url;
        $this->activeResolver = $activeResolver;
    }

    /**
     * Get menu element link.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get menu element icon.
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Get menu element list.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get active flag.
     *
     * @return callable
     */
    public function getActive()
    {
        $currentRoute = \Route::getCurrentRoute();
        $parameters = $currentRoute->parameters();

        $currentAction = $currentRoute->getAction();
        if (isset($currentAction['controller'])) {
            $controllerName = explode('@', $currentAction['controller'])[0];
        } else {
            $controllerName = null;
        }

        $activeResolver = $this->activeResolver;
        if (is_callable($activeResolver)) {
            $active = $activeResolver($controllerName, $parameters);

        } else {
            $active = in_array($controllerName, (array)$activeResolver);
        }

        return $active;
    }


}

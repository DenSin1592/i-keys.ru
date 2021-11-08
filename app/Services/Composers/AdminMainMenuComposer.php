<?php namespace App\Services\Composers;

use App\Services\Admin\Menu\Menu;
use App\Services\Admin\Menu\MenuElement;
use App\Services\Admin\Menu\MenuGroup;

/**
 * Class AdminMainMenuComposer
 * @package App\Services\Composers
 */
class AdminMainMenuComposer
{
    /**
     * Menu object.
     *
     * @var Menu
     */
    private $mainMenu;

    public function __construct()
    {
        $this->mainMenu = \App::make('admin.main_menu');
    }

    public function compose($view)
    {
        $menuData = [];
        foreach ($this->mainMenu->getMenuItems() as $menuItem) {
            if ($menuItem instanceof MenuElement) {
                $menuDataElement = $this->getMenuElementData($menuItem);
                if (!is_null($menuDataElement)) {
                    $menuData[] = $menuDataElement;
                }
            } elseif ($menuItem instanceof MenuGroup) {
                $groupMenuElement = [
                    'name' => $menuItem->getName(),
                    'icon' => $menuItem->getIcon(),
                    'elements' => [],
                ];

                $groupMenuElementActive = false;
                foreach ($menuItem->getMenuElementList() as $menuElement) {
                    $menuDataElement = $this->getMenuElementData($menuElement);
                    if (!is_null($menuDataElement)) {
                        $groupMenuElement['elements'][] = $menuDataElement;
                        $groupMenuElementActive = $groupMenuElementActive || $menuDataElement['active'];
                    }
                }
                $groupMenuElement['active'] = $groupMenuElementActive;
                if (count($groupMenuElement['elements']) > 0) {
                    $menuData[] = $groupMenuElement;
                }
            }
        }

        $view->with('main_menu', $menuData);
    }

    /**
     * Get menu element data for view.
     *
     * @param MenuElement $menuElement
     * @return array
     */
    private function getMenuElementData(MenuElement $menuElement)
    {
        return [
            'name' => $menuElement->getName(),
            'icon' => $menuElement->getIcon(),
            'link' => $menuElement->getUrl(),
            'active' => $menuElement->getActive(),
            'openLinkInNewTab' => $menuElement->getOpenLinkInNewTab(),
        ];
    }
}

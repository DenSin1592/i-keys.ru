<?php namespace App\Providers\Admin;

use App\Http\Controllers\Admin\ProductTypePagesController;
use App\Http\Controllers\Admin\ReviewsController;
use Arr;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AttributesController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\HomePagesController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\StructureController;
use App\Http\Controllers\Admin\TextPagesController;
use App\Services\Admin\Menu\Menu;
use App\Services\Admin\Menu\MenuElement;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->app->singleton(
            'admin.main_menu',
            function () {
                $menu = new Menu();

                $menu->addMenuElement(
                    new MenuElement(
                        'Структура сайта',
                        'glyphicon-th-list',
                        route('cc.structure.index'),
                        [
                            StructureController::class,
                            HomePagesController::class,
                            TextPagesController::class,
                        ]
                    )
                );

                $menu->addMenuElement(
                    new MenuElement(
                        'Каталог товаров',
                        'glyphicon-list',
                        route('cc.categories.index'),
                        [
                            CategoriesController::class,
//                            ProductsController::class,
                        ]
                    )
                );
                $menu->addMenuElement(
                    new MenuElement(
                        'Типы товаров',
                        'glyphicon-film',
                        route('cc.product-type-pages.index'),
                        [
                            ProductTypePagesController::class,
                        ]
                    )
                );

                $menu->addMenuElement(
                    new MenuElement(
                        'Характеристики товаров',
                        'glyphicon-align-left',
                        route('cc.attributes.index'),
                        [AttributesController::class]
                    )
                );

                $menu->addMenuElement(
                    new MenuElement(
                        'Администраторы',
                        'glyphicon-user',
                        route('cc.admin-users.index'),
                        [AdminUsersController::class]
                    )
                );

                $menu->addMenuElement(
                    new MenuElement(
                        'Константы',
                        'glyphicon-copyright-mark',
                        route('cc.settings.edit'),
                        [SettingsController::class]
                    )
                );

                $menu->addMenuElement(
                    new MenuElement(
                        'Отзывы',
                        'glyphicon-thumbs-up',
                        route('cc.reviews.index'),
                        [ReviewsController::class]
                    )
                );

                return $menu;
            }
        );
    }
}

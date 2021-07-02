<?php namespace App\Providers\Admin;

use App\Services\Repositories\Type\EloquentTypeRepository;
use Arr;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AttributesController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\HomePagesController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\StructureController;
use App\Http\Controllers\Admin\TextPagesController;
use App\Http\Controllers\Admin\TypesController;
use App\Services\Admin\Menu\Menu;
use App\Services\Admin\Menu\MenuElement;
use App\Services\Admin\Menu\MenuGroup;
use App\Services\Repositories\Category\EloquentCategoryRepository;
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

                /**
                 * @var $typeRepository EloquentTypeRepository
                 */
                $typeRepository = app(EloquentTypeRepository::class);
                $rootTypes = $typeRepository->rooted();
                if (count($rootTypes) > 0) {
                    $groupCatalog = new MenuGroup('Типы товаров', 'glyphicon-briefcase');
                    $menu->addMenuGroup($groupCatalog);
                    foreach ($rootTypes as $rootType) {
                        $groupCatalog->addMenuElement(
                            new MenuElement(
                                $rootType->name,
                                'glyphicon-list',
                                route('cc.types.show', $rootType->id),
                                function ($controllerName, $parameters) use ($rootType, $typeRepository) {
                                    $active = false;

                                    if ($controllerName === TypesController::class) {
                                        $typeId = Arr::get($parameters, 'type');
                                        $typeIds = $typeRepository->getDescendantsAndSelf($rootType)
                                            ->pluck('id')
                                            ->all();

                                        $active = in_array($typeId, $typeIds);
                                    }

                                    return $active;
                                }
                            )
                        );
                    }
                } else {
                    $menu->addMenuElement(
                        new MenuElement(
                            'Типы товаров',
                            'glyphicon-list',
                            route('cc.types.index'),
                            TypesController::class
                        )
                    );
                }

                /**
                 * @var $categoryRepository EloquentCategoryRepository
                 */
                $categoryRepository = app(EloquentCategoryRepository::class);
                $rootCategories = $categoryRepository->rooted();
                if (count($rootCategories) > 0) {
                    $groupCatalog = new MenuGroup('Каталоги', 'glyphicon-briefcase');
                    $menu->addMenuGroup($groupCatalog);
                    foreach ($rootCategories as $rootCategory) {
                        $groupCatalog->addMenuElement(
                            new MenuElement(
                                $rootCategory->name,
                                'glyphicon-list',
                                route('cc.categories.show', $rootCategory->id),
                                function ($controllerName, $parameters) use ($rootCategory, $categoryRepository) {
                                    $active = false;

                                    if (in_array($controllerName, [
                                        CategoriesController::class,
                                        ProductsController::class,
                                        AttributesController::class,
                                    ])) {
                                        $categoryId = Arr::get($parameters, 'categories');
                                        $categoryIds = $categoryRepository->getDescendantsAndSelf($rootCategory)
                                            ->pluck('id')
                                            ->all();

                                        $active = in_array($categoryId, $categoryIds);
                                    }

                                    return $active;
                                }
                            )
                        );
                    }
                } else {
                    $menu->addMenuElement(
                        new MenuElement(
                            'Каталоги',
                            'glyphicon-list',
                            route('cc.categories.index'),
                            CategoriesController::class
                        )
                    );
                }

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

                return $menu;
            }
        );
    }
}

<?php namespace App\Providers\Admin;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\HomePage;
use App\Models\MetaPage;
use App\Models\Node;
use App\Models\Product;
use App\Models\TextPage;
use App\Models\Type;
use App\Services\Admin\Breadcrumbs\Breadcrumbs;
use App\Services\Admin\Breadcrumbs\Path;
use Illuminate\Support\ServiceProvider;

/**
 * Class BreadcrumbsServiceProvider
 * @package App\Providers\Admin
 */
class BreadcrumbsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            Breadcrumbs::class,
            function () {
                $breadcrumbs = new Breadcrumbs();

                $this->addStructureBuilders($breadcrumbs);
                $this->addCatalogBuilders($breadcrumbs);
                $this->addTypesBuilders($breadcrumbs);

                return $breadcrumbs;
            }
        );
    }

    private function addStructureBuilders(Breadcrumbs $breadcrumbs)
    {
        $breadcrumbs->addBuilder(
            'structure_page.create',
            function (Node $node) {
                $path = $this->createNodeParentPath($node);
                $path->add('Создание страницы');

                return $path;
            }
        );

        $breadcrumbs->addBuilder(
            'structure_page.edit',
            function (Node $node) {
                $path = $this->createNodeParentPath($node);
                $path->add($node->name);

                return $path;
            }
        );
    }

    private function addCatalogBuilders(Breadcrumbs $breadcrumbs)
    {
        $breadcrumbs->addBuilder(
            'category.show',
            function (Category $category) {
                $path = $this->createCategoryParentPath($category);
                $path->add($category->name);
                return $path;
            }
        );

        $breadcrumbs->addBuilder(
            'category.create',
            function (Category $category = null) {
                $path = $this->createCategoryParentPath($category, true);
                $path->add('Создание категории');

                return $path;
            }
        );

        $breadcrumbs->addBuilder(
            'category.edit',
            function (Category $category) {
                $path = $this->createCategoryParentPath($category);
                $path->add($category->name . ' - редактирование категории');

                return $path;
            }
        );

        $breadcrumbs->addBuilder(
            'category.products',
            function (Category $category) {
                $path = $this->createCategoryParentPath($category, true);
                $path->add('Список товаров');

                return $path;
            }
        );

        $breadcrumbs->addBuilder(
            'category.product.edit',
            function (Product $product) {
                $category = $product->category;
                $path = $this->createCategoryParentPath($category, true);
                $path->add('Список товаров', route('cc.products.index', $category->id));
                $path->add($product->name . ' - редактирование товара');

                return $path;
            }
        );

        $breadcrumbs->addBuilder(
            'category.attributes',
            function (Category $category) {
                $path = $this->createCategoryParentPath($category, true);
                $path->add('Список параметров');

                return $path;
            }
        );

        $breadcrumbs->addBuilder(
            'category.attribute.create',
            function (Category $category) {
                $path = $this->createCategoryParentPath($category, true);
                $path->add('Список параметров', route('cc.attributes.index', $category->id));
                $path->add('Создание параметра');

                return $path;
            }
        );

        $breadcrumbs->addBuilder(
            'category.attribute.edit',
            function (Category $category, Attribute $attribute) {
                $path = $this->createCategoryParentPath($category, true);
                $path->add('Список параметров', route('cc.attributes.index', $category->id));
                $path->add($attribute->name . ' - редактирование параметра');

                return $path;
            }
        );
    }

    private function addTypesBuilders(Breadcrumbs $breadcrumbs): void
    {
        $breadcrumbs->addBuilder(
            'type.show',
            function (Type $type) {
                $path = $this->createTypeParentPath($type);
                $path->add($type->name);

                return $path;
            }
        );

        $breadcrumbs->addBuilder(
            'type.create',
            function (Type $type = null) {
                $path = $this->createTypeParentPath($type);
                $path->add('Создание типа товаров');

                return $path;
            }
        );

        $breadcrumbs->addBuilder(
            'type.edit',
            function (Type $type) {
                $path = $this->createTypeParentPath($type);
                $path->add($type->name . ' - редактирование типа товаров');

                return $path;
            }
        );
    }

    private function createNodeParentPath(Node $node): Path
    {
        $path = new Path();

        $path->add('Структура сайта', route('cc.structure.index'));

        foreach ($node->extractParentPath() as $nodeInPath) {
            $url = route('cc.structure.edit', $nodeInPath->id);
            $page = \TypeContainer::getContentModelFor($nodeInPath);

            if (null !== $page && $page->exists) {
                if ($page instanceof TextPage) {
                    $url = route('cc.text-pages.edit', $nodeInPath->id);

                } elseif ($page instanceof HomePage) {
                    $url = route('cc.home-pages.edit', $nodeInPath->id);

                } elseif ($page instanceof MetaPage) {
                    $url = route('cc.meta-pages.edit', $nodeInPath->id);
                }
            }

            $path->add($nodeInPath->name, $url);
        }

        return $path;
    }

    private function createCategoryParentPath(Category $category = null, $withSelf = false): Path
    {
        $path = new Path();

        $path->add('Каталоги', route('cc.categories.index'));
        if (null !== $category) {
            $categoriesPath = $category->extractParentPath();

            if ($withSelf) {
                $categoriesPath[] = $category;
            }

            foreach ($categoriesPath as $categoryInPath) {
                $path->add($categoryInPath->name, route('cc.categories.show', $categoryInPath->id));
            }
        }

        return $path;
    }

    private function createTypeParentPath(Type $type = null, $withSelf = false): Path
    {
        $path = new Path();

        $path->add('Типы товаров', route('cc.types.index'));
        if (null !== $type) {
            $typesPath = $type->extractParentPath();

            if ($withSelf) {
                $typesPath[] = $type;
            }

            foreach ($typesPath as $typeInPath) {
                $path->add($typeInPath->name, route('cc.types.show', $typeInPath->id));
            }
        }

        return $path;
    }

}

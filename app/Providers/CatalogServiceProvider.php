<?php

namespace App\Providers;

use App\Models\Attribute;
use App\Models\Category;
use App\Services\Catalog\Filter\Filter\CatalogFilterFactory;
use App\Services\Catalog\Filter\Filter\FilterLensAggregator;
use App\Services\Catalog\Filter\Filter\FilterLensWrapper;
use App\Services\Catalog\Filter\Lens\BrandLens;
use App\Services\Catalog\Filter\Lens\ClassicListLens;
use App\Services\Catalog\Filter\Lens\CylinderBrandLens;
use App\Services\Catalog\Filter\Lens\CylinderSeriesLens;
use App\Services\Catalog\Filter\Lens\CylinderSizeLens;
use App\Services\Catalog\Filter\Lens\LockBrandLens;
use App\Services\Catalog\Filter\Lens\LockSeriesLens;
use App\Services\Catalog\Filter\Lens\OptionLens;
use App\Services\Catalog\Filter\Lens\PriceLens;
use App\Services\Catalog\Filter\Lens\SecurityClassLens;
use App\Services\Catalog\ListSorting\Sorting;
use App\Services\Catalog\ListSorting\Sorting\AlphabetSorting;
use App\Services\Catalog\ListSorting\Sorting\PositionSorting;
use App\Services\Catalog\ListSorting\Sorting\PriceSorting;
use App\Services\Catalog\ListSorting\SortingContainer;
use App\Services\Repositories\Attribute\AllowedValue\EloquentAllowedValueRepository;
use App\Services\Repositories\Attribute\EloquentAttributeRepository;
use Illuminate\Support\ServiceProvider;


class CatalogServiceProvider extends ServiceProvider
{

    public const MULTIPLE_VIEWS_FOR_SELECTED_BLOCK = ['multiple_checkboxes','security_class', 'color', 'brands_and_series', 'empty', ];

    public const CYLINDER_SIZE_KEY = 'cylinder_size';

    public function register(): void
    {
        $this->app->singleton(
            'catalog.sorting',
            function () {
                $sortingContainer = new SortingContainer();
                $sortingContainer->addSorting(
                    new PositionSorting(
                        'По популярности',
                        'popular',
                        Sorting::DIRECTION_ASC
                    )
                );
                $sortingContainer->addSorting(
                    new PriceSorting(
                        'Сначала дешёвые',
                        'price_asc',
                        Sorting::DIRECTION_ASC
                    )
                );
                $sortingContainer->addSorting(
                    new PriceSorting(
                        'Сначала дорогие',
                        'price_desc',
                        Sorting::DIRECTION_DESC
                    )
                );
                /*$sortingContainer->addSorting(
                    new AlphabetSorting(
                        'Алфавиту',
                        'abc_asc',
                        Sorting::DIRECTION_ASC
                    )
                );*/

                return $sortingContainer;
            }
        );
        $this->app->bind(SortingContainer::class, 'catalog.sorting');

        $this->registerFilter();
    }

    private function registerFilter()
    {
        $attributeRepository = $this->app->make(EloquentAttributeRepository::class);
        $allowedValueRepository = $this->app->make(EloquentAllowedValueRepository::class);

        $this->app->singleton(
            'catalog.filter_lens.options',
            function () {
                return new FilterLensWrapper(
                   new OptionLens(),
                    'options',
                    'Опции',
                    'options'
                );
            }
        );
        $this->app->singleton(
            'catalog.filter_lens.price',
            function () {
                return new FilterLensWrapper(
                    new PriceLens(),
                    'price',
                    'Цена (руб.)',
                    'range'
                );
            }
        );
        $this->app->singleton(
            'catalog.filter_lens.security_level',
            function () use ($attributeRepository, $allowedValueRepository) {
                return new FilterLensWrapper(
                    new SecurityClassLens(
                        $attributeRepository,
                        $allowedValueRepository,
                        '000000029'
                    ),
                    'security_level',
                    'Уровень безопасности',
                    'security_class'
                );
            }
        );
        $this->app->singleton(
            'catalog.filter_lens.color',
            function () use ($attributeRepository, $allowedValueRepository) {
                return new FilterLensWrapper(
                    new ClassicListLens(
                        $attributeRepository,
                        $allowedValueRepository,
                        Attribute\AttributeConstants::COLOR_1C_CODE
                    ),
                    'color',
                    'Цвет',
                    'color'
                );
            }
        );
        $this->app->singleton(
            'catalog.filter_lens.cylinder_size',
            function () use ($attributeRepository, $allowedValueRepository) {
                return new FilterLensWrapper(
                    new CylinderSizeLens(
                        $attributeRepository,
                        $allowedValueRepository,
                        Attribute\AttributeConstants::SIZE_CYLINDER_1C_CODE
                    ),
                    self::CYLINDER_SIZE_KEY,
                    'Типоразмер',
                    'cylinder_size'
                );
            }
        );

        $this->app->singleton(
            'catalog.filter_lens.cylinder_mechanism',
            function () use ($attributeRepository, $allowedValueRepository) {
                return new FilterLensWrapper(
                    new ClassicListLens(
                        $attributeRepository,
                        $allowedValueRepository,
                        '000000018'
                    ),
                    'cylinder_mechanism',
                    'Конфигурация',
                    'multiple_checkboxes'
                );
            }
        );
        $this->app->singleton(
            'catalog.filter_lens.brands',
            function () use ($attributeRepository, $allowedValueRepository) {
                return new FilterLensWrapper(
                    new ClassicListLens(
                        $attributeRepository,
                        $allowedValueRepository,
                        '000000001'
                    ),
                    'brands',
                    'Бренд',
                    'multiple_checkboxes'
                );
            }
        );
        $this->app->singleton(
            'catalog.filter_lens.lock_brands',
            function () use ($attributeRepository, $allowedValueRepository) {
                return new FilterLensWrapper(
                    new LockBrandLens(
                        $attributeRepository,
                        $allowedValueRepository,
                        '000000001'
                    ),
                    'brands',
                    'Бренд',
                    'brands_and_series'
                );
            }
        );
        $this->app->singleton(
            'catalog.filter_lens.cylinder_brands',
            function () use ($attributeRepository, $allowedValueRepository) {
                return new FilterLensWrapper(
                    new CylinderBrandLens(
                        $attributeRepository,
                        $allowedValueRepository,
                        '000000001'
                    ),
                    'brands',
                    'Бренд',
                    'brands_and_series'
                );
            }
        );
        $this->app->singleton(
            'catalog.filter_lens.lock_type',
            function () use ($attributeRepository, $allowedValueRepository) {
                return new FilterLensWrapper(
                    new ClassicListLens(
                        $attributeRepository,
                        $allowedValueRepository,
                        '000000003'
                    ),
                    'lock_type',
                    'Тип замка',
                    'multiple_checkboxes'
                );
            }
        );
        $this->app->singleton(
            'catalog.filter_lens.type_of_privacy_mechanism',
            function () use ($attributeRepository, $allowedValueRepository) {
                return new FilterLensWrapper(
                    new ClassicListLens(
                        $attributeRepository,
                        $allowedValueRepository,
                        '000000011'
                    ),
                    'type_of_privacy_mechanism',
                    'Тип механизма секретности',
                    'multiple_checkboxes'
                );
            }
        );
        $this->app->singleton(
            'catalog.filter_lens.lock_series',
            function () use ($attributeRepository, $allowedValueRepository) {
                return new FilterLensWrapper(
                    new LockSeriesLens(
                        $attributeRepository,
                        $allowedValueRepository,
                        '000000028'
                    ),
                    'series',
                    'Серия замка',
                    'empty'
                );
            }
        );
        $this->app->singleton(
            'catalog.filter_lens.cylinder_series',
            function () use ($attributeRepository, $allowedValueRepository) {
                return new FilterLensWrapper(
                    new CylinderSeriesLens(
                        $attributeRepository,
                        $allowedValueRepository,
                        Attribute\AttributeConstants::CYLINDER_SERIES_1C_CODE
                    ),
                    'cylinder_series',
                    'Серия цилиндра',
                    'empty'
                );
            }
        );


        $this->app->singleton(
            'catalog.filter.default',
            function () {
                $filter = new FilterLensAggregator();
                $filter->addLens($this->app->make('catalog.filter_lens.options'));
                $filter->addLens($this->app->make('catalog.filter_lens.color'));
                $filter->addLens($this->app->make('catalog.filter_lens.price'));
                $filter->addLens($this->app->make('catalog.filter_lens.brands'));

                return $filter;
            }
        );


        $this->app->singleton(
            'catalog.filter.locks',
            function () {
                $filter = new FilterLensAggregator();
                $filter->addLens($this->app->make('catalog.filter_lens.lock_series'));
                $filter->addLens($this->app->make('catalog.filter_lens.options'));
                $filter->addLens($this->app->make('catalog.filter_lens.color'));
                $filter->addLens($this->app->make('catalog.filter_lens.price'));
                $filter->addLens($this->app->make('catalog.filter_lens.lock_type'));
                $filter->addLens($this->app->make('catalog.filter_lens.type_of_privacy_mechanism'));
                $filter->addLens($this->app->make('catalog.filter_lens.lock_brands'));

                return $filter;
            }
        );


        $this->app->singleton(
            'catalog.filter.cylinder_mechanisms',
            function () {
                $filter = new FilterLensAggregator();
                $filter->addLens($this->app->make('catalog.filter_lens.cylinder_series'));
                $filter->addLens($this->app->make('catalog.filter_lens.options'));
                $filter->addLens($this->app->make('catalog.filter_lens.security_level'));
                $filter->addLens($this->app->make('catalog.filter_lens.color'));
                $filter->addLens($this->app->make('catalog.filter_lens.cylinder_size'));
                $filter->addLens($this->app->make('catalog.filter_lens.cylinder_mechanism'));
                $filter->addLens($this->app->make('catalog.filter_lens.price'));
                $filter->addLens($this->app->make('catalog.filter_lens.cylinder_brands'));

                return $filter;
            }
        );


        $this->app->singleton(
            'catalog.filter_factory',
            function () {
                $filterFactory = new CatalogFilterFactory(
                    $this->app->make('catalog.filter.default')
                );

                foreach (
                    [
                        Category::LOCKS_1C_CODE,
                    ]as $catCode1c) {
                    $filterFactory->addFilter($catCode1c, $this->app->make('catalog.filter.locks'));
                }

                foreach (
                    [
                        Category::CILINDRY_1C_CODE,
                    ] as $catCode1c) {
                    $filterFactory->addFilter($catCode1c, $this->app->make('catalog.filter.cylinder_mechanisms'));
                }

                return $filterFactory;
            }
        );

        $this->app->bind(CatalogFilterFactory::class, 'catalog.filter_factory');
    }
}

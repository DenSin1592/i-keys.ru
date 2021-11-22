<?php

namespace App\Providers;

use App\Models\Category;
use App\Services\Catalog\Filter\Filter\CatalogFilterFactory;
use App\Services\Catalog\Filter\Filter\FilterLensAggregator;
use App\Services\Catalog\Filter\Filter\FilterLensWrapper;
use App\Services\Catalog\Filter\Lens\ClassicListLens;
use App\Services\Catalog\Filter\Lens\PriceLens;
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

    public function register(): void
    {
        $this->app->singleton(
            'catalog.sorting',
            function () {
                $sortingContainer = new SortingContainer();
               /* $sortingContainer->addSorting(
                    new PositionSorting(
                        'По популярности',
                        'popular',
                        Sorting::DIRECTION_ASC
                    )
                );*/
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
            'catalog.filter_lens.price',
            function () {
                return new FilterLensWrapper(
                    new PriceLens(),
                    'price',
                    'Цена',
                    'range'
                );
            }
        );
        $this->app->singleton(
            'catalog.filter_lens.security_level',
            function () use ($attributeRepository, $allowedValueRepository) {
                return new FilterLensWrapper(
                    new ClassicListLens(
                        $attributeRepository,
                        $allowedValueRepository,
                        '000000029'
                    ),
                    'security_level',
                    'Уровень безопасности',
                    'multiple_checkboxes'
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
                        '000000010'
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
                    new ClassicListLens(
                        $attributeRepository,
                        $allowedValueRepository,
                        '000000013'
                    ),
                    'cylinder_size',
                    'Типоразмер',
                    'cilinder_size'
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

        /*$this->app->singleton(
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
        );*/

        /*$this->app->singleton(
            'catalog.filter_lens.cylinder_series',
            function () use ($attributeRepository, $allowedValueRepository) {
                return new FilterLensWrapper(
                    new ClassicListLens(
                        $attributeRepository,
                        $allowedValueRepository,
                        '000000004'
                    ),
                    'cylinder_series',
                    'Серия цилиндра',
                    'multiple_checkboxes'
                );
            }
        );*/

        /*$this->app->singleton(
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
        );*/

        /*$this->app->singleton(
            'catalog.filter_lens.series',
            function () use ($attributeRepository, $allowedValueRepository) {
                return new FilterLensWrapper(
                    new ClassicListLens(
                        $attributeRepository,
                        $allowedValueRepository,
                        '000000028'
                    ),
                    'series',
                    'Серия замка',
                    'multiple_checkboxes'
                );
            }
        );*/

        /*$this->app->singleton(
            'catalog.filter_lens.latch',
            function () use ($attributeRepository, $allowedValueRepository) {
                return new FilterLensWrapper(
                    new ClassicListLens(
                        $attributeRepository,
                        $allowedValueRepository,
                        '000000025'
                    ),
                    'latch',
                    'Наличие защелки',
                    'multiple_checkboxes'
                );
            }
        );*/


        $this->app->singleton(
            'catalog.filter.default',
            function () {
                $filter = new FilterLensAggregator();
                $filter->addLens($this->app->make('catalog.filter_lens.price'));

                return $filter;
            }
        );

        //Цилиндровые механизмы
        $this->app->singleton(
            'catalog.filter.cylinder_mechanisms',
            function () {
                $filter = new FilterLensAggregator();
                $filter->addLens($this->app->make('catalog.filter_lens.security_level'));
                $filter->addLens($this->app->make('catalog.filter_lens.color'));
                $filter->addLens($this->app->make('catalog.filter_lens.cylinder_size'));
                $filter->addLens($this->app->make('catalog.filter_lens.cylinder_mechanism'));
                $filter->addLens($this->app->make('catalog.filter_lens.price'));
                $filter->addLens($this->app->make('catalog.filter_lens.brands'));



                return $filter;
            }
        );

        //Цилиндровые механизмы других производителей
        /*$this->app->singleton(
            'catalog.filter.cylinder_mechanisms_for_other_manufactures',
            function () {
                $filter = new FilterLensAggregator();
                $filter->addLens($this->app->make('catalog.filter_lens.price'));
                $filter->addLens($this->app->make('catalog.filter_lens.lock_type'));
                $filter->addLens($this->app->make('catalog.filter_lens.brands'));
                $filter->addLens($this->app->make('catalog.filter_lens.cylinder_size'));
                $filter->addLens($this->app->make('catalog.filter_lens.cylinder_mechanism'));
                $filter->addLens($this->app->make('catalog.filter_lens.color'));

                return $filter;
            }
        );*/

        //Замки
        /*$this->app->singleton(
            'catalog.filter.lock',
            function () {
                $filter = new FilterLensAggregator();
                $filter->addLens($this->app->make('catalog.filter_lens.price'));
                $filter->addLens($this->app->make('catalog.filter_lens.lock_type'));
                $filter->addLens($this->app->make('catalog.filter_lens.type_of_privacy_mechanism'));
                $filter->addLens($this->app->make('catalog.filter_lens.series'));
                $filter->addLens($this->app->make('catalog.filter_lens.latch'));

                return $filter;
            }
        );*/

        //Навесные замки
        /*$this->app->singleton(
            'catalog.filter.padlock',
            function () {
                $filter = new FilterLensAggregator();
                $filter->addLens($this->app->make('catalog.filter_lens.price'));
                $filter->addLens($this->app->make('catalog.filter_lens.lock_type'));
                $filter->addLens($this->app->make('catalog.filter_lens.cylinder_series'));
                $filter->addLens($this->app->make('catalog.filter_lens.type_of_privacy_mechanism'));
                $filter->addLens($this->app->make('catalog.filter_lens.series'));
                $filter->addLens($this->app->make('catalog.filter_lens.latch'));

                return $filter;
            }
        );*/

        //Декоративные накладки и поворотные ручки
        /*$this->app->singleton(
            'catalog.filter.decorative_onlay',
            function () {
                $filter = new FilterLensAggregator();
                $filter->addLens($this->app->make('catalog.filter_lens.price'));
                $filter->addLens($this->app->make('catalog.filter_lens.color'));

                return $filter;
            }
        );*/

        //Дверные ручки
       /* $this->app->singleton(
            'catalog.filter.door_handles',
            function () {
                $filter = new FilterLensAggregator();
                $filter->addLens($this->app->make('catalog.filter_lens.price'));
                $filter->addLens($this->app->make('catalog.filter_lens.brands'));
                $filter->addLens($this->app->make('catalog.filter_lens.color'));

                return $filter;
            }
        );*/

        //Броненакладки Cisa
        /*$this->app->singleton(
            'catalog.filter.armor_plates',
            function () {
                $filter = new FilterLensAggregator();
                $filter->addLens($this->app->make('catalog.filter_lens.price'));
                $filter->addLens($this->app->make('catalog.filter_lens.brands'));

                return $filter;
            }
        );*/


        $this->app->singleton(
            'catalog.filter_factory',
            function () {
                $filterFactory = new CatalogFilterFactory(
                    $this->app->make('catalog.filter.default')
                );

                //Цилиндровые механизмы
                $filterFactory->addFilter(Category::CILINDR_MEHANIZMY_1C_CODE, $this->app->make('catalog.filter.cylinder_mechanisms'));

                //Цилиндровые механизмы других производителей
//                $filterFactory->addFilter('25115', $this->app->make('catalog.filter.cylinder_mechanisms_for_other_manufactures'));


//                foreach (['25106', '25129', '25130', '25131', '25132', '25133'] as $catCode1c) {
//                    //Цилиндровые механизмы других производителей
//                    $filterFactory->addFilter($catCode1c, $this->app->make('catalog.filter.cylinder_mechanisms'));
//                }

                //Замки и ее подкатерории: Замки для алюминиевых дверей, Замки для деревянных дверей,
                // Замки для взломостойких дверей, Замки для металлических дверей
//                foreach (['21738', '21747', '21748', '21749', '21750'] as $categoryCode1c) {
//                    $filterFactory->addFilter($categoryCode1c, $this->app->make('catalog.filter.lock'));
//                }

                //Навесные замки
//                $filterFactory->addFilter('21740', $this->app->make('catalog.filter.padlock'));

                //Дверные ручки
//                $filterFactory->addFilter('24980', $this->app->make('catalog.filter.door_handles'));

                //Броненакладки Cisa
//                $filterFactory->addFilter('21739', $this->app->make('catalog.filter.armor_plates'));

                //Декоративные накладки и поворотные ручки
//                $filterFactory->addFilter('22374', $this->app->make('catalog.filter.decorative_onlay'));

                return $filterFactory;
            }
        );

        $this->app->bind(CatalogFilterFactory::class, 'catalog.filter_factory');
    }
}

<?php namespace App\Providers;

use App\Services\DataProviders\AttributeForm\AttributeForm;
use App\Services\DataProviders\AttributeForm\AttributeSubForm;
use App\Services\DataProviders\ClientProduct\ClientProduct;
use App\Services\DataProviders\ClientProduct\Plugins\Attributes;
use App\Services\DataProviders\ClientProduct\Plugins\ProductImages;
use App\Services\DataProviders\ClientProduct\Plugins\RelatedProducts;
use App\Services\DataProviders\ClientProductList\ClientProductList;
use App\Services\DataProviders\ClientProductList\Plugins as ClientProductListPlugins;
use App\Services\DataProviders\OrderForm\OrderForm;
use App\Services\DataProviders\OrderForm\OrderSubForm;
use App\Services\DataProviders\ProductForm\ProductForm;
use App\Services\DataProviders\ProductForm\ProductSubForm;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class DataProvidersServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ProductForm::class, function (Application $app) {
            $form = new ProductForm();
            $form->addSubForm($app->make(ProductSubForm\Categories::class));
            $form->addSubForm($app->make(ProductSubForm\Images::class));
            $form->addSubForm($app->make(ProductSubForm\Attributes::class));
            $form->addSubForm($app->make(ProductSubForm\RelatedProducts::class));

            return $form;
        });

        $this->app->bind(AttributeForm::class, function (Application $app) {
            $form = new AttributeForm();
            $form->addSubForm($app->make(AttributeSubForm\AllowedValues::class));
            $form->addSubForm($app->make(AttributeSubForm\DecimalScale::class));
            $form->addSubForm($app->make(AttributeSubForm\Units::class));
            $form->addSubForm($app->make(AttributeSubForm\Categories::class));

            return $form;
        });

        $this->app->bind(OrderForm::class);
        $this->app->extend(
            OrderForm::class,
            function (OrderForm $form) {
                $form->addSubForm($this->app->make(OrderSubForm\OrderItems::class));
                $form->addSubForm($this->app->make(OrderSubForm\Regions::class));

                return $form;
            }
        );


        //Client
        $this->app->bind(ClientProductList::class);
        $this->app->extend(
            ClientProductList::class,
            function (ClientProductList $productListProvider) {
                $productListProvider->addPlugin(
                    $this->app->make(ClientProductListPlugins\ProductTypePageAdditionalInfo::class)
                );

                return $productListProvider;
            }
        );


        $this->app->bind(ClientProduct::class, static function () {
            $productProvider = new ClientProduct();
                $productProvider->addPlugin(\App::make(ProductImages::class));
                $productProvider->addPlugin(\App::make(Attributes::class));
                $productProvider->addPlugin(\App::make(RelatedProducts::class));

                return $productProvider;
            }
        );
    }
}

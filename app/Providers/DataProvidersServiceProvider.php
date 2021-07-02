<?php namespace App\Providers;

use App\Services\DataProviders\AttributeForm\AttributeForm;
use App\Services\DataProviders\AttributeForm\AttributeSubForm;
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

            return $form;
        });

        $this->app->bind(AttributeForm::class, function (Application $app) {
            $form = new AttributeForm();
            $form->addSubForm($app->make(AttributeSubForm\AllowedValues::class));
            $form->addSubForm($app->make(AttributeSubForm\DecimalScale::class));
            $form->addSubForm($app->make(AttributeSubForm\Units::class));

            return $form;
        });
    }
}

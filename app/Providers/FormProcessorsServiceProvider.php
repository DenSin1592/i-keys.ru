<?php namespace App\Providers;

use App\Services\FormProcessors\AdminUser\AdminUserFormProcessor;
use App\Services\FormProcessors\Attribute\AttributeFormProcessor;
use App\Services\FormProcessors\Category\CategoryFormProcessor;
use App\Services\FormProcessors\ProductTypePage\ProductTypePageFormProcessor;
use App\Services\FormProcessors\Node\NodeFormProcessor;
use App\Services\FormProcessors\Product\ProductFormProcessor;
use App\Services\FormProcessors\Product\SubProcessor as ProductSubProcessor;
use App\Services\FormProcessors\Settings\SettingsFormProcessor;
use App\Services\FormProcessors\Attribute\SubProcessor as AttributeSubProcessor;
use App\Services\Repositories\ProductTypePage\CreateUpdateWrapper as ProductTypePageCreateUpdateWrapper;
use App\Services\Repositories\Setting\EloquentSettingRepository;
use App\Services\Repositories\AdminUser\CreateUpdateWrapper as AdminUserCrudWrapper;
use App\Services\Repositories\Node\CreateUpdateWrapper as NodeCreateUpdateWrapper;
use App\Services\Repositories\Category\CreateUpdateWrapper as CategoryCreateUpdateWrapper;
use App\Services\Repositories\Setting\CreateUpdateWrapper as SettingCreateUpdateWrapper;
use App\Services\Repositories\Attribute\CreateUpdateWrapper as AttributeCreateUpdateWrapper;
use App\Services\Repositories\Product\CreateUpdateWrapper as ProductCreateUpdateWrapper;
use App\Services\Settings\SettingContainer;
use App\Services\Validation\AdminUser\AdminUserLaravelValidator;
use App\Services\Validation\Attribute\AttributeLaravelValidator;
use App\Services\Validation\Category\CategoryLaravelValidator;
use App\Services\Validation\ProductTypePage\ProductTypePageLaravelValidator;
use App\Services\Validation\Node\NodeLaravelValidator;
use App\Services\Validation\Product\ProductLaravelValidator;
use App\Services\Validation\Setting\SettingsLaravelValidator;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use App\Services\FormProcessors\ProductTypePage\SubProcessor as ProductTypePageSubProcessor;

class FormProcessorsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            AdminUserFormProcessor::class,
            function () {
                return new AdminUserFormProcessor(
                    new AdminUserLaravelValidator($this->app['validator']),
                    $this->app->make(AdminUserCrudWrapper::class)
                );
            }
        );

        $this->app->bind(
            NodeFormProcessor::class,
            function () {
                return new NodeFormProcessor(
                    new NodeLaravelValidator($this->app['validator'], $this->app['structure_types.types']),
                    $this->app->make(NodeCreateUpdateWrapper::class),
                    $this->app['structure_types.types']
                );
            }
        );

        $this->app->bind(
            SettingsFormProcessor::class,
            function () {
                return new SettingsFormProcessor(
                    $this->app->make(SettingsLaravelValidator::class),
                    $this->app->make(SettingCreateUpdateWrapper::class),
                    $this->app->make(EloquentSettingRepository::class),
                    $this->app->make(SettingContainer::class)
                );
            }
        );

        $this->app->bind(CategoryFormProcessor::class, function (Application $app) {
            return new CategoryFormProcessor(
                new CategoryLaravelValidator($app['validator']),
                $app->make(CategoryCreateUpdateWrapper::class)
            );
        });

        $this->app->bind(ProductFormProcessor::class, function (Application $app) {
            $formProcessor = new ProductFormProcessor(
                new ProductLaravelValidator($app['validator']),
                $app->make(ProductCreateUpdateWrapper::class)
            );
            $formProcessor->addSubProcessor($app->make(ProductSubProcessor\Images::class));
            $formProcessor->addSubProcessor($app->make(ProductSubProcessor\Attributes::class));
            $formProcessor->addSubProcessor($app->make(ProductSubProcessor\RelatedProducts::class));

            return $formProcessor;
        });

        $this->app->bind(
            ProductTypePageFormProcessor::class,
            function (Application $app) {
                $productTypePageFormProcessor = new ProductTypePageFormProcessor(
                    $app->make(ProductTypePageLaravelValidator::class),
                    $app->make(ProductTypePageCreateUpdateWrapper::class)
                );
                $productTypePageFormProcessor->addSubProcessor(
                    $app->make(ProductTypePageSubProcessor\Products::class)
                );

                return $productTypePageFormProcessor;
            }
        );

        $this->app->bind(AttributeFormProcessor::class, function (Application $app) {
            $formProcessor = new AttributeFormProcessor(
                new AttributeLaravelValidator($app['validator']),
                $app->make(AttributeCreateUpdateWrapper::class)
            );
            $formProcessor->addSubProcessor(
                $app->make(AttributeSubProcessor\AllowedValues::class)
            );
            $formProcessor->addSubProcessor(
                $app->make(AttributeSubProcessor\DecimalScale::class)
            );
            $formProcessor->addSubProcessor(
                $app->make(AttributeSubProcessor\Categories::class)
            );

            return $formProcessor;
        });
    }
}

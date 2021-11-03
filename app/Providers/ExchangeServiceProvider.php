<?php

namespace App\Providers;

use App\Services\Exchange\Core\HandlerCollector;
use App\Services\Exchange\CsvHandler\CsvHandlerFactory;
use App\Services\Exchange\DirectoryHandler\ExportDirectoryHandler;
use App\Services\Exchange\DirectoryHandler\ImportDirectoryHandler;
use App\Services\Exchange\DirectoryHandler\ImportImagesDirectory\ImportProductImagesDirectory;
use App\Services\Exchange\DirectoryHandler\ImportImagesDirectoryHandler;
use App\Services\Exchange\StatusHandler\ExportStatusHandler;
use App\Services\Exchange\StatusHandler\ImportStatusHandler;
use App\Services\Exchange\Locker\LockHandler;
use App\Services\Exchange\Realization\TypeHandlerFactory\Export;
use App\Services\Exchange\Realization\TypeHandlerFactory\Import;
use App\Services\Exchange\Runner\ExportRunner;
use App\Services\Exchange\Runner\ImportRunner;
use App\Services\Exchange\Logger\ExportLogger;
use App\Services\Exchange\Logger\ImportLogger;
use App\Services\Repositories\Product\EloquentProductRepository;
use Illuminate\Support\ServiceProvider;

class ExchangeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(
            CsvHandlerFactory::class,
            function () {
                return new CsvHandlerFactory('cp1251', 'utf-8', false);
            }
        );

        $this->registerLockStatusHandlers();
        $this->registerStatusHandlers();
        $this->registerDirectoriesHandlers();
        $this->registerHandlerFactories();

        $this->app->singleton(
            ImportRunner::class,
            function ($app) {
                return new ImportRunner(
                    $app->make('exchange.import.handler_collector'),
                    $app->make('exchange.import_lock'),
                    $app->make(ImportLogger::class),
                    $app->make(EloquentProductRepository::class)
                );
            }
        );

        $this->app->singleton(
            ExportRunner::class,
            function ($app) {
                return new ExportRunner(
                    $app->make('exchange.export.handler_collector'),
                    $app->make('exchange.export_lock'),
                    $app->make(ExportLogger::class)
                );
            }
        );

    }

    private function registerLockStatusHandlers()
    {
        $this->app->singleton(
            'exchange.import_lock',
            function () {
                return new LockHandler(storage_path('exchange/status/import.lock'));
            }
        );

        $this->app->singleton(
            'exchange.export_lock',
            function () {
                return new LockHandler(storage_path('exchange/status/export.lock'));
            }
        );
    }

    private function registerStatusHandlers()
    {
        $this->app->singleton(
            ImportStatusHandler::class,
            function () {
                return new ImportStatusHandler(storage_path('exchange/status/import_status.json'));
            }
        );

        $this->app->singleton(
            ExportStatusHandler::class,
            function () {
                return new ExportStatusHandler(storage_path('exchange/status/export_status.json'));
            }
        );
    }

    private function registerDirectoriesHandlers()
    {
        $this->app['exchange.dir.import'] = storage_path('exchange/import');
        $this->app['exchange.dir.import_trash'] = storage_path('exchange/import_trash');
        $this->app['exchange.dir.import.images'] = storage_path('exchange/import/images');
        $this->app['exchange.dir.import_trash.images'] = storage_path('exchange/import_trash/images');
        $this->app['exchange.dir.export'] = storage_path('exchange/export');
        $this->app['exchange.dir.export_tmp'] = storage_path('exchange/export_tmp');

        $this->app->singleton(
            ImportDirectoryHandler::class,
            function () {
                return new ImportDirectoryHandler(
                    $this->app['exchange.dir.import'],
                    $this->app['exchange.dir.import_trash']
                );
            }
        );

        $this->app->singleton(
            ImportImagesDirectoryHandler::class,
            function () {
                return new ImportImagesDirectoryHandler(
                    $this->app['exchange.dir.import.images'],
                    $this->app['exchange.dir.import_trash.images']
                );
            }
        );

        $this->app->singleton(
            ImportProductImagesDirectory::class,
            function () {
                $subDirectory = 'products';

                return new ImportProductImagesDirectory(
                    $this->app['exchange.dir.import.images'] . DIRECTORY_SEPARATOR . $subDirectory,
                    $this->app['exchange.dir.import_trash.images'] . DIRECTORY_SEPARATOR . $subDirectory
                );
            }
        );

        $this->app->singleton(
            ExportDirectoryHandler::class,
            function () {
                return new ExportDirectoryHandler(
                    $this->app['exchange.dir.export'],
                    $this->app['exchange.dir.export_tmp']
                );
            }
        );
    }

    private function registerHandlerFactories()
    {
        $this->app->singleton(
            'exchange.import.handler_collector',
            function () {
                $handlerCollector = new HandlerCollector();

                $handlerCollector->addTypeHandlerFactory(
                    $this->app->make(Import\CategoryHandlerFactory::class)
                );
                $handlerCollector->addTypeHandlerFactory(
                    $this->app->make(Import\ProductHandlerFactory::class)
                );
                $handlerCollector->addTypeHandlerFactory(
                    $this->app->make(Import\AttributeHandlerFactory::class)
                );
                $handlerCollector->addTypeHandlerFactory(
                    $this->app->make(Import\AttributeValueHandlerFactory::class)
                );
                $handlerCollector->addTypeHandlerFactory(
                    $this->app->make(Import\ProductImageHandlerFactory::class)
                );

                return $handlerCollector;
            }
        );

        $this->app->singleton(
            'exchange.export.handler_collector',
            function () {
                $handlerCollector = new HandlerCollector();
                $handlerCollector->addTypeHandlerFactory(
                    $this->app->make(Export\OrderHandlerFactory::class)
                );

                return $handlerCollector;
            }
        );
    }
}

<?php

namespace App\Services\Exchange\Runner;

use App\Models\Product;
use App\Services\Exchange\Core\HandlerCollector;
use App\Services\Exchange\Locker\LockHandler;
use App\Services\Exchange\Logger\ImportLogger;
use App\Services\Repositories\Product\EloquentProductRepository;

/**
 * Class ImportRunner
 * @package App\Services\Exchange\Runner
 */
class ImportRunner extends BasicRunner
{
    private $productRepository;

    public function __construct(
        HandlerCollector $handlerCollector,
        LockHandler $lockStatusHandler,
        ImportLogger $logger,
        EloquentProductRepository $productRepository
    ) {
        parent::__construct($handlerCollector, $lockStatusHandler, $logger);

        $this->productRepository = $productRepository;
    }

    protected function exchangeRunner(): void
    {
        Product::withoutSyncingToSearch(
            function () {
                parent::exchangeRunner();
            }
        );
        $this->updateProductSearchIndex();
    }

    private function updateProductSearchIndex(): void
    {
        $products = $this->productRepository->getAllForUpdateSearch();
        foreach ($products as $product) {
            /** @var Product $product */
            // search index will be changed automatically
            $product->refreshNameWithAttributes();
            // if there is no need in $product->refreshNameWithAttributes()
            // to change search index for product use:
//            if ($product->shouldBeSearchable()) {
//                $product->searchable();
//            } else {
//                $product->unsearchable();
//            }
        }
        $this->productRepository->unmarkUpdateSearchForAll();
    }
}

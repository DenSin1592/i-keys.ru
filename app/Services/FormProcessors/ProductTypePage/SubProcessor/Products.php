<?php namespace App\Services\FormProcessors\ProductTypePage\SubProcessor;

use App\Models\ProductTypePage;
use App\Services\FormProcessors\ProductTypePage\SubProcessor;
use App\Services\Repositories\Product\EloquentProductRepository;
use App\Services\Repositories\ProductTypePageAssociation\EloquentProductTypePageAssociationRepository;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CProducts
 * @package App\Services\FormProcessors\ProductTypePage\Plugins
 */
class Products implements SubProcessor
{
    private $productRepository;
    private $prodTypePageAssociationRepo;

    /**
     * Products constructor.
     * @param EloquentProductRepository $productRepository
     * @param EloquentProductTypePageAssociationRepository $prodTypePageAssociationRepo
     */
    public function __construct(
        EloquentProductRepository $productRepository,
        EloquentProductTypePageAssociationRepository $prodTypePageAssociationRepo
    ) {
        $this->productRepository = $productRepository;
        $this->prodTypePageAssociationRepo = $prodTypePageAssociationRepo;
    }

    public function prepareInputData(array $inputData):array
    {
        return $inputData;
    }

    /**
     * Save data for form processor.
     *
     * @param ProductTypePage $productTypePage
     * @param array $data
     */
    public function save(ProductTypePage $productTypePage, array $data)
    {
        switch ($productTypePage->product_list_way) {
            case ProductTypePage::WAY_MANUAL:
                if (\Arr::get($data, 'manual_products_opened', 0)) {
                    $this->updateManualProducts($productTypePage, \Arr::get($data, 'manual_products'));
                    $this->updateAssociatedProducts($productTypePage, \Arr::get($data, 'product_associations.manual'));
                }
                break;
            case ProductTypePage::WAY_FILTERED:
                $this->updateAssociatedProducts($productTypePage, \Arr::get($data, 'product_associations.filtered'));
                break;
        }
    }

    private function updateManualProducts(ProductTypePage $productTypePage, $manualProducts)
    {
        if (!is_array($manualProducts)) {
            $manualProducts = [];
        }

        $productTypePage->manualProducts()->sync($manualProducts);
    }

    private function updateAssociatedProducts(ProductTypePage $productTypePage, $associationListData)
    {
        if (is_null($associationListData) ||
            !is_array($associationListData) ||
            count($associationListData) == 0
        ) {
            return;
        }

        $productIds = array_keys($associationListData);
        /** @var Collection $products */
        $products = $this->productRepository->byIds($productIds)->keyBy('id');
        foreach ($associationListData as $productId => $associationData) {
            $product = $products->get($productId);
            if (is_null($product)) {
                continue;
            }

            if (!is_array($associationData)) {
                $associationData = [];
            }
            $cleanAssociationData = array_filter(
                $associationData,
                function ($e) {
                    return $e !== null;
                }
            );

            if (count($cleanAssociationData) > 0) {
                $this->prodTypePageAssociationRepo->createOrUpdateForPageAndProduct(
                    $productTypePage,
                    $product,
                    $associationData
                );
            } else {
                $this->prodTypePageAssociationRepo->deleteForPageAndProduct($productTypePage, $product);
            }
        }
    }
}

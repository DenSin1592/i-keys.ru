<?php namespace App\Services\DataProviders\ClientProductList\Plugins;

use App\Models\ProductTypePage;
use App\Services\DataProviders\ClientProductList\ClientProductListPlugin;
use App\Services\Repositories\ProductTypePageAssociation\EloquentProductTypePageAssociationRepository;

class ProductTypePageAdditionalInfo implements ClientProductListPlugin
{
    private $productTypePageAssociationRepo;

    public function __construct(EloquentProductTypePageAssociationRepository $productTypePageAssociationRepo)
    {
        $this->productTypePageAssociationRepo = $productTypePageAssociationRepo;
    }

    public function getForProductsList($products, array $additionalData = []): array
    {
        $productTypePage = \Arr::get($additionalData, 'productTypePage');
        if (is_null($productTypePage) || !$productTypePage instanceof ProductTypePage) {
            return [];
        }

        $productIds = [];
        foreach ($products as $product) {
            $productIds[] = $product->id;
        }
        $productAssociations = $this->productTypePageAssociationRepo->getAssociationsForPageAndProducts(
            $productTypePage,
            $productIds
        );

        $additionalInfo = [];
        foreach ($productAssociations as $prodAssoc) {
            $prodAdditionalInfo = [];
            if (!empty($prodAssoc->name)) {
                $prodAdditionalInfo['name'] = $prodAssoc->name;
            }

            if (count($prodAdditionalInfo) > 0) {
                $additionalInfo[$prodAssoc->product_id] = $prodAdditionalInfo;
            }
        }

        return ['productTypePageAdditionalInfo' => $additionalInfo];
    }
}

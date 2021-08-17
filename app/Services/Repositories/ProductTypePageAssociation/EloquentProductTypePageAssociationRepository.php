<?php namespace App\Services\Repositories\ProductTypePageAssociation;

use App\Models\Product;
use App\Models\ProductTypePage;
use App\Models\ProductTypePageAssociation;
use Illuminate\Database\Eloquent\Collection;

class EloquentProductTypePageAssociationRepository
{
    public function groupedByProductsForPage(ProductTypePage $page, $products)
    {
        $productIds = [];
        foreach ($products as $product) {
            $productIds[] = $product->id;
        }

        if (count($productIds) === 0) {
            $productIds = [null];
        }

        $associations = $page->productTypePageAssociations()
            ->whereIn('product_type_page_associations.product_id', $productIds)->get();

        $groupedAssociations = [];
        foreach ($associations as $association) {
            $groupedAssociations[$association->product_id] = $association;
        }

        foreach ($products as $product) {
            if (!isset($groupedAssociations[$product->id])) {
                $groupedAssociations[$product->id] = $this->newForPageAndProduct($page, $product);
            }
        }

        return $groupedAssociations;
    }

    public function findForPageAndProduct(ProductTypePage $page, Product $product)
    {
        return ProductTypePageAssociation::query()
            ->where('product_type_page_id', $page->id)
            ->where('product_id', $product->id)
            ->first();
    }

    public function newForPageAndProduct(ProductTypePage $page, Product $product): ProductTypePageAssociation
    {
        $association = new ProductTypePageAssociation();
        $association->product()->associate($product);
        $association->productTypePage()->associate($page);

        return $association;
    }

    public function findOrNewForPageAndProduct(ProductTypePage $page, Product $product): ProductTypePageAssociation
    {
        $association = $this->findForPageAndProduct($page, $product);
        if (is_null($association)) {
            $association = $this->newForPageAndProduct($page, $product);
        }

        return $association;
    }

    public function createOrUpdateForPageAndProduct(
        ProductTypePage $page,
        Product $product,
        array $data = []
    ): ProductTypePageAssociation {
        $association = $this->findOrNewForPageAndProduct($page, $product);
        $association->fill($data);
        $association->save();

        return $association;
    }

    public function deleteForPageAndProduct(ProductTypePage $page, Product $product)
    {
        $association = $this->findForPageAndProduct($page, $product);
        if (!is_null($association)) {
            $association->delete();
        }
    }

    /**
     * @inheritdoc
     */
    public function getAssociationsForPageAndProducts(ProductTypePage $productTypePage, array $productIds): Collection
    {
        if (count($productIds) === 0) {
            return Collection::make([]);
        }

        return $productTypePage->productTypePageAssociations()
            ->whereIn('product_id', $productIds)
            ->get();
    }
}

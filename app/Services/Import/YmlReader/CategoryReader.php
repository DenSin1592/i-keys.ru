<?php namespace App\Services\Import\YmlReader;

use App\Services\Import\YmlReader\CollectionIterator\CollectionIterator;

/**
 * Class CategoryReader
 * Reader for categories from YML files.
 *
 * @package App\Services\Import\YmlReader\YmlReader
 */
class CategoryReader
{
    const LIST_TAG = 'categories';
    const ELEMENT_TAG = 'category';

    /**
     * Get categories structure from YML file.
     * Each element in result array has id, parentId, name and list of parents.
     * In list of parents last parent is a top level parent.
     *
     * @param $file
     * @return array
     */
    public function getCategories($file)
    {
        $categories = new CollectionIterator($file, self::LIST_TAG, self::ELEMENT_TAG);
        $rawCategories = [];
        foreach ($categories as $categoryXml) {
            $category = $this->getCategory($categoryXml);
            $rawCategories[$category['id']] = $category;
        }
        $categoriesStructure = $this->buildCategoriesStructure($rawCategories);

        return $categoriesStructure;
    }


    /**
     * Get category from XML-element.
     *
     * @param \SimpleXMLElement $categoryElement
     * @return array
     */
    private function getCategory(\SimpleXMLElement $categoryElement)
    {
        $categoryAttributes = $categoryElement->attributes();
        $id = isset($categoryAttributes['id']) ? (string) $categoryAttributes['id'] : null;
        $parentId = isset($categoryAttributes['parentId']) ? (string) $categoryAttributes['parentId'] : null;

        return [
            'id' => $id,
            'parentId' => $parentId,
            'name' => (string) $categoryElement,
        ];
    }


    /**
     * Build categories structure.
     *
     * @param array $rawCategories
     * @return array
     */
    private function buildCategoriesStructure(array $rawCategories)
    {
        $categoriesStructure = [];
        foreach ($rawCategories as $rawCategory) {
            $parents = [];
            $tmpCat = $rawCategory;
            while (!is_null($tmpCat['parentId']) && isset($rawCategories[$tmpCat['parentId']])) {
                $tmpCat = $rawCategories[$tmpCat['parentId']];
                $parents[] = $tmpCat['id'];
            }
            $rawCategory['parents'] = $parents;
            $categoriesStructure[$rawCategory['id']] = $rawCategory;
        }

        return $categoriesStructure;
    }
}

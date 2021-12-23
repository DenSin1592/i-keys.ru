<?php

namespace App\Services\DataProviders\ClientProductList\Plugins;

use App\Models\Attribute\AttributeConstants;
use App\Models\Product;
use App\Services\DataProviders\ClientProductList\ClientProductListPlugin;


class Colors implements ClientProductListPlugin
{

    public function getForProductsList($products, array $additionalData = []): array
    {
        $array = [];

        foreach ($products as $element){
            if($element->isCylinder()){
                $colors = $this->getDataForCylinder($element);
                if(!empty($colors)){
                    $array[$element->id] = $colors;
                }
            }
        }

        return ['colors' => $array];
    }


    private function getDataForCylinder($product)
    {
        $seriesCylinderValueId = $product->getIdSingleValues(AttributeConstants::CYLINDER_SERIES_ID);
        $cylinderOpeningTypeValueId = $product->getIdSingleValues(AttributeConstants::CYLINDER_OPENING_TYPE_ID);
        $sizeCylinderValueId = $product->getIdSingleValues(AttributeConstants::SIZE_CYLINDER_ID);

        $attrSingleValSeriesCylinder = 'attribute_single_values'.AttributeConstants::CYLINDER_SERIES_ID;
        $attrSingleValCylinderOpeningType = 'attribute_single_values'.AttributeConstants::CYLINDER_OPENING_TYPE_ID;
        $attrSingleValSizeCylinder = 'attribute_single_values'.AttributeConstants::SIZE_CYLINDER_ID;

        $products = Product::query()
            ->leftJoin("attribute_single_values as $attrSingleValSeriesCylinder", static function ($join) use ($attrSingleValSeriesCylinder,){
                $join->on(
                    'products.id',
                    '=',
                    "{$attrSingleValSeriesCylinder}.product_id")
                    ->where("{$attrSingleValSeriesCylinder}.attribute_id", '=', AttributeConstants::CYLINDER_SERIES_ID);
            })->leftJoin("attribute_single_values as $attrSingleValCylinderOpeningType", static function ($join) use ($attrSingleValCylinderOpeningType,){
                $join->on(
                    'products.id',
                    '=',
                    "{$attrSingleValCylinderOpeningType}.product_id")
                    ->where("{$attrSingleValCylinderOpeningType}.attribute_id", '=', AttributeConstants::CYLINDER_OPENING_TYPE_ID);
            })->leftJoin("attribute_single_values as $attrSingleValSizeCylinder", static function ($join) use ($attrSingleValSizeCylinder,){
                $join->on(
                    'products.id',
                    '=',
                    "{$attrSingleValSizeCylinder}.product_id")
                    ->where("{$attrSingleValSizeCylinder}.attribute_id", '=', AttributeConstants::SIZE_CYLINDER_ID);
            })->leftJoin("attribute_single_values", static function ($join){
                $join->on(
                    'products.id',
                    '=',
                    "attribute_single_values.product_id")
                    ->where("attribute_single_values.attribute_id", '=', AttributeConstants::COLOR_ID);
            })->leftJoin('attribute_allowed_values', 'attribute_allowed_values.id', '=', 'attribute_single_values.value_id')
            ->where('products.publish','=', true)
            ->where("{$attrSingleValSeriesCylinder}.value_id", '=', $seriesCylinderValueId)
            ->where("{$attrSingleValCylinderOpeningType}.value_id", '=', $cylinderOpeningTypeValueId)
            ->where("{$attrSingleValSizeCylinder}.value_id", '=', $sizeCylinderValueId)
            ->select('products.*', 'attribute_allowed_values.id as attr_id', 'attribute_allowed_values.value as attr_name' )
            ->get();


        if($products->count() === 0 ){
            return [];
        }


        $colors = [];
        foreach ($products as $element){
            $colors[] = [
                'product_id' => $element->id,
                'attr_name' => $element->attr_name,
                'isActive' => $product->id === $element->id,
                'imgPath' => match ($element->attr_id){
                    AttributeConstants::COLOR_LATUN_ID => asset('/uploads/colors/color-brown.png'),
                    AttributeConstants::COLOR_NICKEL_ID => asset('/uploads/colors/color-silver.png'),
                    'default' => '',
                }
            ];
        }


      return $colors;
    }
}


//select distinct `products`.*, `attribute_allowed_values`.`value`
//  from `products`
//
//  left join `attribute_single_values` as `attr_single_val_27_61c3114f51bd7`
//    on `products`.`id` = `attr_single_val_27_61c3114f51bd7`.`product_id` and `attr_single_val_27_61c3114f51bd7`.`attribute_id` = 27
//  left join `attribute_single_values` as `attr_single_val_35_61c3114f51d4a`
//    on `products`.`id` = `attr_single_val_35_61c3114f51d4a`.`product_id` and `attr_single_val_35_61c3114f51d4a`.`attribute_id` = 35
//  left join `attribute_single_values` as `attr_single_val_32_61c3114f51e89`
//    on `products`.`id` = `attr_single_val_32_61c3114f51e89`.`product_id` and `attr_single_val_32_61c3114f51e89`.`attribute_id` = 32
//  left join `attribute_single_values`
//    on `products`.`id` = `attribute_single_values`.`product_id` and `attribute_single_values`.`attribute_id` = 37
//  left join `attribute_allowed_values`
//    on `attribute_allowed_values`.`id` = `attribute_single_values`.value_id

//where  `products`.`publish` = 1
//and `attr_single_val_27_61c3114f51bd7`.`value_id` = 20
//and `attr_single_val_35_61c3114f51d4a`.`value_id` = 57
//and `attr_single_val_32_61c3114f51e89`.`value_id` = 17;








//select distinct `products`.*
//  from `products`
//  left join `categories_ancestors`
//    on `categories_ancestors`.`descendant_id` = `products`.`category_id`
//  inner join `categories`
//    on `categories`.`id` = `products`.`category_id`
//  left join `attribute_single_values` as `attr_single_val_27_61c3114f51bd7`
//    on `products`.`id` = `attr_single_val_27_61c3114f51bd7`.`product_id` and `attr_single_val_27_61c3114f51bd7`.`attribute_id` = 27
//  left join `attribute_single_values` as `attr_single_val_35_61c3114f51d4a`
//    on `products`.`id` = `attr_single_val_35_61c3114f51d4a`.`product_id` and `attr_single_val_35_61c3114f51d4a`.`attribute_id` = 35
//  inner join `attribute_allowed_values` as `attr_single_val_35_61c3114f51d4a_attr_all_val`
//    on `attr_single_val_35_61c3114f51d4a_attr_all_val`.`id` = `attr_single_val_35_61c3114f51d4a`.`value_id`
//  left join `attribute_single_values` as `attr_single_val_32_61c3114f51e89`
//    on `products`.`id` = `attr_single_val_32_61c3114f51e89`.`product_id` and `attr_single_val_32_61c3114f51e89`.`attribute_id` = 32
//
// where (`products`.`category_id` = 5 or `categories_ancestors`.`ancestor_id` = 5)
// and `categories`.`in_tree_publish` = 1
// and `products`.`publish` = 1
// and `attr_single_val_27_61c3114f51bd7`.`value_id` in ('20')
// and `attr_single_val_35_61c3114f51d4a_attr_all_val`.`value_first_size_cylinder` = '30'
// and `attr_single_val_35_61c3114f51d4a_attr_all_val`.`value_second_size_cylinder` = '40'
// and `attr_single_val_32_61c3114f51e89`.`value_id` in ('17');



//$attributes = Attribute::query()
//    ->join('attribute_category', 'attribute_category.attribute_id', '=', 'attributes.id')
//    ->whereIn('attribute_category.category_id', $categoryIds)
//    ->orderBy('attributes.position')->select('attributes.*')->distinct()->get();


//SELECT DISTINCT `attribute_allowed_values`.`value`
//  FROM `attribute_allowed_values`
//  INNER JOIN `attribute_single_values` ON `attribute_single_values`.`value_id` = `attribute_allowed_values`.`id`
//    and `attribute_single_values`.`attribute_id` = 37
//    and `attribute_single_values`.`product_id` in (
//        select `products`.`id`
//          from `products`
//          left join `categories_ancestors` on `categories_ancestors`.`descendant_id` = `products`.`category_id`
//          inner join `categories` on `categories`.`id` = `products`.`category_id`
//          inner join `attribute_single_values` on `attribute_single_values`.`product_id` = `products`.`id`
//          inner join `attribute_allowed_values` on `attribute_allowed_values`.`id` = `attribute_single_values`.`value_id`
//             AND `attribute_allowed_values`.`value` = 'ASTRAL'
//           where (`products`.`category_id` = 9 or `categories_ancestors`.`ancestor_id` = 9))
;

//select distinct `products`.*
// from `products`
// left join `categories_ancestors` on `categories_ancestors`.`descendant_id` = `products`.`category_id`
// inner join `categories` on `categories`.`id` = `products`.`category_id`
// where (`products`.`category_id` = 9 or `categories_ancestors`.`ancestor_id` = 9)
// and `categories`.`in_tree_publish` = 1
// and `products`.`publish` = 1
// order by (ISNULL(products.price) OR products.price=0) ASC, `products`.`price` asc limit 11 offset 0


/*select `products`.`id`
          from `products`
          left join `categories_ancestors` on `categories_ancestors`.`descendant_id` = `products`.`category_id`
          inner join `categories` on `categories`.`id` = `products`.`category_id`
          inner join `attribute_single_values` on `attribute_single_values`.`product_id` = `products`.`id`
          inner join `attribute_allowed_values` on `attribute_allowed_values`.`id` = `attribute_single_values`.`value_id`
AND `attribute_allowed_values`.`value` = 'ASTRAL'
           where (`products`.`category_id` = 10 or `categories_ancestors`.`ancestor_id` = 10) ORDER BY `category_id`  ASC */


//select distinct *
//from `products`
     //left join `categories_ancestors` on `categories_ancestors`.`descendant_id` = `products`.`category_id`
     //inner join `categories`
     //  on `categories`.`id` = `products`.`category_id`
//left join `attribute_single_values` as `attr_single_val_27_61c30965c624b`
//  on `products`.`id` = `attr_single_val_27_61c30965c624b`.`product_id`
//and `attr_single_val_27_61c30965c624b`.`attribute_id` = 27
//left join `attribute_single_values` as `attr_single_val_37_61c30965c63f5`
//  on `products`.`id` = `attr_single_val_37_61c30965c63f5`.`product_id`
//and `attr_single_val_37_61c30965c63f5`.`attribute_id` = 37
//
     //where (`products`.`category_id` = 5 or `categories_ancestors`.`ancestor_id` = 5)
     //and `categories`.`in_tree_publish` = 1 and `products`.`publish` = 1
//and `attr_single_val_27_61c30965c624b`.`value_id` in ('20')
//and `attr_single_val_37_61c30965c63f5`.`value_id` in ('8') ORDER BY `category_id`  ASC


//select distinct `products`.* from `products` left join `categories_ancestors` on `categories_ancestors`.`descendant_id` = `products`.`category_id` inner join `categories` on `categories`.`id` = `products`.`category_id` left join `attribute_single_values` as `attr_single_val_27_61c3114f51bd7` on `products`.`id` = `attr_single_val_27_61c3114f51bd7`.`product_id` and `attr_single_val_27_61c3114f51bd7`.`attribute_id` = 27 left join `attribute_single_values` as `attr_single_val_35_61c3114f51d4a` on `products`.`id` = `attr_single_val_35_61c3114f51d4a`.`product_id` and `attr_single_val_35_61c3114f51d4a`.`attribute_id` = 35 inner join `attribute_allowed_values` as `attr_single_val_35_61c3114f51d4a_attr_all_val` on `attr_single_val_35_61c3114f51d4a_attr_all_val`.`id` = `attr_single_val_35_61c3114f51d4a`.`value_id` left join `attribute_single_values` as `attr_single_val_32_61c3114f51e89` on `products`.`id` = `attr_single_val_32_61c3114f51e89`.`product_id` and `attr_single_val_32_61c3114f51e89`.`attribute_id` = 32 where (`products`.`category_id` = 5 or `categories_ancestors`.`ancestor_id` = 5) and `categories`.`in_tree_publish` = 1 and `products`.`publish` = 1 and `attr_single_val_27_61c3114f51bd7`.`value_id` in ('20') and `attr_single_val_35_61c3114f51d4a_attr_all_val`.`value_first_size_cylinder` = '30' and `attr_single_val_35_61c3114f51d4a_attr_all_val`.`value_second_size_cylinder` = '40' and `attr_single_val_32_61c3114f51e89`.`value_id` in ('17') order by (ISNULL(products.price) OR products.price=0) ASC, `products`.`price` asc limit 11 offset 0

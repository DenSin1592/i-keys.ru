<?php

namespace App\Models;

use App\Models\Helpers\AliasHelpers;
use App\Models\Product\CategoryTools;
use App\Models\Product\HasAttributeValues;
use App\Models\Features\AutoPublish;
use App\Models\Helpers\DeleteHelpers;
use App\Models\Product\Search;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use AutoPublish;
    use HasAttributeValues;
    use CategoryTools;
    use Search;


    const VIEW_LIST = 'list';

    protected $fillable = [
        'category_id',
        'name',
        'alias',
        'position',
        'publish',
        'price',
        'description',
        'header',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'extra_description',
        'code_1c',
        'old_price',
        'best_prod',
        'existence',
    ];


    public function getNameWithCode1cAttribute()
    {
        $name = '';
        if (isset($this->code_1c) && $this->code_1c !== '') {
            $name .= "[{$this->code_1c}] ";
        }
        $name .= $this->name;

        return $name;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function relatedProducts()
    {
        return $this->belongsToMany(
            Product::class,
            'related_products',
            'product_id',
            'attached_product_id'
        );
    }


    public function relatedProductsReverse()
    {
        return $this->belongsToMany(
            Product::class,
            'related_products',
            'attached_product_id',
            'product_id'
        );
    }


    public function typePages()
    {
        return $this->belongsToMany(
            ProductTypePage::class,
            'product_type_page_manual',
            'product_id',
            'product_type_page_id',
        );
    }


    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }


    public function getFirstImagePath(string $field, ?string $version, string $noImageVersion): string
    {
        $image = $this->images->first();
        if($image instanceof ProductImage){
            return $image->getImgPath($field, $version, $noImageVersion);
        }

        return asset('/images/common/no-image/' . $noImageVersion);
    }


    public function getOldPrice(): ?string
    {
        return $this->old_price > $this->price ? $this->old_price : null;
    }


    public function getSaleStringAttribute(): ?string
    {
        if(is_null($this->getOldPrice())) return null;

        $sale = (int) (100 - ($this->price / $this->getOldPrice() * 100));

        if ($sale === 0) return null;

        return "Экономия ${sale}%";
    }


    public function orderItem()
    {
        return $this->hasMany(OrderItem::class,);
    }


    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    public function getExistenceString(): string
    {
        return trans("validation.model_attributes.product.existence.{$this->existence}");
    }


    public function toSearchableArray()
    {
        $searchableArray = $this->only(
            [
                'name',
                'code_1c',
                'description',
                'header',
                'name_with_attributes',
                'available',
                'category_id',
            ]
        );

        return $searchableArray;
    }


    public function getMapping()
    {
        $mappings = $this->sourceGetMapping();

        $textFieldMapping = [
            'type' => 'text',
            'fields' => [
                'russian' => [
                    'type' => 'text',
                    'analyzer' => 'russian_analyzer',
                ],
                'english' => [
                    'type' => 'text',
                    'analyzer' => 'english_analyzer',
                ],
            ]
        ];

        $booleanFieldMapping = [
            'type' => 'boolean',
        ];

        $mappings = array_merge_recursive(
            $mappings,
            [
                'properties' => [
                    'code_1c' => $textFieldMapping,
                    'name' => $textFieldMapping,
                    'name_with_attributes' => $textFieldMapping,
                    'available' => $booleanFieldMapping,
                    'header' => collect($textFieldMapping)->put('boost', 0.1)->all(),
                    'description' => collect($textFieldMapping)->put('boost', 0.1)->all(),
                ]
            ]
        );

        return $mappings;
    }


    public function generateNameWithAttributes(): void
    {
        $this->name_with_attributes = $this->getNameWithAttributes();
    }


    public function refreshNameWithAttributes(): void
    {
        $this->generateNameWithAttributes();
        $this->save();
    }


    public function getNameWithAttributes()
    {
        $attributeValues = [];

        $stringAttrValues = $this->attributeStringValues()->with('attribute')->get();
        $integerAttrValues = $this->attributeIntegerValues()->with('attribute')->get();
        $decimalAttrValues = $this->attributeDecimalValues()->with('attribute')->get();
        $singeAttrValues = $this->attributeSingleValues()->with(['attribute', 'allowedValue'])->get();
        $multipleAttrValues = $this->attributeMultipleValues()->with(['attribute', 'allowedValue'])->get();

        foreach ([$stringAttrValues, $integerAttrValues, $decimalAttrValues] as $attrValues) {
            foreach ($attrValues as $attrValue) {
                $attributeValues[$attrValue->attribute->name][] = $attrValue->value;
            }
        }

        foreach ([$singeAttrValues, $multipleAttrValues] as $attrValues) {
            foreach ($attrValues as $attrValue) {
                $attributeValues[$attrValue->attribute->name][] = $attrValue->allowedValue->value;
            }
        }

        $attributesWithValues = '';
        foreach ($attributeValues as $name => $value) {
            $attributesWithValues .= " {$name} " . implode(' ', (array)$value);
        }

        return "{$this->name} {$attributesWithValues}";
    }


    public function shouldBeSearchable()
    {
        return $this->publish && $this->category->in_tree_publish;
    }


    protected static function boot()
    {
        parent::boot();

        self::deleting(function (self $product) {
            \DB::transaction(static function() use ($product) {
                self::bootHasAttributeValues();
                DeleteHelpers::deleteRelatedAll($product->images());
                DeleteHelpers::deleteRelatedAll($product->orderItem());
                DeleteHelpers::deleteRelatedAll($product->reviews());
                $product->relatedProducts()->detach();
                $product->relatedProductsReverse()->detach();
                $product->typePages()->detach();
            });
        });


        self::saving(function (self $product) {
            AliasHelpers::setAlias($product);
        });
    }
}

<?php

namespace App\Models\Product;

use App\Services\Search\IndexConfigurator\ProductsIndexConfigurator;
use ScoutElastic\Searchable;

trait Search
{
    use Searchable;

    use Searchable {
        Searchable::getMapping as sourceGetMapping;
    }

    protected $indexConfigurator = ProductsIndexConfigurator::class;

    protected $searchRules = [

    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
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
                'search_article',
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
                    'code_1c' => [
                        'type' => 'text',
                        'fields' => [
                            'specific' => [
                                'type' => 'text',
                                'analyzer' => 'code_1c_word_grams_analyzer',
                                'search_analyzer' => 'code_1c_word_analyzer',
                            ],
                        ],
                    ],
                    'search_article' => [
                        'type' => 'text',
                        'fields' => [
                            'specific' => [
                                'type' => 'text',
                                'analyzer' => 'search_article_word_grams_analyzer',
                                'search_analyzer' => 'search_article_word_analyzer',
                            ],
                        ]
                    ],
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

    public function shouldBeSearchable()
    {
        return $this->publish && $this->category->in_tree_publish;
    }

    public function getHighlightedNameAttribute()
    {
        return $this->highlight ? $this->highlight->nameAsString : $this->name;
    }
}

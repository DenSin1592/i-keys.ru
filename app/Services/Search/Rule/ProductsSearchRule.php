<?php

namespace App\Services\Search\Rule;

use ScoutElastic\SearchRule;


class ProductsSearchRule extends SearchRule
{
    // This method returns an array, describes how to highlight the results.
    // If null is returned, no highlighting will be used.
    public function buildHighlightPayload()
    {
        return [
            'pre_tags' => '<span class="highlighted">',
            'post_tags' => '</span>',
            'fields' => [
                'name' => [
                    'type' => 'plain'
                ],
            ]
        ];
    }

    // This method returns an array, that represents bool query.;
    public function buildQueryPayload()
    {
        return [
            'must' => [
                'boosting' => [
                    'positive' => [
                        'multi_match' => [
                            'query' => $this->builder->query,
                            'type' => 'phrase',
                            'slop' => 50,
                        ],
                    ],
                    'negative' => [
                        'term' => [
                            'available' => false,
                        ]
                    ],
                    'negative_boost' => 0.01,
                ]
            ],
        ];
    }
}



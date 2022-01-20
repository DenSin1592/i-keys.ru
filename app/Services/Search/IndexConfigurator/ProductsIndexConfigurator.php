<?php

namespace App\Services\Search\IndexConfigurator;

use ScoutElastic\IndexConfigurator;


class ProductsIndexConfigurator extends IndexConfigurator
{
    // It's not obligatory to determine name. By default it'll be a snaked class name without `IndexConfigurator` part.
    protected $name = 'products';

    // You can specify any settings you want, for example, analyzers.
    protected $settings = [
        'index' => [
            'max_ngram_diff' => 17,
        ],
        'analysis' => [
            'filter' => [
                'russian_stop' => [
                    'type' => 'stop',
                    'stopwords' => '_russian_'
                ],
                'russian_stemmer' => [
                    'type' => 'stemmer',
                    'language' => 'russian'
                ],
                'english_stop' => [
                    'type' => 'stop',
                    'stopwords' => '_english_'
                ],
                'english_stemmer' => [
                    'type' => 'stemmer',
                    'language' => 'english'
                ],
                '3_3_grams' => [
                    'type' => 'ngram',
                    'min_gram' => 3,
                    'max_gram' => 3,
                    'token_chars' => [
                        'letter',
                        'digit',
                        'punctuation',
                    ]
                ],
                '3_20_grams' => [
                    'type' => 'ngram',
                    'min_gram' => 3,
                    'max_gram' => 20,
                    'token_chars' => [
                        'letter',
                        'digit',
                        'punctuation',
                    ]
                ],
                'article_code_1c_word_delimiter' => [
                    'type' => 'word_delimiter',
                    'split_on_numerics' => false,
                    'split_on_case_change' => false,
                    'catenate_numbers' => false,
                    'catenate_all' => true,
                    'generate_word_parts' => false,
                    'generate_number_parts' => false,
                    'catenate_words' => false,
                    'preserve_original' => false,
                    'stem_english_possessive' => true,
                ],
                'min_length_2' => [
                    'type' => 'length',
                    'min' => 2,
                ],
            ],
            'tokenizer' => [
                '3_3_grams_tokenizer' => [
                    'type' => 'ngram',
                    'min_gram' => 3,
                    'max_gram' => 3,
                    'token_chars' => [
                        'letter',
                        'digit',
                        'punctuation',
                    ]
                ],
            ],
            'analyzer' => [
                'russian_analyzer' => [
                    'tokenizer' => 'standard',
                    'filter' => [
                        'lowercase',
                        'russian_stop',
                        'russian_stemmer',
                    ]
                ],
                'english_analyzer' => [
                    'tokenizer' => 'standard',
                    'filter' => [
                        'lowercase',
                        'english_stop',
                        'english_stemmer',
                    ]
                ],
                'code_1c_word_analyzer' => [
                    'tokenizer' => 'whitespace',
                    'filter' => [
                        'lowercase',
                        'article_code_1c_word_delimiter',
                        'min_length_2',
                    ]
                ],
                'code_1c_word_grams_analyzer' => [
                    'tokenizer' => 'whitespace',
                    'filter' => [
                        'lowercase',
                        'article_code_1c_word_delimiter',
                        '3_20_grams',
                        'min_length_2',
                    ]
                ],
                'search_article_word_analyzer' => [
                    'tokenizer' => 'whitespace',
                    'filter' => [
                        'lowercase',
                        'article_code_1c_word_delimiter',
                        'min_length_2',
                    ]
                ],
                'search_article_word_grams_analyzer' => [
                    'tokenizer' => 'whitespace',
                    'filter' => [
                        'lowercase',
                        'article_code_1c_word_delimiter',
                        '3_20_grams',
                        'min_length_2',
                    ]
                ]
            ]
        ]
    ];
}

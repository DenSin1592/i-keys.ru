<?php namespace App\Models;

class ExchangeLog extends \Eloquent
{
    const EXCHANGE_TYPE_IMPORT = 'import';
    const EXCHANGE_TYPE_EXPORT = 'export';

    const TYPE_ERROR = 'error';
    const TYPE_CATEGORY = 'category';
    const TYPE_PRODUCT = 'product';
    const TYPE_PRODUCT_IMAGE = 'product_image';
    const TYPE_ATTRIBUTE = 'attribute';
    const TYPE_ATTRIBUTE_VALUE = 'attribute_value';
    const TYPE_CLIENT = 'client';
    const TYPE_ORDER = 'order';

    protected $fillable = [
        'solved',
        'exchange_type',
        'type',
        'file_name',
        'line_number',
        'category_code_1c',
        'product_code_1c',
        'attribute_code_1c',
        'client_code_1c',
        'order_code_1c',
        'message',
    ];
}
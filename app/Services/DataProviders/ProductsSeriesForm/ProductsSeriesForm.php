<?php

namespace App\Services\DataProviders\ProductsSeriesForm;

use App\Models\ProductsSeries;


class ProductsSeriesForm
{
    public function provideDataFor(ProductsSeries $model)
    {
        return [
            'model' => $model,
        ];
    }

}

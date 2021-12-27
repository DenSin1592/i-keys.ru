<?php

namespace App\Services\DataProviders\ProductsSeriesForm;

use App\Models\Attribute\AllowedValue;


class ProductsSeriesForm
{
    public function provideDataFor(AllowedValue $model)
    {
        return [
            'model' => $model,
        ];
    }

}

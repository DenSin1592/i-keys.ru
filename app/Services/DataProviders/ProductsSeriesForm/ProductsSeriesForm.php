<?php

namespace App\Services\DataProviders\ProductsSeriesForm;

use App\Models\Attribute\AllowedValue;


class ProductsSeriesForm
{

    private array $plugins = [];


    public function addPlugin(ProductsSeriesFormPlugin $plugin): void
    {
        $this->plugins[] = $plugin;
    }


    public function provideDataFor(AllowedValue $model)
    {
        $data = ['model' => $model,];
        foreach ($this->plugins as $plugin) {
            $data = array_merge($data, $plugin->getSubData($model));
        }

        return $data;
    }
}

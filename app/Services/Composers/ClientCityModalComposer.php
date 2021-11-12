<?php

namespace App\Services\Composers;

use App\Services\Subdomains\SubdomainsHelper;


class ClientCityModalComposer
{
    private $subdomainsHelper;

    public function __construct(SubdomainsHelper $subdomainsHelper)
    {
        $this->subdomainsHelper = $subdomainsHelper;
    }

    public function compose($view)
    {
        $defaultCity = $this->subdomainsHelper->getDefaultSubdomain();
        $currentCity = $this->subdomainsHelper->getSubdomainOrDefault();
        $otherCity = $this->subdomainsHelper->getOtherSubdomains()->sortBy('city_name');

        $groupedCities = [$defaultCity];
        foreach ($otherCity as $elem) {
            $groupedCities[\Str::upper(mb_substr($elem->city_name, 0, 1))][] = $elem;
        }


        $citiesColumns = [];
        foreach ($this->slices($groupedCities, [6, 5, 4, 3]) as $columns) {
            $columnData = [];
            foreach ($columns as $letter => $cities) {
                $citiesData = [];
                foreach ($cities as $city) {
                    if ($city->name === $defaultCity->name) {
                        $url = $this->subdomainsHelper->getUriFor(\URL::current());
                    } else {
                        $url = $this->subdomainsHelper->getUriFor(\URL::current(), $city);
                    }
                    $cityData = [
                        'url' => $url,
                        'name' => $city->city_name,
                        'active' => ($currentCity === $city->id),
                    ];
                    $citiesData[] = $cityData;
                }
                $columnData[$letter] = $citiesData;
            }
            $citiesColumns[] = $columnData;
        }


        $view->with('citiesData', $citiesColumns);
    }


    private function slices(array $list, array $counts = []): array
    {
        $slices = [];

        $offset = 0;
        $length = 0;

        foreach ($counts as $index => $count) {
            $offset += $length;
            $length = $count;

            $slices[] = array_slice($list, $offset, $length);
        }

        $slices[] = array_slice($list, $offset + $length);

        return $slices;
    }
}

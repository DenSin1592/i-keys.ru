<?php namespace App\Services\Catalog\ListSorting;

/**
 * Class SortingContainer
 * @package App\Services\Catalog\ListSorting
 */
class SortingContainer
{
    /**
     * @var Sorting[]
     */
    private $sortingList = [];

    /**
     * @param Sorting $sorting
     */
    public function addSorting(Sorting $sorting)
    {
        foreach ($this->sortingList as $s) {
            if ($s->getKey() == $sorting->getKey()) {
                throw new \InvalidArgumentException("Sorting with {$sorting->getKey()} key already exists.");
            }
        }

        $this->sortingList[] = $sorting;
    }

    /**
     * Get available sorting variants.
     *
     * @param string $sortingInput
     * @return array
     */
    public function getSortingVariants(string $sortingInput = null): array
    {
        $sortingInput = $this->prepareSortingInput($sortingInput);
        $variants = [];
        foreach ($this->sortingList as $s) {
            $variants[] = $s->getVariant($sortingInput);
        }

        return $variants;
    }

    /**
     * @return null|string
     */
    public function getDefaultSortingVariant()
    {
        return $this->prepareSortingInput(null);
    }

    /**
     * Modify query according to sorting input.
     *
     * @param $query
     * @param string|null $sortingInput
     * @param array $additionalData
     * @return mixed
     */
    public function modifyQuery($query, string $sortingInput = null, array $additionalData = [])
    {
        $sortingInput = $this->prepareSortingInput($sortingInput);

        foreach ($this->sortingList as $s) {
            if ($sortingInput == $s->getKey()) {
                $s->modifyQuery($query, $additionalData);
            }
        }

        return $query;
    }

    /**
     * Prepare input sorting according to existing sorting values.
     *
     * @param $sortingInput
     * @return string|null
     */
    private function prepareSortingInput(string $sortingInput = null)
    {
        $result = null;
        if (!empty($sortingInput)) {
            foreach ($this->sortingList as $s) {
                if ($sortingInput == $s->getKey()) {
                    $result = $sortingInput;
                    break;
                }
            }
        }

        if (is_null($result) && count($this->sortingList) > 0) {
            $first = head($this->sortingList);
            $result = $first->getKey();
        }

        return $result;
    }
}

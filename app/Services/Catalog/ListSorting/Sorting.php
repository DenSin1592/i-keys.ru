<?php namespace App\Services\Catalog\ListSorting;

/**
 * Class Sorting
 * Abstract sorting way.
 *
 * @package App\Services\Catalog\ListSorting
 */
abstract class Sorting
{
    const DIRECTION_ASC = 'ASC';
    const DIRECTION_DESC = 'DESC';

    protected $name;
    protected $key;
    protected $direction;

    /**
     * Sorting constructor.
     * @param string $name
     * @param string $key
     * @param string $direction
     */
    public function __construct(string $name, string $key, string $direction)
    {
        if (!in_array($direction, [self::DIRECTION_ASC, self::DIRECTION_DESC])) {
            throw new \InvalidArgumentException('Invalid sorting direction');
        }
        $this->name = $name;
        $this->key = $key;
        $this->direction = $direction;
    }

    public function getVariant($sortingInput): array
    {
        return [
            'key' => $this->key,
            'name' => $this->name,
            'active' => $sortingInput == $this->key,
        ];
    }

    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Modify query.
     *
     * @param $query
     * @param array $additionalData
     * @return mixed
     */
    abstract public function modifyQuery($query, array $additionalData = []);
}

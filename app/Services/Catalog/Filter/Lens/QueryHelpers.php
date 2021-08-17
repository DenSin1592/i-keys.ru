<?php namespace App\Services\Catalog\Filter\Lens;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait QueryHelpers
 * Helpers for queries.
 * @package App\Services\Repositories\Product\Filter\Lens\Features
 */
trait QueryHelpers
{
    /**
     * Check if queries are equal.
     *
     * @param Builder $queryA
     * @param Builder $queryB
     * @return bool
     */
    protected function queriesAreEqual(Builder $queryA, Builder $queryB): bool
    {
        return $queryA->toSql() === $queryB->toSql() && $queryA->getBindings() === $queryB->getBindings();
    }
    /**
     * Check where table was already joined to query or not
     *
     * @param $query
     * @param $tableName
     * @return bool
     */
    protected function isJoined($query, $tableName)
    {
        if ($query instanceof \Illuminate\Database\Eloquent\Builder) {
            $joins = $query->getQuery()->joins;
        } elseif ($query instanceof \Illuminate\Database\Eloquent\Relations\Relation) {
            $joins = $query->getBaseQuery()->joins;
        } else {
            throw new \InvalidArgumentException('Query has incorrect type');
        }

        $joined = false;
        if (is_array($joins)) {
            foreach ($joins as $join) {
                if (is_string($join->table) && $join->table == $tableName) {
                    $joined = true;
                    break;
                } elseif ($join->table instanceof \Illuminate\Database\Query\Expression) {
                    $value = $join->table->getValue();
                    if (mb_stripos($value, " as {$tableName}") || mb_stripos($value, " as '{$tableName}'")) {
                        $joined = true;
                        break;
                    }
                }
            }
        }

        return $joined;
    }

}

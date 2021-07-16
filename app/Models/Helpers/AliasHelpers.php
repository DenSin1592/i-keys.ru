<?php namespace App\Models\Helpers;

class AliasHelpers
{
    /**
     * @var \Transliterator|null
     */
    private static $transliterator;

    /**
     * Set alias for model.
     *
     * @param \Eloquent $model
     * @param string $field
     * @param callable|null $aliasFilter
     */
    public static function setAlias(\Eloquent $model, string $field = 'name', ?callable $aliasFilter = null): void
    {
        if (!isset($model->alias) || $model->alias === '') {
            // Build alias by default rules
            $alias = self::generateAlias($model->getAttributeValue($field));

            // Call alias filter
            if (!is_null($aliasFilter)) {
                $newAlias = call_user_func_array($aliasFilter, [$alias]);
                if (!is_null($newAlias)) {
                    $alias = $newAlias;
                }
            }

            // Append number to alias to remove duplicate if needed
            $query = \DB::table($model->getTable())->where('alias', $alias);
            if ($model->getKey()) {
                $query->where($model->getKeyName(), '!=', $model->getKey());
            }
            $duplicateNumber = 1;
            while ($query->count()) {
                $duplicateAlias = $alias . '-' . $duplicateNumber;
                $query = \DB::table($model->getTable())->where('alias', $duplicateAlias);
                $duplicateNumber++;
            }
            if (isset($duplicateAlias)) {
                $alias = $duplicateAlias;
            }

            $model->alias = $alias;
        }
    }


    /**
     * Generate alias.
     *
     * @param string|null $str
     * @return string
     */
    public static function generateAlias(?string $str): string
    {
        if (is_null(self::$transliterator)) {
            self::$transliterator = \Transliterator::create('Russian-Latin/BGN');
        }
        $str = self::$transliterator->transliterate($str);
        $str = mb_strtolower($str);
        $str = preg_replace('/[()]/', '', $str);
        $str = preg_replace('/[^a-z0-9_+]/', '-', $str);
        $str = preg_replace('/-(-)+/', '-', $str);
        $str = preg_replace('/(^-|-$)/', '', $str);

        return $str;
    }
}

<?php namespace App\Models\Helpers;

/**
 * Class DeleteHelpers
 * Class with delete helpers.
 *
 * @package App\Models\Features
 */
class DeleteHelpers
{
    /**
     * Delete all related models for relation.
     *
     * @param $associationQueryBuilder
     */
    public static function deleteRelatedAll($associationQueryBuilder)
    {
        foreach ($associationQueryBuilder->get() as $subModel) {
            $subModel->delete();
        }
    }

    /**
     * Delete first related model for relation.
     *
     * @param $associationQueryBuilder
     */
    public static function deleteRelatedFirst($associationQueryBuilder)
    {
        $model = $associationQueryBuilder->first();
        if (!is_null($model)) {
            $model->delete();
        }
    }
}

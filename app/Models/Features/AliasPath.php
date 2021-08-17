<?php

namespace App\Models\Features;

trait AliasPath
{
    abstract public function extractPath(): array;

    /**
     * Get path of aliases for model.
     *
     * @return array
     */
    public function getAliasPath(): array
    {
        $parentPath = $this->extractPath();
        $aliasPath = array_map(
            function (self $model) {
                return $model->alias;
            },
            $parentPath
        );

        return $aliasPath;
    }
}
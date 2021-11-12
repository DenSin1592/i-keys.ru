<?php

namespace App\Services\Subdomains;

use ZendSearch\Lucene\Exception\RuntimeException;


class Config
{
//    private $configList = [];
//
//    public function addFieldsFor(\Eloquent $model, array $fields)
//    {
//        $this->configList[$this->modelUidFor($model)] = ['model' => $model, 'fields' => $fields];
//    }
//
//    public function fieldsFor(\Eloquent $model)
//    {
//        return array_get($this->configList, "{$this->modelUidFor($model)}.fields", []);
//    }
//
//    public function modelFor($modelUid)
//    {
//        $model = array_get($this->configList, "{$modelUid}.model");
//
//        if (is_null($model)) {
//            throw new RuntimeException("Unexpected model uid: {$modelUid}");
//        }
//
//        return $model;
//    }
//
//    public function modelClasses()
//    {
//        return array_map(function ($model) {
//            return get_class($model);
//        }, $this->models());
//    }
//
//    public function models()
//    {
//        $models = [];
//
//        foreach ($this->configList as $c) {
//            $models[] = $c['model'];
//        }
//
//        return $models;
//    }
//
//    public function modelUidFor(\Eloquent $model)
//    {
//        return $model->getTable();
//    }
//
//    public function hasFieldFor(\Eloquent $model, $fieldName)
//    {
//        return in_array($fieldName, $this->fieldsFor($model));
//    }
//
//    /**
//     * @return array
//     */
//    public function getConfigList()
//    {
//        return $this->configList;
//    }
}

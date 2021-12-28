<?php

namespace App\Http\Controllers\Admin\Attributes\Series;

use App\Services\Repositories\Service\EloquentServiceRepository;
use Illuminate\Http\JsonResponse;


class ServicesController
{
    public const BLOCK_NAME = 'Услуги';
    public const RELATIONS_NAME = 'services';
    public const ROUTE_EDIT = 'cc.services.edit';
    public const ROUTE_AVAILABLE = 'cc.products-series.services.available';
    public const ROUTE_REBUILD_CURRENT = 'cc.products-series.services.rebuild-current';


    public function __construct(
        private EloquentServiceRepository $repository
    ){}


    public function available(): JsonResponse
    {
        $elements = $this->repository->all();

        $elementsList = [];
        foreach ($elements as $element) {
            $elementsList[] = [
                'id' => $element->id,
                'name' => $element->name,
                'listName' => $element->name,
            ];
        }

        return \Response::json(['elements' => $elementsList]);
    }


    public function rebuildCurrent(): JsonResponse
    {
        $elements = \Request::get('elements');
        if (!is_array($elements)) {
            $elements = [];
        }

        $ids = array_map(static fn($e) => \Arr::get($e, 'id'), $elements);

        $models = $this->repository->allByIdsInSequence($ids);

        $content = \View::make(
            'admin.shared._relations._many_to_many._current',
            self::RELATION_CURRENT_VIEW_DEPENDENCIES($models),
        )->render();

        return \Response::json(['content' => $content]);
    }


    public static function RELATION_BLOCK_VIEW_DEPENDENCIES($formData): array
    {
        return [
            'blockName' => self::BLOCK_NAME,
            'relationsName' => self::RELATIONS_NAME,
            'routeEdit' => self::ROUTE_EDIT,
            'routeAvailable' => self::ROUTE_AVAILABLE,
            'routeRebuildCurrent' => self::ROUTE_REBUILD_CURRENT,
            'models' => $formData[self::RELATIONS_NAME],
            'terminalEnabled' => true
        ];
    }


    private static function RELATION_CURRENT_VIEW_DEPENDENCIES($models): array
    {
        return [
            'relationsName' => self::RELATIONS_NAME,
            'routeEdit' => self::ROUTE_EDIT,
            'models' => $models,
        ];
    }

}

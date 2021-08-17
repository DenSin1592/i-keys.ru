<?php namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Services\Repositories\Category\EloquentCategoryRepository;
use App\Services\Repositories\ProductImage\EloquentProductImageRepository;

class ImagesController extends Controller
{
    private $modelRepository;
    private $repository;

    public function __construct(
        EloquentCategoryRepository $categoryRepository,
        EloquentProductImageRepository $repository
    ) {
        $this->modelRepository = $categoryRepository;
        $this->repository = $repository;
    }

    public function create($categoryId)
    {
        $category = $this->modelRepository->findById($categoryId);
        if (is_null($category)) {
            \App::abort(404, 'Model not found');
        }

        $imageKey = \Request::get('key');
        $image = $this->repository->newInstance();
        $element = \View::make(
            'admin.products.form.images._image',
            [
                'imageKey' => $imageKey,
                'image' => $image,
            ]
        )->render();

        return \Response::json(['element' => $element]);
    }
}

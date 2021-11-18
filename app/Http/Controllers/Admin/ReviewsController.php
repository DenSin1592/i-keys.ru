<?php namespace App\Http\Controllers\Admin;

use App;
use App\Http\Controllers\Admin\Features\ToggleFlags;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Services\FormProcessors\Review\AdminReviewFormProcessor;
use App\Services\Repositories\Product\EloquentProductRepository;
use App\Services\Repositories\Review\EloquentReviewRepository;

class ReviewsController extends Controller
{
    use ToggleFlags;

    private $repository;
    private $catalogProductRepository;
    private $formProcessor;

    const PRODUCT_VARIANTS_SEARCH_LIMIT = 20;

    public function __construct(
        EloquentReviewRepository $repository,
        EloquentProductRepository $catalogProductRepository,
        AdminReviewFormProcessor $formProcessor
    )
    {
        $this->repository = $repository;
        $this->catalogProductRepository = $catalogProductRepository;
        $this->formProcessor = $formProcessor;
    }


    public function index()
    {
        $reviewList = $this->repository->paginate();
        return view('admin.review.index')->with('reviewList', $reviewList);
    }


    public function create()
    {
        $review = $this->repository->newInstance();
        $reviewList = $this->repository->paginate();

        $productVariants = [];

        return view('admin.review.create')
            ->with('reviewList', $reviewList)
            ->with('formData', $this->getFormData($review))
            ->with('productVariants', $productVariants);

    }


    public function store()
    {
        $review = $this->formProcessor->create(\Request::except('redirect_to'));
        if (null === $review) {
            return \Redirect::route('cc.reviews.create')
                ->withErrors($this->formProcessor->errors())->withInput();
        } else {
            if (\Request::get('redirect_to') === 'index') {
                $redirect = \Redirect::route('cc.reviews.index', $review->id);
            } else {
                $redirect = \Redirect::route('cc.reviews.edit', $review->id);
            }

            return $redirect->with('alert_success', 'Отзыв создан');
        }
    }


    public function edit($id)
    {
        $review = $this->repository->findById($id);
        if (is_null($review)) {
            App::abort(404, 'Review not found');
        }
        $reviewList = $this->repository->paginate();

        $product = $review->product()->first();
        $productVariants = [
            $product->id => "$product->name [id = $product->id]"
        ];

        return view('admin.review.edit')
            ->with('reviewList', $reviewList)
            ->with('product', $product)
            ->with('formData', $this->getFormData($review))
            ->with('productVariants', $productVariants);
    }


    public function update($id)
    {
        $review = $this->repository->findById($id);
        if (is_null($review)) {
            \App::abort(404, 'Review not found');
        }

        $success = $this->formProcessor->update($review, \Request::except('redirect_to'));
        if (!$success) {
            return \Redirect::route('cc.reviews.edit', $review->id)
                ->withErrors($this->formProcessor->errors())->withInput();
        } else {
            if (\Request::get('redirect_to') === 'index') {
                $redirect = \Redirect::route('cc.reviews.index', $review->id);
            } else {
                $redirect = \Redirect::route('cc.reviews.edit', $review->id);
            }

            return $redirect->with('alert_success', 'Отзыв обновлен');
        }
    }


    public function destroy($id)
    {
        $review = $this->repository->findById($id);
        if (is_null($review)) {
            \App::abort(404, 'Review not found');
        }
        $this->repository->delete($review);

        return \Redirect::route('cc.reviews.index')->with('alert_success', 'Отзыв удален');
    }


    /**
     * Get form data.
     *
     * @param Review $review
     * @return array
     */
    private function getFormData(Review $review)
    {
        return [
            'review' => $review,
        ];
    }

    public function toggleAttribute($id, $attribute)
    {
        if (!in_array($attribute, ['on_home_page', 'publish'])) {
            \App::abort(404, "Not allowed to toggle this attribute");
        }
        $review = $this->repository->findById($id);
        if (is_null($review)) {
            \App::abort(404, 'Review not found');
        }
        $this->repository->toggleAttribute($review, $attribute);

        return $this->toggleFlagResponse(
            route('cc.reviews.toggle-attribute', [$id, $attribute]),
            $review,
            $attribute
        );
    }

    public function getSearchedReviewProductValues()
    {
        if (!\Request::ajax()) {
            \App::abort(404);
        }

        $search = \Request::get('search');
        if (empty($search)) {
            $search = '';
        }
        $page = \Request::get('page');
        if (empty($page)) {
            $page = 1;
        }

        $searchResultsData = $this->catalogProductRepository->getProductsForReviewBySearch(
            $search,
            $page,
            self::PRODUCT_VARIANTS_SEARCH_LIMIT
        );

        $results = [];
        foreach ($searchResultsData['items'] as $product) {
            $results[] = [
                'id' => $product->id,
                'text' => "$product->name [id = $product->id]",
                'edit_link' => route('cc.products.edit', [$product->category->id, $product->id]),
//                'site_link' => ($product->publish && $product->category->in_tree_publish) ? \UrlBuilder::buildProductUrl($product) : '#',
                'site_link' =>'/'
            ];
        }

        $data = [
            'results' => $results,
            'pagination' => [
                "more" => ($searchResultsData['total'] > $searchResultsData['page'] * $searchResultsData['limit']),
            ]
        ];

        return \Response::json($data);
    }

}

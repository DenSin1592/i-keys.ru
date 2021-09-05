<?php namespace App\Services\Repositories\Review;

use App\Models\Product;
use App\Models\Review;
use App\Services\Pagination\FlexPaginator;
use App\Services\RepositoryFeatures\Attribute\EloquentAttributeToggler;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;


/**
 * Class EloquentReviewRepository
 * @package  App\Services\Repositories\Review
 */
class EloquentReviewRepository
{
    /**
     * @var FlexPaginator
     */
    private $flexPaginator;

    /**
     * @var EloquentAttributeToggler
     */
    private $attributeToggler;


    public function __construct(
        FlexPaginator $paginator,
        EloquentAttributeToggler $attributeToggler
    )
    {
        $this->flexPaginator = $paginator;
        $this->attributeToggler = $attributeToggler;
    }

    public function create(array $data): Review
    {
        return Review::create($data);
    }

    public function update(Review $review, $data): bool
    {
        return $review->fill($data)->save();
    }

    public function findById($id): ?Review
    {
        return Review::find($id);
    }

    public function newInstance(array $data = []): Review
    {
        return Review::newModelInstance($data);
    }

    public function delete(Review $review): ?bool
    {
        return $review->delete();
    }


    public function allByPage($page, $limit): array
    {
        $query = Review::query();

        $this->sortByReviewDate($query);

        $total = $query->count();
        $items = $query->skip($limit * ($page - 1))
            ->take($limit)
            ->get();

        return [
            'page' => $page,
            'limit' => $limit,
            'items' => $items,
            'total' => $total,
        ];
    }


    public function paginate(): LengthAwarePaginator
    {
        return $this->flexPaginator->make(
            function ($page, $limit) {
                return $this->allByPage($page, $limit);
            },
            'review-pagination-page',
            'review-pagination-limit'
        );
    }


    /**
     * Add ordered condition.
     *
     * @param Builder $query
     * @return Builder
     */
    private function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'DESC');
    }

    /**
     * Sort by column "review_date".
     *
     * @param Builder $query
     * @return Builder
     */
    private function sortByReviewDate(Builder $query): Builder
    {
        return $query->orderBy('review_date', 'DESC');
    }

    public function getProductReviews(Product $product)
    {
        $query = Review::query();
        $query
            ->where('product_id', $product->id)
            ->where('publish', true)
            ->where('review_date', '<', Carbon::now())
            ->orderBy('review_date', 'DESC');

        $reviews = $query->get();

        return $reviews;
    }


    public function toggleAttribute(Review $node, $attribute)
    {
        $this->attributeToggler->toggleAttribute($node, $attribute);

        return $node;
    }


    public function getRenewalReviewBorders()
    {
        $query = Review::query()->where('keep_review_date', false)->whereNotNull('review_date');
        $queryFirst = clone $query;
        $queryLast = clone $query;

        $firstReview = $queryFirst->orderBy('review_date', 'ASC')->first();
        $lastReview = $queryLast->orderBy('review_date', 'DESC')->first();

        if (!is_null($firstReview) && !is_null($lastReview) && $firstReview->id == $lastReview->id) {
            $lastReview = $firstReview;
        }

        return [
            'first' => $firstReview,
            'last' => $lastReview,
        ];
    }

    public function allRenewal()
    {
        return Review::query()->where('keep_review_date', false)->whereNotNull('review_date')
            ->get();
    }

}

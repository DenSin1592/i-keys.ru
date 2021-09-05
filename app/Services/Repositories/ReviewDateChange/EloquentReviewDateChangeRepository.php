<?php namespace App\Services\Repositories\ReviewDateChange;

use App\Models\Review;
use App\Models\ReviewDateChange;
use Carbon\Carbon;

class EloquentReviewDateChangeRepository
{
    public function getLastIteration()
    {
        $iteration = ReviewDateChange::max('iteration');
        if (is_null($iteration)) {
            $iteration = 0;
        }

        return $iteration;
    }


    public function create(Review $review, $iteration, Carbon $oldValue, Carbon $newValue)
    {
        $review->dateChanges()->create([
            'iteration' => $iteration,
            'old_value' => $oldValue,
            'new_value' => $newValue,
        ]);
    }


    public function countWithinIteration($iteration)
    {
        return ReviewDateChange::query()->where('iteration', $iteration)->count();
    }


    public function allWithinIteration($iteration)
    {
        return ReviewDateChange::query()
            ->where('iteration', $iteration)->orderBy('new_value', 'desc')
            ->with('review')
            ->get();
    }
}

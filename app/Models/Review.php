<?php namespace App\Models;

use App\Models\Helpers\DeleteHelpers;

class Review extends \Eloquent
{
    protected $fillable = [
        'name',
        'publish',
        'email',
        'ip',
        'content',
        'content_answer',
        'product_id',
        'review_date',
        'on_home_page',
        'keep_review_date',
        'score',
    ];

    protected $dates = ['review_date'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function dateChanges()
    {
        return $this->hasMany('App\Models\ReviewDateChange');
    }

    public function getReviewDateFormattedAttribute()
    {
        $str = strtotime($this->review_date);
        return date('d', $str)
            . ' '
            . trans('months.' . date('F', $str))
            . ' '
            . date('Y г.', $str);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(
            function (self $review) {
                DeleteHelpers::deleteRelatedAll($review->dateChanges());
            }
        );
    }
}

<?php namespace App\Models;

use App\Models\Features\AttachedToNode;

/**
 * App\Models\HomePage
 *
 * @property integer $id
 * @property integer $node_id
 * @property string $header
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $content
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Node $node
 * @method static \Illuminate\Database\Query\Builder|\App\Models\HomePage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\HomePage whereNodeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\HomePage whereHeader($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\HomePage whereMetaTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\HomePage whereMetaKeywords($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\HomePage whereMetaDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\HomePage whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\HomePage whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\HomePage whereUpdatedAt($value)
 */
class HomePage extends \Eloquent
{
    use AttachedToNode;

    protected $fillable = [
        'header',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'content',
    ];
}

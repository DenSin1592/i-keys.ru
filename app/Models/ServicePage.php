<?php
namespace App\Models;

use App\Models\Features\AttachedToNode;

/**
 * App\Models\ServicePage
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
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ServicePage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ServicePage whereNodeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ServicePage whereHeader($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ServicePage whereMetaTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ServicePage whereMetaKeywords($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ServicePage whereMetaDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ServicePage whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ServicePage whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ServicePage whereUpdatedAt($value)
 */
class ServicePage extends \Eloquent
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

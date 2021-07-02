<?php
namespace App\Models;

use App\Models\Features\AttachedToNode;

/**
 * App\Models\TextPage
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
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TextPage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TextPage whereNodeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TextPage whereHeader($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TextPage whereMetaTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TextPage whereMetaKeywords($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TextPage whereMetaDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TextPage whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TextPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TextPage whereUpdatedAt($value)
 */
class TextPage extends \Eloquent
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

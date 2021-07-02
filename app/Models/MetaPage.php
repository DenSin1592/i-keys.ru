<?php namespace App\Models;

use App\Models\Features\AttachedToNode;

/**
 * App\Models\MetaPage
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
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MetaPage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MetaPage whereNodeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MetaPage whereHeader($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MetaPage whereMetaTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MetaPage whereMetaKeywords($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MetaPage whereMetaDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MetaPage whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MetaPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MetaPage whereUpdatedAt($value)
 */
class MetaPage extends \Eloquent
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

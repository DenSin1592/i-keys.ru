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

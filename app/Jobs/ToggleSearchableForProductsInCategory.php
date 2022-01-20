<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class ToggleSearchableForProductsInCategory implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $category;

    /**
     * Create a new job instance.
     *
     * @param Category $category
     * @return void
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function handle()
    {
        $descendantIdsAndSelf = $this->category->descendants()->get()->pluck('id')->all();
        $descendantIdsAndSelf[] = $this->category->id;

        $productsQuery = Product::query()->whereIn('category_id', $descendantIdsAndSelf);
        if ($this->category->in_tree_publish) {
            $productsQuery->searchable();
        } else {
            $productsQuery->unsearchable();
        }
    }

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTypePages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_type_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->foreign('parent_id', 'product_type_pages_parent_fk')
                ->references('id')->on('product_type_pages');

            $table->string('alias')->nullable();
            $table->unique(['alias', 'parent_id'], 'product_type_pages_alias_unique');

            $table->string('name')->nullable();
            $table->boolean('publish')->default(false);
            $table->boolean('in_tree_publish')->default(false);
            $table->integer('position')->default(0);

            $table->string('header')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();

            $table->text('content')->nullable();
            $table->text('bottom_content')->nullable();

            $table->unsignedInteger('category_id')->nullable();
            $table->foreign('category_id', 'category_id_product_type_pages_fk')
                ->references('id')->on('categories');

            $table->enum('product_list_way', ['filtered', 'manual'])->default('filtered');
            $table->text('filter_query')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_type_pages');
    }
}

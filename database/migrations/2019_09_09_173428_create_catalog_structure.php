<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogStructure extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->unsignedInteger('parent_id')->nullable();
            $table->string('name')->nullable();
            $table->string('alias')->nullable();
            $table->integer('position')->default(0);
            $table->boolean('publish')->default(false);
            $table->boolean('in_tree_publish')->default(false);

            $table->text('content')->nullable();
            $table->string('header')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();

            $table->foreign('parent_id')->references('id')->on('categories');
            $table->unique(['alias', 'parent_id'], 'category_alias_unique');
        });

        Schema::create('categories_ancestors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('descendant_id');
            $table->unsignedInteger('ancestor_id');
            $table->foreign('descendant_id', 'category_ancestor_descendant_fk')->references('id')->on('categories');
            $table->foreign('ancestor_id', 'category_ancestor_ancestor_fk')->references('id')->on('categories');
            $table->unique(['descendant_id', 'ancestor_id'], 'category_ancestor_unique');
        });

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->unsignedInteger('category_id');
            $table->string('name')->nullable();
            $table->string('alias')->nullable();
            $table->integer('position')->default(0);
            $table->boolean('publish')->default(false);
            $table->decimal('price')->nullable();

            $table->text('content')->nullable();
            $table->string('header')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();

            $table->foreign('category_id', 'product_category_fk')->references('id')->on('categories');
            $table->unique(['alias', 'category_id'], 'product_alias_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
        Schema::drop('categories_ancestors');
        Schema::drop('categories');
    }

}

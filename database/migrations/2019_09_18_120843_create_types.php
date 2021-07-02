<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypes extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('category_id')->nullable();
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

            $table->foreign('parent_id')->references('id')->on('types');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unique(['alias', 'parent_id'], 'type_alias_unique');
        });


        Schema::create('types_ancestors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('descendant_id');
            $table->unsignedInteger('ancestor_id');
            $table->foreign('descendant_id', 'type_ancestor_descendant_fk')->references('id')->on('types');
            $table->foreign('ancestor_id', 'type_ancestor_ancestor_fk')->references('id')->on('types');
            $table->unique(['descendant_id', 'ancestor_id'], 'type_ancestor_unique');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('types_ancestors');
        Schema::drop('types');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAttributeCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('attribute_category');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('attribute_category', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('attribute_id');
            $table->unsignedInteger('category_id');
            $table->foreign('attribute_id', 'attribute_category_attribute_fk')->references('id')->on('attributes');
            $table->foreign('category_id', 'attribute_category_category_fk')->references('id')->on('categories');
            $table->unique(['attribute_id', 'category_id'], 'attribute_category_unique');
        });
    }

}

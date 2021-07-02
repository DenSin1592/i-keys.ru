<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributes extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('attribute_type');
            $table->string('name')->nullable();
            $table->integer('position')->default(0);
            $table->string('units')->nullable();
            $table->smallInteger('decimal_scale')->default(2);
        });

        Schema::create('attribute_category', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('attribute_id');
            $table->unsignedInteger('category_id');
            $table->foreign('attribute_id', 'attribute_category_attribute_fk')->references('id')->on('attributes');
            $table->foreign('category_id', 'attribute_category_category_fk')->references('id')->on('categories');
            $table->unique(['attribute_id', 'category_id'], 'attribute_category_unique');
        });

        Schema::create('attribute_allowed_values', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('attribute_id');
            $table->string('value');
            $table->integer('position')->default(0);
            $table->foreign('attribute_id', 'attribute_allowed_values_attribute_fk')
                ->references('id')->on('attributes');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('attribute_allowed_values');
        Schema::drop('attribute_category');
        Schema::drop('attributes');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeValues extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_string_values', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('attribute_id');
            $table->string('value');
            $table->unsignedInteger('product_id');

            $table->unique(['product_id', 'attribute_id'], 'attribute_string_value_product_unique');
            $table->foreign('attribute_id', 'attribute_string_value_attribute_fk')->references('id')->on('attributes');
            $table->foreign('product_id', 'attribute_string_value_product_fk')->references('id')->on('products');
        });


        Schema::create('attribute_integer_values', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('attribute_id');
            $table->integer('value');
            $table->unsignedInteger('product_id');

            $table->unique(['product_id', 'attribute_id'], 'attribute_integer_value_product_unique');
            $table->foreign('attribute_id', 'attribute_integer_value_attribute_fk')->references('id')->on('attributes');
            $table->foreign('product_id', 'attribute_integer_value_product_fk')->references('id')->on('products');
        });


        Schema::create('attribute_decimal_values', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('attribute_id');
            $table->decimal('value', 12, 3);
            $table->unsignedInteger('product_id')->nullable();

            $table->unique(['product_id', 'attribute_id'], 'attribute_decimal_value_product_unique');
            $table->foreign('attribute_id', 'attribute_decimal_value_attribute_fk')->references('id')->on('attributes');
            $table->foreign('product_id', 'attribute_decimal_value_product_fk')->references('id')->on('products');
        });


        Schema::create('attribute_single_values', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('attribute_id');
            $table->unsignedInteger('value_id');
            $table->unsignedInteger('product_id');

            $table->unique(['product_id', 'attribute_id'], 'attribute_single_value_product_unique');
            $table->foreign(['attribute_id', 'value_id'], 'attribute_single_value_value_fk')
                ->references(['attribute_id', 'id'])->on('attribute_allowed_values');
            $table->foreign('product_id', 'attribute_single_value_product_fk')->references('id')->on('products');
        });


        Schema::create('attribute_multiple_values', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('attribute_id');
            $table->unsignedInteger('value_id');
            $table->unsignedInteger('product_id');

            $table->unique(['product_id', 'attribute_id', 'value_id'], 'attribute_multiple_value_product_unique');
            $table->foreign(['attribute_id', 'value_id'], 'attribute_multiple_value_value_fk')
                ->references(['attribute_id', 'id'])->on('attribute_allowed_values');
            $table->foreign('product_id', 'attribute_multiple_value_product_fk')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('attribute_string_values');
        Schema::drop('attribute_integer_values');
        Schema::drop('attribute_decimal_values');
        Schema::drop('attribute_single_values');
        Schema::drop('attribute_multiple_values');
    }
}

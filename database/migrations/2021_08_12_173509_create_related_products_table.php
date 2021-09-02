<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelatedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'related_products',
            function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('product_id');
                $table->foreign('product_id', 'related_products_product_id_fk')
                    ->references('id')->on('products');

                $table->unsignedInteger('attached_product_id');
                $table->foreign('attached_product_id', 'related_products_attached_product_id_fk')
                    ->references('id')->on('products');

                $table->unique(
                    ['product_id', 'attached_product_id'],
                    'related_products_product_id_attached_product_id_unique'
                );
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('related_products');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTypePageAssociations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_type_page_associations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('product_type_page_id');
            $table->foreign('product_type_page_id', 'prod_type_page_assoc_page_fk')
                ->references('id')->on('product_type_pages');

            $table->unsignedInteger('product_id');
            $table->foreign('product_id', 'prod_type_page_assoc_product_fk')
                ->references('id')->on('products');

            $table->unique(['product_type_page_id', 'product_id'], 'prod_type_page_assoc_unique');

            $table->string('name')->nullable();
            $table->integer('position')->nullable();
            $table->timestamps();
        });

        Schema::create(
            'product_type_page_manual',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('product_type_page_id');
                $table->foreign('product_type_page_id', 'product_type_page_manual_page_fk')
                    ->references('id')->on('product_type_pages');

                $table->unsignedInteger('product_id');
                $table->foreign('product_id', 'product_type_page_manual_product_fk')
                    ->references('id')->on('products');
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
        Schema::dropIfExists('product_type_page_manual');
        Schema::dropIfExists('product_type_page_associations');
    }
}

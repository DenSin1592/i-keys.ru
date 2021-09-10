<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->unsignedInteger('count')->default(1);
            $table->decimal('price')->default(0);

            $table->unsignedInteger('order_id');
            $table->foreign('order_id', 'order_items_order_id_fk')
                ->references('id')->on('orders');

            $table->unsignedInteger('product_id')->nullable();
            $table->foreign('product_id', 'order_items_product_id_fk')
                ->references('id')->on('products');

            $table->string('code_1c')->nullable();
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
        Schema::dropIfExists('order_items');
    }
}

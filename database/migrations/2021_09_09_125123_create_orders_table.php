<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Order\TypeConstants;
use App\Models\Order\StatusConstants;
use \App\Models\Exchange\StatusConstants as ExchangeStatus;
use App\Models\Order\PaymentStatusConstants;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status')->default(StatusConstants::NOVEL);
            $table->string('type')->default(TypeConstants::FROM_SITE);

            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('payment_status')->default(PaymentStatusConstants::UNPAID);
            $table->string('payment_method')->nullable();
            $table->string('delivery_method')->nullable();

            $table->string('postcode')->nullable();
            $table->unsignedInteger('region_id')->nullable();
            $table->foreign('region_id', 'orders_region_id_fk')
                ->references('id')->on('regions');
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->string('building')->nullable();
            $table->string('flat')->nullable();

            $table->text('comment')->nullable();
            $table->string('uid')->nullable();

            $table->string('user_agent')->nullable();
            $table->string('device_type')->nullable();
            $table->string('exchange_status')->default(ExchangeStatus::NEW);
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
        Schema::dropIfExists('orders');
    }
}

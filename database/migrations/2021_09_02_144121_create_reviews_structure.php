<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'reviews',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->default('');
                $table->boolean('publish')->default(false);
                $table->string('email')->default('');
                $table->boolean('on_home_page')->default(false);
                $table->text('content');

                $table->unsignedInteger('product_id');
                $table->foreign('product_id', 'review_product_fk')->references('id')->on('products');

                $table->timestamp('review_date')->default(DB::raw('CURRENT_TIMESTAMP'));

                $table->boolean('keep_review_date')->default(false);

                $table->string('ip')->default('');

                $table->timestamps();
            }
        );

        Schema::create(
            'review_date_changes',
            function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('review_id');
                $table->unsignedInteger('iteration');

                $table->foreign('review_id', 'review_date_review_fk')->references('id')->on('reviews');
                $table->unique(['review_id', 'iteration'], 'review_date_change_unique');

                $table->timestamp('old_value')->nullable();
                $table->timestamp('new_value')->nullable();
                $table->timestamps();
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
        Schema::dropIfExists('review_date_changes');
        Schema::dropIfExists('reviews');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateSubdomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subdomains', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('name')->unique();
            $table->string('city_name')->unique();
            $table->boolean('default')->default(false);

            $table->text('robots_txt')->nullable();
            $table->text('google_analytics')->nullable();
            $table->text('yandex_metrika')->nullable();
            $table->text('live_internet')->nullable();

            $table->string('header_template')->nullable();
            $table->string('meta_title_template')->nullable();
            $table->string('meta_description_template')->nullable();
            $table->string('meta_keywords_template')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subdomains');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangesForSettingsStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('settings');
        Schema::drop('setting_groups');

        Schema::create(
            'settings',
            function (Blueprint $table) {
                $table->increments('id');
                $table->timestamps();

                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->json('array_value')->nullable();
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
        Schema::drop('settings');

        Schema::create(
            'setting_groups',
            function (Blueprint $table) {
                $table->increments('id');
                $table->timestamps();

                $table->string('name')->unique();
                $table->integer('position')->default(0);
            }
        );

        Schema::create(
            'settings',
            function (Blueprint $table) {
                $table->increments('id');
                $table->timestamps();

                $table->string('key')->unique();
                $table->string('title')->nullable();
                $table->text('value')->nullable();
                $table->text('description')->nullable();
                $table->string('value_style')->nullable();
                $table->integer('position')->default(0);

                $table->unsignedInteger('group_id');
                $table->foreign('group_id', 'fk_setting_group')->references('id')->on('setting_groups');
            }
        );
    }
}

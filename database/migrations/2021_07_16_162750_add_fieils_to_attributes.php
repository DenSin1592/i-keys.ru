<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieilsToAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->string('icon')->nullable();
            $table->boolean('use_in_filter')->default(false);
            $table->boolean('for_admin_filter')->default(false);
            $table->string('filter_name')->nullable();
            $table->string('alias')->default('')->after('name');
            $table->boolean('hidden')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->dropColumn(['icon', 'use_in_filter', 'for_admin_filter', 'filter_name', 'alias', 'hidden']);
        });
    }
}

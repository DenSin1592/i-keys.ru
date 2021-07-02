<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdminUsersAllowedIpsToJson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_users', function (Blueprint $table) {
            $table->dropColumn('allowed_ips');
        });

        Schema::table('admin_users', function (Blueprint $table) {
            $table->json('allowed_ips')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_users', function (Blueprint $table) {
            $table->dropColumn('allowed_ips');
        });

        Schema::table('admin_users', function (Blueprint $table) {
            $table->text('allowed_ips')->nullable();
        });
    }
}

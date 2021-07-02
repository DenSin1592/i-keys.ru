<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropAdminRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'admin_users',
            function (Blueprint $table) {
                $table->dropForeign('admin_user_role');
                $table->dropColumn('admin_role_id');
            }
        );
        Schema::drop('admin_roles');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create(
            'admin_roles',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->text('rules')->nullable();
                $table->timestamps();
            }
        );

        Schema::table(
            'admin_users',
            function (Blueprint $table) {
                $table->unsignedInteger('admin_role_id')->nullable();
                $table->foreign('admin_role_id', 'admin_user_role')->references('id')->on('admin_roles');
            }
        );
    }
}

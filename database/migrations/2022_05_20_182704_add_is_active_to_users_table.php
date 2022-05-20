<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsActiveToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_number_seeders', function (Blueprint $table) {
            $table->tinyInteger('is_active')->default(1)->comment('0=DELETE,1.ACTIVE');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_number_seeders', function (Blueprint $table) {
            //
        });
    }
}

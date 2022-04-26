<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersNumberSeedersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_number_seeders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->nullable()->email();
            $table->string('call_receive_number')->nullable();
            $table->string('start_end')->nullable();
            $table->string('service_id')->nullable();
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
        Schema::dropIfExists('users_number_seeders');
    }
}

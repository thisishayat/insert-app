<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailTokenDtlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('email_token_dtls', function (Blueprint $table) {
//            $table->bigIncrements('id');
//            $table->string('token')->unique();
//            $table->string('email');
//            $table->dateTime('expire_at');
//            $table->text('signup_details');
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_token_dtls');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileSignupTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('mobile_signup_tokens', function (Blueprint $table) {
//            $table->bigIncrements('id');
//            $table->unsignedBigInteger('user_id')->nullable();
//            $table->string('code')->comment('sent to mobile');
//            $table->dateTime('expiry_time');
//            $table->string('phone');
//            $table->text('attrs');
//            $table->tinyInteger('type')->nullable()->comment('1=sign_up,2=sign_up_exist_device,3=change_phn_verify etc');
//            $table->tinyInteger('signup_status')->comment('0.failed,1.success');
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
        Schema::dropIfExists('mobile_signup_tokens');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clicks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('click_trans_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('click_paydoc_id');
            $table->unsignedBigInteger('merchant_trans_id');
            $table->unsignedBigInteger('amount');
            $table->unsignedBigInteger('action');
            $table->dateTime('sign_time');
            $table->unsignedBigInteger('user_id'); // Assuming user_id is the foreign key
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
        Schema::dropIfExists('clicks');
    }
};

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('credit_id');
            $table->string('number');
            $table->string('phone');
            $table->string('secondphone');
            $table->string('duusah_honog');
            $table->string('lastname');
            $table->string('amount');
            $table->string('huramtlagdsankhuu');
            $table->string('aldangi');
            $table->string('khuu');
            $table->string('assessment');
            $table->string('zeeluldegdel');
            $table->string('khetersenkhonog');
            $table->string('honog');
            $table->string('registernumber');
            $table->string('firstname');
            $table->string('address');
            $table->string('paymentdate');

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
        Schema::dropIfExists('credits');
    }
}


<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number');
            $table->integer('record');
            $table->string('tran_date');
            $table->string('post_date');
            $table->string('time');
            $table->string('branch');
            $table->string('teller');
            $table->string('journal');
            $table->string('code');
            $table->string('amount');
            $table->string('balance');
            $table->string('debit');
            $table->string('correction');
            $table->string('description');
            $table->string('related_account');


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
        Schema::dropIfExists('statments');
    }
}

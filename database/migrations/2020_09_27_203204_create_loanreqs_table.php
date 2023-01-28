<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanreqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loanreqs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('loanid');
            $table->string('amount');
            $table->string('interest');
            $table->string('time');
            $table->string('begdate');
            $table->string('enddate');
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
        Schema::dropIfExists('loanreqs');
    }
}

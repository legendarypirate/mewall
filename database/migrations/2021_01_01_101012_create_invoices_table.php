<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('number');
            $table->string('type');
            $table->string('pid');
            $table->timestamp('date_at');
            $table->string('amount');
//            $table->double('amount', 8, 2);
            $table->string('status');
            $table->integer('honog');
            $table->integer('invhonog');
            $table->string('desc');
            $table->string('phone');
            $table->string('bill_no');
            $table->string('date');
            $table->string('client');
            $table->string('credit_id');
            $table->string('transaction_no');
            $table->string('transaction_date');
            $table->string('transaction_amount');
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
        Schema::dropIfExists('invoices');
    }
}

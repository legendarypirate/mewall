<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKhanAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('khan_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number');
            $table->string('type');
            $table->string('currency');
            $table->string('status');
            $table->string('balance');
            $table->string('name');
            $table->string('hold_balance');
            $table->string('avalaible_balance');

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
        Schema::dropIfExists('khan_accounts');
    }
}

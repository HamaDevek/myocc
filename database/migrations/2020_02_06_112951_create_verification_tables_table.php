<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificationTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verification_tables', function (Blueprint $table) {
            $table->bigIncrements('v_ID');
            $table->string('v_code',6);
            $table->unsignedBigInteger('v_a_ID');
            $table->foreign('v_a_ID')->references('a_ID')->on('account_tables');
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
        Schema::dropIfExists('verification_tables');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavedAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saved_addresses', function (Blueprint $table) {
            $table->bigIncrements('sa_ID');
            $table->string('sa_name');
            $table->double('sa_lat');
            $table->double('sa_lng');
            $table->unsignedBigInteger('sa_a_ID');
            $table->timestamps();
            $table->foreign('sa_a_ID')->references('a_ID')->on('account_tables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saved_addresses');
    }
}

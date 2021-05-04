<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendTaxiTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_taxi_tables', function (Blueprint $table) {
            $table->bigIncrements('st_ID');
            $table->unsignedBigInteger('st_t_ID');
            $table->unsignedBigInteger('st_oi_ID');
            $table->boolean('st_state');
            $table->timestamps();
            $table->foreign('st_t_ID')->references('t_ID')->on('taxi_tables');
            $table->foreign('st_oi_ID')->references('oi_ID')->on('order_info_tables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('send_taxi_tables');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxiSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxi_schedules', function (Blueprint $table) {
            $table->bigIncrements('ts_ID');
            $table->unsignedBigInteger('ts_t_ID');
            $table->unsignedBigInteger('ts_w_ID');
            $table->time('from');
            $table->time('to');
            $table->foreign('ts_t_ID')->references('t_ID')->on('taxi_tables');
            $table->foreign('ts_w_ID')->references('w_ID')->on('week_days');
            $table->unique(['ts_t_ID', 'ts_w_ID']);
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
        Schema::dropIfExists('taxi_schedules');
    }
}

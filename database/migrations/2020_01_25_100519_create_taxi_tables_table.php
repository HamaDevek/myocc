<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxiTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxi_tables', function (Blueprint $table) {
            $table->bigIncrements('t_ID');
            $table->string('t_first_name');
            $table->string('t_middle_name');
            $table->string('t_last_name');
            $table->string('t_phone',17)->unique();
            $table->string('t_car_ID',20)->unique();
            $table->string('t_car_model');
            $table->unsignedBigInteger('t_l_ID');
            $table->boolean('t_state')->default(0);
            $table->timestamps();
            $table->foreign('t_l_ID')->references('l_ID')->on('location_tables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taxi_tables');
    }
}

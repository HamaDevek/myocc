<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_schedules', function (Blueprint $table) {
            $table->bigIncrements('shs_ID');
            $table->unsignedBigInteger('shs_sh_ID');
            $table->unsignedBigInteger('shs_w_ID');
            $table->time('from');
            $table->time('to');
            $table->foreign('shs_sh_ID')->references('sh_ID')->on('shop_tables');
            $table->foreign('shs_w_ID')->references('w_ID')->on('week_days');
            $table->unique(['shs_sh_ID', 'shs_w_ID']);
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
        Schema::dropIfExists('shop_schedules');
    }
}

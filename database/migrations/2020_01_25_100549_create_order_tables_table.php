<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_tables', function (Blueprint $table) {
            $table->bigIncrements('o_ID');
            $table->unsignedBigInteger('o_ip_ID');
            $table->unsignedBigInteger('o_oi_ID');
            $table->bigInteger('o_amount');
            $table->bigInteger('o_prices');
            $table->integer('o_group_by');
            $table->timestamps();
            $table->foreign('o_ip_ID')->references('ip_ID')->on('item_tables');
            $table->foreign('o_oi_ID')->references('oi_ID')->on('order_info_tables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_tables');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemColorTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_color_tables', function (Blueprint $table) {
            $table->bigIncrements('ic_ID');
            $table->unsignedBigInteger('ic_ip_ID');
            $table->unsignedBigInteger('ic_c_ID');
            $table->timestamps();
            $table->foreign('ic_ip_ID')->references('ip_ID')->on('item_tables');
            $table->foreign('ic_c_ID')->references('c_ID')->on('colors_tables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_color_tables');
    }
}

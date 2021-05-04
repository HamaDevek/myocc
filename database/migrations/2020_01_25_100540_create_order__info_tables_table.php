<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderInfoTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_info_tables', function (Blueprint $table) {
            $table->bigIncrements('oi_ID');
            $table->boolean('oi_type')->comment('[0 => myself ,1 => other]');//
            $table->date('oi_to_date');
            $table->time('oi_to_time');
            $table->string('oi_name_from');
            $table->string('oi_phone_from',17);
            $table->string('oi_address_from');
            $table->string('oi_masssage',200)->nullable();
            $table->string('oi_address_to')->nullable();
            $table->string('oi_name_to')->nullable();
            $table->string('oi_phone_to',17)->nullable();
            $table->bigInteger('oi_price_all');
            $table->unsignedBigInteger('oi_l_ID');
            $table->unsignedBigInteger('oi_a_ID');
            $table->boolean('oi_state')->default(0);
            $table->timestamps();
            $table->foreign('oi_l_ID')->references('l_ID')->on('location_tables');
            $table->foreign('oi_a_ID')->references('a_ID')->on('account_tables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_info_tables');
    }
}

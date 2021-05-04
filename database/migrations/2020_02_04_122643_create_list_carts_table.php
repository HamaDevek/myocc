<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_carts', function (Blueprint $table) {
            $table->bigIncrements('c_ID');
            $table->unsignedBigInteger('c_ip_ID');
            $table->unsignedBigInteger('c_a_ID');
            $table->integer('c_amount');
            $table->integer('c_group_by')->default(0);
            $table->foreign('c_ip_ID')->references('ip_ID')->on('item_tables');
            $table->foreign('c_a_ID')->references('a_ID')->on('account_tables');
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
        Schema::dropIfExists('list_carts');
    }
}

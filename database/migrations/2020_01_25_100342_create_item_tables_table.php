<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_tables', function (Blueprint $table) {
            $table->bigIncrements('ip_ID');
            $table->string('ip_name');
            $table->bigInteger('ip_price');
            $table->text('ip_description');
            $table->unsignedBigInteger('ip_tp_ID')->default(1);
            $table->unsignedBigInteger('ip_sh_ID')->default(1);
            $table->unsignedBigInteger('ip_oc_ID')->default(1);
            $table->boolean('ip_state')->default(0);
            $table->timestamps();
            $table->foreign('ip_sh_ID')->references('sh_ID')->on('shop_tables');
            $table->foreign('ip_tp_ID')->references('tp_ID')->on('type_tables');
            $table->foreign('ip_oc_ID')->references('oc_ID')->on('occation_tables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_tables');
    }
}

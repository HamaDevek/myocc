<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesIpTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images_ip_tables', function (Blueprint $table) {
            $table->bigIncrements('i_ID');
            $table->string('i_link');
            $table->boolean('i_is_primary')->default(0);
            $table->unsignedBigInteger('i_ip_ID');
            $table->timestamps();
            $table->foreign('i_ip_ID')->references('ip_ID')->on('item_tables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images_ip_tables');
    }
}

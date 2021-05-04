<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_tables', function (Blueprint $table) {
            $table->bigIncrements('a_ID');
            $table->string('a_name');
            $table->string('a_image')->nullable();
            $table->string('a_password');
            $table->string('a_phone',17)->unique();
            $table->string('a_address');
            $table->boolean('a_state')->default(0);
            $table->unsignedBigInteger('a_l_ID');
            $table->timestamps();
            $table->foreign('a_l_ID')->references('l_ID')->on('location_tables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_tables');
    }
}

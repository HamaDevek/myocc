<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_tables', function (Blueprint $table) {
            $table->bigIncrements('l_ID');
            $table->string('l_name');
            $table->boolean('l_state')->default(0);
            $table->timestamps();
        });
        DB::table('location_tables')->insert(
            array(
                'l_ID' => 1,
                'l_name' => 'گشتی',
                'l_state' => 1,
            ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_tables');
    }
}

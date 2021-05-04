<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOccationTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('occation_tables', function (Blueprint $table) {
            $table->bigIncrements('oc_ID');
            $table->string('oc_name')->unique();
            $table->boolean('oc_state')->default(0);
            $table->timestamps();
        });
        DB::table('occation_tables')->insert(
            array(
                'oc_ID' => 1,
                'oc_name' => 'هیچیان',
                'oc_state' => 1,
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('occation_tables');
    }
}

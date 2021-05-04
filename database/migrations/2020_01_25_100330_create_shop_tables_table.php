<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_tables', function (Blueprint $table) {
            $table->bigIncrements('sh_ID');
            $table->string('sh_name');
            $table->string('sh_owner');
            $table->string('sh_phone',17);
            $table->unsignedBigInteger('sh_l_ID');
            $table->boolean('sh_state')->default(0);
            $table->timestamps();
            $table->foreign('sh_l_ID')->references('l_ID')->on('location_tables');
            
        });
        DB::table('shop_tables')->insert(
            array(
                'sh_ID' => 1,
                'sh_name' => 'My Occasion',
                'sh_owner' => 'My Occasion',
                'sh_phone' => 'contact',
                'sh_state' => 1,
                'sh_l_ID' => 1,
            ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_tables');
    }
}

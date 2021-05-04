<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
class CreateAdminTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_tables', function (Blueprint $table) {
            $table->bigIncrements('ad_ID');
            $table->unsignedBigInteger('ad_l_ID');
            $table->string('ad_first_name');
            $table->string('ad_middle_name');
            $table->string('ad_last_name');
            $table->string('ad_username')->unique();
            $table->string('ad_phone',17)->unique();
            $table->string('ad_password');
            $table->boolean('ad_state')->default(0);
            $table->boolean('ad_role');
            $table->timestamps();
            $table->foreign('ad_l_ID')->references('l_ID')->on('location_tables');
            
        });
        DB::table('admin_tables')->insert(
            array(
                'ad_first_name' => 'My Occasion',
                'ad_middle_name' => 'My Occasion',
                'ad_last_name' => 'My Occasion',
                'ad_username' => 'admin',
                'ad_phone' => 'contact',
                'ad_password' => Hash::make('123456'),
                'ad_state' => 1,
                'ad_role' => 1,
                'ad_l_ID' => 1,
            ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_tables');
    }
}

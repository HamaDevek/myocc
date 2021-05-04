<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactAsTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_as_tables', function (Blueprint $table) {
            $table->bigIncrements('con_ID');
            $table->string('con_phone');
            $table->string('con_email');
            $table->string('con_address');
            $table->string('con_meta_name');
            $table->string('con_meta_disc');
            $table->timestamps();
        });
        DB::table('contact_as_tables')->insert(
            array(
                'con_phone' => '٠٧٧٠١٢٣٤٥٦٧',
                'con_email' => 'myoccasion@myoccasion.com',
                'con_address' => 'سلێمانی - عەقاری',
                'con_meta_name' => 'name',
                'con_meta_disc' => 'desc',
            ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_as_tables');
    }
}

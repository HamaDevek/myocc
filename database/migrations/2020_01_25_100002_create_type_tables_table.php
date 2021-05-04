<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_tables', function (Blueprint $table) {
            $table->bigIncrements('tp_ID');
            $table->string('tp_name');
            $table->boolean('tp_state')->default(0);
            $table->timestamps();
        });
        DB::table('type_tables')->insert(
            [
                array(
                    'tp_name' => 'چەپکە گوڵ',
                    'tp_state' => 1,
                ),
                array(
                    'tp_name' => 'دیاری',
                    'tp_state' => 1,
                ),
                array(
                    'tp_name' => 'ئینجانە',
                    'tp_state' => 1,
                ),
                array(
                    'tp_name' => 'ئۆفەر',
                    'tp_state' => 1,
                ),
                array(
                    'tp_name' => 'گوڵ',
                    'tp_state' => 1,
                ),
                array(
                    'tp_name' => 'وەرەقە',
                    'tp_state' => 1,
                ),
                array(
                    'tp_name' => 'قردێلە',
                    'tp_state' => 1,
                )
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_tables');
    }
}

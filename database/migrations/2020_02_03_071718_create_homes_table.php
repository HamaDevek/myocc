<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image');
            $table->string('class');
            $table->string('title');
            $table->string('desc');
            $table->timestamps();
        });
        Schema::create('home_extra', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('image');
            $table->timestamps();
        });
        DB::table('home_extra')->insert(
            array(
                'title' => 'دەتەوێت بە دڵی خۆت چەپکە گوڵ دروست بکەیت؟',
                'image' => 'image/placeholder.jpg',
            ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('homes');
        Schema::dropIfExists('home_extra');
    }
}

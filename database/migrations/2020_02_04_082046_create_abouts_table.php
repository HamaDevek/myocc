<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->string('image');
            $table->string('title');
            $table->text('desc');
            $table->string('footer_title');
            $table->text('footer_desc');
            $table->timestamps();
        });
        DB::table('abouts')->insert(
            [array(
                'title' => 'دەربارەی مای ئۆکەیژنس',
                // 'image' => 'image/placeholder.jpg',
                'desc' => 'دەربارەی مای ئۆکەیژنس',
                'footer_title' => 'مای ئۆکەیژنس',
                'footer_desc' => 'دیاری، گوڵ و ئامادەکارییەکانت داوا بکە دیاری، گەکانت داوا بکە دیاری، گوڵ و ئامادەکارییەکانت داوا بکە دیاری، گوڵ و ئامادەکارییەکانت داوا بکە'
            ),
            array(
                'title' => 'دەربارەی مای ئۆکەیژنس',
                // 'image' => 'image/placeholder.jpg',
                'desc' => 'دەربارەی مای ئۆکەیژنس',
                'footer_title' => '0',
                'footer_desc' => '0'
            )]
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abouts');
    }
}

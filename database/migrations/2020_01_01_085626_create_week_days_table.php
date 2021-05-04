<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateWeekDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('week_days', function (Blueprint $table) {
            $table->bigIncrements('w_ID');
            $table->string('w_days')->unique();
            $table->enum('w_days_enum', ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat']);
            $table->timestamps();
        });
        DB::table('week_days')->insert(
            array(
                ['w_days' => 'یەک شەممە', 'w_days_enum' => 'sun'],
                ['w_days' => 'دوو شەممە', 'w_days_enum' => 'mon'],
                ['w_days' => 'سێ شەممە', 'w_days_enum' => 'tue'],
                ['w_days' => 'چوار شەممە', 'w_days_enum' => 'wed'],
                ['w_days' => 'پێنج شەممە', 'w_days_enum' => 'thu'],
                ['w_days' => 'هەینی', 'w_days_enum' => 'fri'],
                ['w_days' => 'شەممە', 'w_days_enum' => 'sat'],
            )
        );
        Schema::create('month_names', function (Blueprint $table) {
            $table->bigIncrements('w_ID');
            $table->enum('m_name', ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        });
        DB::table('month_names')->insert(
            array(
                ['m_name'=>'Jan'],
                ['m_name'=>'Feb'],
                ['m_name'=>'Mar'],
                ['m_name'=>'Apr'],
                ['m_name'=>'May'],
                ['m_name'=>'Jun'],
                ['m_name'=>'Jul'],
                ['m_name'=>'Aug'],
                ['m_name'=>'Sep'],
                ['m_name'=> 'Oct'],
                ['m_name'=> 'Nov'],
                ['m_name'=> 'Dec'],
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
        Schema::dropIfExists('week_days');
    }
}

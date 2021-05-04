<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxiTable extends Model
{
    protected $primaryKey = 't_ID';
    public $timestamps=true;

    public function schedule()
    {
       return $this->hasMany('App\TaxiSchedule','ts_t_ID','t_ID');
       
    }
}

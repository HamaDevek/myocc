<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxiSchedule extends Model
{
    protected $primaryKey = 'ts_ID';
    public $timestamps=true;
    public function taxi()
    {
        return $this->belongsTo('App\TaxiTable','ts_t_ID');
    }
    public function schedule()
    {
        return $this->belongsTo('App\WeekDays','ts_w_ID');
    }
}

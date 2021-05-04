<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeekDays extends Model
{
    protected $primaryKey = 'w_ID';
    public $timestamps=true;
    public function taxi()
    {
       return $this->hasMany('App\TaxiSchedule','ts_w_ID','w_ID');
       
    }
    public function shop()
    {
       return $this->hasMany('App\ShopSchedule','shs_sh_ID','sh_ID');
       
    }
}

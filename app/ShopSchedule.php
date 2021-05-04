<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopSchedule extends Model
{
    protected $primaryKey = 'shs_ID';
    public $timestamps=true;
    public function shop()
    {
        return $this->belongsTo('App\ShopTable','shs_sh_ID');
    }
    public function schedule()
    {
        return $this->belongsTo('App\WeekDays','shs_w_ID');
    }
}

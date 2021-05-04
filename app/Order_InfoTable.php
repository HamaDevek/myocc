<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_InfoTable extends Model
{
    public $table = 'order_info_tables';
    protected $primaryKey = 'oi_ID';
    public $timestamps=true;
    public function ordered()
    {
        return $this->hasMany('App\OrderTable','o_oi_ID','oi_ID');
    }
    public function location()
    {
        return $this->belongsTo('App\LocationTable','oi_l_ID');
    }
    public function owner()
    {
        return $this->belongsTo('App\AccountTable','oi_a_ID');
    }
    public function taxi()
    {
        return $this->hasOne('App\SendTaxiTable','st_oi_ID','oi_ID');
    }
}

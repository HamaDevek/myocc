<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopTable extends Model
{
    //
    protected $primaryKey = 'sh_ID';
    protected $table = 'shop_tables';
    public $timestamps=true;
    public function item()
    {
        return $this->hasMany('App\ItemTable');
        
    }
    public function schedule()
    {
       return $this->hasMany('App\ShopSchedule','shs_sh_ID','sh_ID');
       
    }
}

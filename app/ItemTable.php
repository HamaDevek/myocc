<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemTable extends Model
{
    protected $primaryKey = 'ip_ID';
    public $timestamps=true;
    protected $table = 'item_tables'; 
    
    public function image()
    {
        return $this->hasMany('App\ImagesIpTable','i_ip_ID','ip_ID');
    }
    public function imageAvailable()
    {
        return $this->hasOne('App\ImagesIpTable','i_ip_ID','ip_ID')->where('i_is_primary',1);
    }
    public function type()
    {
        return $this->belongsTo('App\TypeTable','ip_tp_ID');
    }
    public function colors()
    {
        return $this->hasMany('App\ItemColorTable','ic_ip_ID','ip_ID');
        
    }
    public function occation()
    {
        return $this->belongsTo('App\OccationTable','ip_oc_ID');
    }
    public function shop()
    {
        return $this->belongsTo('App\ShopTable','ip_sh_ID');
    }
    public function oreder_temp()
    {
        return $this->hasMany('App\Web\ListCart','c_ip_ID','ip_ID');
    }
    ////////////////////////
    public function qrdela()
    {
        return $this->belongsTo('App\TypeTable','ip_tp_ID')->where('tp_name','قردێلە');
    }
}

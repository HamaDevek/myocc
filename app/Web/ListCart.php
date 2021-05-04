<?php

namespace App\Web;

use Illuminate\Database\Eloquent\Model;

class ListCart extends Model
{
    protected $primaryKey = 'c_ID';
    public $timestamps=true;
    public function item()
    {
        return $this->belongsTo('App\ItemTable','c_ip_ID');
    }
    public function account()
    {
        return $this->belongsTo('App\AccountTable','c_a_ID');
    }
   
}

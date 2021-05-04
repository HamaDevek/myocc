<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeTable extends Model
{
    protected $primaryKey = 'tp_ID';
    public $timestamps=true;
    public function item()
    {
        return $this->hasMany('App\ItemTable');
    }
    public function items()
    {
        return $this->hasMany('App\ItemTable','ip_tp_ID')->select(['ip_tp_ID','ip_ID']);
    }
}

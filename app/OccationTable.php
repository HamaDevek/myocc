<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OccationTable extends Model
{
    protected $primaryKey = 'oc_ID';
    public $timestamps=true;
    public function item()
    {
        return $this->hasMany('App\ItemTable','ip_oc_ID','oc_ID');
    }
}

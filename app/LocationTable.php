<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationTable extends Model
{
    // public $table = 'location_tables';
    public $timestamps=true;
    protected $primaryKey = 'l_ID';
    public function users()
    {
        return $this->hasMany('App\AccountTable','a_l_ID','ip_ID');
    }
}

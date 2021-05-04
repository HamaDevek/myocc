<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class colorsTable extends Model
{
    protected $primaryKey = 'c_ID';
    public $timestamps=true;
    public function item()
    {
       return $this->hasMany('App\ItemColorTable','ic_c_ID','c_ID');
       
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemColorTable extends Model
{
    protected $primaryKey = 'ic_ID';
    public $timestamps=true;
    public function item()
    {
        return $this->belongsTo('App\ItemTable','ic_ip_ID');
    }
    public function color()
    {
        return $this->belongsTo('App\colorsTable','ic_c_ID');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImagesIpTable extends Model
{
    protected $primaryKey = 'i_ID';
    public $timestamps=true;
    public function item()
    {
        return $this->belongsTo('App\ItemTable','i_ip_ID');
    }
}

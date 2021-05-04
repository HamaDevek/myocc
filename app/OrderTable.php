<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderTable extends Model
{
    public $timestamps=true;
    protected $primaryKey = 'o_ID';
    public function item()
    {
        return $this->belongsTo('App\ItemTable','o_ip_ID');
    }
}

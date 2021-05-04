<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SendTaxiTable extends Model
{
    public $timestamps=true;
    protected $primaryKey = 'st_ID';
    public function taxi()
    {
        return $this->belongsTo('App\TaxiTable','st_t_ID');
    }
}

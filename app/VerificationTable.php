<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerificationTable extends Model
{
    protected $primaryKey = 'v_ID';
    public $timestamps=true;
    public function account()
    {
        return $this->belongsTo('App\AccountTable','a_ID');
    }
}

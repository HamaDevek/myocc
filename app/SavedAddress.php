<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavedAddress extends Model
{
    protected $primaryKey = 'sa_ID';
    public function account()
    {
        return $this->belongsTo('App\AccountTable','a_ID');
    }
}

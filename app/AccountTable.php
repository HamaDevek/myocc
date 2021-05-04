<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Web\ListCart;

class AccountTable extends Model
{
    protected $primaryKey = 'a_ID';
    public $timestamps=true;
    protected $hidden = [
        'a_password',
    ];


    public function location()
    {
        return $this->belongsTo('App\LocationTable','a_l_ID');
    }
    public function code()
    {
        return $this->hasOne('App\VerificationTable','v_a_ID','a_ID');
    }
    public function oreder_temp()
    {
        return $this->hasMany('App\Web\ListCart','c_a_ID','a_ID')->orderBy('created_at','DESC');
    }
    public function oreder_temp_custom()
    {
        return $this->hasMany('App\Web\ListCart','c_a_ID','a_ID')->where('c_group_by','<>',0);
    }
    public function saved_location()
    {
        return $this->hasMany('App\SavedAddress','sa_a_ID','a_ID')->orderBy('created_at','DESC');
    }
}
//->where('c_group_by','<>',0)
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{

    protected $dates = ['date'];

    function pickups() {
        return $this->hasMany('App\Pickup');
    }

    function driver() {
        return $this->belongsTo('App\User', 'driver_id', 'id');
    }

}

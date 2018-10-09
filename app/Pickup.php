<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pickup extends Model
{

    protected $dates = ['pickup_date'];

    function shop() {
        return $this->belongsTo('App\Shop');
    }

    function manager() {
        return $this->hasOne('App\User', 'id', 'manager_id');
    }

    function supermanager() {
        return $this->hasOne('App\User', 'id', 'supermanager_id');
    }

    function job() {
        return $this->belongsTo('App\Job');
    }

    function quote() {
        return $this->belongsTo('App\Quote');
    }

    function logs() {
        return $this->hasMany('App\Log');
    }

}

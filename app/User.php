<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'access_level'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    function shops() {
        return $this->belongsToMany('App\Shop');
    }

    function jobs() {
        return $this->hasMany('App\Job', 'driver_id', 'id');
    }

    function banks() {
        return $this->hasMany('App\Bank');
    }

    function pickups() {
        if($this->access_level == "supermanager") {
            return $this->hasMany('App\Pickup', 'supermanager_id', 'id');
        }
    }

    function logs() {
        return $this->hasMany('App\Log');
    }

}

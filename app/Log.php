<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{

    function quote() {
        return $this->belongsTo('App\Quote');
    }

    function job() {
        return $this->belongsTo('App\Job');
    }

    function pickup() {
        return $this->belongsTo('App\Pickup');
    }

    function user() {
        return $this->belongsTo('App\User');
    }

}

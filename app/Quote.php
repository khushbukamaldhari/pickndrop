<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{

    protected $dates = ['pickups_date'];

    function transaction() {
        return $this->hasOne('App\Transaction');
    }

    function pickups() {
        return $this->hasMany('App\Pickup');
    }

    function schedules() {
        return $this->hasMany('App\Schedule');
    }

    function changeOrders() {
        return $this->hasMany('App\ChangeOrder');
    }

    function totalChangeOrder() {

        $total = 0;

        foreach($this->changeOrders as $order) {

            $total += $order->totalAmount();

        }

        return $total;

    }

}

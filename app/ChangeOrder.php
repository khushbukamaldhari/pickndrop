<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChangeOrder extends Model
{

    function shop() {
        return $this->belongsTo('App\Shop');
    }

    function totalAmount() {

        $total = 0;

        $total += $this->usd50 * 50;
        $total += $this->usd20 * 20;
        $total += $this->usd10 * 10;
        $total += $this->usd5 * 5;
        $total += $this->usd1 * 1;
        $total += $this->cent1 * 0.01;
        $total += $this->cent5 * 0.05;
        $total += $this->cent10 * 0.10;
        $total += $this->cent25 * 0.25;

        return $total;

    }

}

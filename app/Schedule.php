<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Schedule extends Model
{

    function quote() {
        return $this->belongsTo('App\Quote');
    }

    function shop() {
        return $this->belongsTo('App\Shop');
    }

    function collectionDaysText() {

        $text = "";

        if($this->monday) $text .= "Mondays, ";
        if($this->tuesday) $text .= "Tuesdays, ";
        if($this->wednesday) $text .= "Wednesdays, ";
        if($this->thursday) $text .= "Thursdays, ";
        if($this->friday) $text .= "Fridays, ";
        if($this->saturday) $text .= "Saturdays, ";
        if($this->sunday) $text .= "Sundays, ";

        $text = rtrim($text, ", ");

        if($this->weekly) $text .= " every week.";
        if($this->biweekly) $text .= " every second week.";
        if($this->fourweekly) $text .= " every four weeks.";

        return $text;

    }

    function nextDatesForDropdown() {

        $days = [];
        $dates = [];

        if($this->monday) array_push($days, "monday");
        if($this->tuesday) array_push($days, "tuesday");
        if($this->wednesday) array_push($days, "wednesday");
        if($this->thursday) array_push($days, "thursday");
        if($this->friday) array_push($days, "friday");
        if($this->saturday) array_push($days, "saturday");
        if($this->sunday) array_push($days, "sunday");

        foreach($days as $day) {
            $next = Carbon::parse('next ' . $day);
            $dates[$next->format('Y-m-d')] = ucfirst($day) . ' - ' . $next->format('d/m/Y');
            $dates[$next->addWeek()->format('Y-m-d')] = ucfirst($day) . ' - ' . $next->format('d/m/Y');
            $dates[$next->addWeek()->format('Y-m-d')] = ucfirst($day) . ' - ' . $next->format('d/m/Y');
            $dates[$next->addWeek()->format('Y-m-d')] = ucfirst($day) . ' - ' . $next->format('d/m/Y');
        }

        return $dates;

    }

}

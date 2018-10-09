<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

if (!request()->secure() && strpos(request()->fullUrl(), "app.brigloo.com") !== false) {
    header('Location: ' . str_replace("http://", "https://", request()->fullUrl()));die;
}

function checkUserIs($level) {

    if(Auth::check()) {

        if(Auth::user()->access_level == $level) {

            if($level == "driver" || $level == "supermanager") {
                if(Auth::user()->activated) {
                    return true;
                } else {
                    if($level == "driver") {
                        if(Auth::user()->address_1) {
                            Redirect::to('/locked')->send();
                        } else {
                            Redirect::to('/driver/setup')->send();
                        }
                    }
                    Redirect::to('/locked')->send();
                    return false;
                }
            }

            if($level == "admin") {
                return true;
            }

        }

    }

    Redirect::to('/login')->send();
    return false;

}
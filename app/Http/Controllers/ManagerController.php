<?php

namespace App\Http\Controllers;

use App\Pickup;
use App\Shop;
use Illuminate\Http\Request;

class ManagerController extends Controller
{

    public function homeHtml() {
        return view('manager.home');
    }

    public function viewPickupHtml(Request $request) {

        // store, pickup, badge

        $pickup = Pickup::where('code', $request->pickup)->first();

        if(!$pickup) {
            flash("The pickup code entered does not exist, or does not match this store. Please check it and try again.")->error();
            return redirect('/manager');
        }

        if($pickup->job->driver->badge != $request->badge) {
            flash("The driver's badge / ID number does not match this pickup. Please check it and try again")->error();
            return redirect('/manager');
        }

        // Good to go
        return view('manager.pickup', [
            'pickup' => $pickup
        ]);

    }

    public function confirmAmount(Request $request) {

        $pickup = Pickup::where('code', $request->pickup)->first();

        $pickup->amount = $request->amount;

        $pickup->save();

        flash("Amount successfully updated.")->success();

        return redirect("/manager/verify?pickup={$request->pickup}&badge={$request->badge}");

    }

}

<?php

namespace App\Http\Controllers;

use App\ChangeOrder;
use App\Pickup;
use App\Quote;
use App\Schedule;
use App\Services\Stripe;
use App\Shop;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;


class SuperManagerController extends Controller
{

    public function home() {

        checkUserIs('supermanager');

        $userShops = [];
        foreach(Auth::user()->shops as $shop) {
            array_push($userShops, $shop->id);
        }

        $pendingPickups = Pickup::whereIn('shop_id', $userShops)
                                ->whereNotIn('status', ['completed', 'cancelled', 'quote'])->get();

        $pastPickups = Pickup::whereIn('shop_id', $userShops)
            ->whereIn('status', ['completed', 'cancelled'])->get();

        return view('supermanager.home', [
            'pendingPickups' => $pendingPickups,
            'pastPickups' => $pastPickups,
            'changeOrders' => ChangeOrder::where('supermanager_id', Auth::id())->where('status', 'PENDING')->get()
        ]);

    }

    public function history() {

        checkUserIs('supermanager');

        $pastPickups = Pickup::where('supermanager_id', Auth::id())
            ->whereIn('status', ['completed', 'cancelled'])->get();

        return view('supermanager.history', [
            'pastPickups' => $pastPickups
        ]);

    }

    public function myLocationsHtml() {

        checkUserIs('supermanager');

        return view('supermanager.my_locations', [
            'shops' => Auth::user()->shops->where('deleted', '!=', 1)
        ]);

    }

    public function createLocationPost(Request $request) {

        checkUserIs('supermanager');

        $shop = new Shop();
        $shop->name = $request->placename;
        $shop->address = $request->address;
        $shop->latitude = $request->lat;
        $shop->longitude = $request->lng;
        $shop->save();

        DB::table('shop_user')->insert([
            'shop_id' => $shop->id,
            'user_id' => Auth::id()
        ]);

        flash('Location ' . $shop-> name . ' has been created.')->success();

        return redirect('/supermanager/locations');

    }

    public function createLocationAjax(Request $request) {

        checkUserIs('supermanager');

        $shop = new Shop();
        $shop->name = $request->placename;
        $shop->address = $request->address;
        $shop->latitude = $request->lat;
        $shop->longitude = $request->lng;
        $shop->save();

        DB::table('shop_user')->insert([
            'shop_id' => $shop->id,
            'user_id' => Auth::id()
        ]);

        return response()->json([
            'id' => $shop->id,
            'title' => $shop->name . ' (' . $shop->address . ')'
        ]);

    }

    public function deleteLocationAjax(Request $request) {

        checkUserIs('supermanager');

        if(Auth::user()->shops->contains($request->id)) {

            $shop = Shop::findOrFail($request->id);

            $shop->deleted = 1;
            $shop->save();

            flash("Location '{$shop->name}' has been removed.")->info();

            return "success";

        } else {
            abort(404);
        }

    }

    public function newPickupHtml() {

        checkUserIs('supermanager');

        return view('supermanager.new_pickup');

    }

    public function newChangeOrderHtml() {

        checkUserIs('supermanager');

        return view('supermanager.new_change_order');

    }

    public function newPickupPost(Request $request) {

        checkUserIs('supermanager');

        $pickupCount = 0;
        $scheduleCount = 0;
        $changeOrderCount = 0;
        $quote = null;

        // Create a new quote
        $quote = new Quote();
        $quote->save();

        if($request->pickup) {
            foreach($request->pickup as $pickupData) {

                $shop = null;

                if(array_key_exists('location', $pickupData)) {
                    $shop = Shop::find($pickupData['location']);
                }

                if($shop) {

                    if($pickupData['type'] == "oneoff") {

                        $pickup = new Pickup();

                        $pickup->shop_id = $shop->id;
                        $pickup->pickup_date = $pickupData['date'];
                        $pickup->amount = $pickupData['amount'];
                        $pickup->status = 'QUOTE';
                        $pickup->supermanager_id = Auth::id();
                        $pickup->quote_id = $quote->id;
                        $pickup->pay_to_driver = 20;

                        // Set pickup code TODO make sure this is unique
                        $pickup->code = strtoupper(str_random(6));

                        $pickup->save();

                        $pickupCount++;

                    } elseif($pickupData['type'] == "recurring") {

                        $schedule = new Schedule();
                        $schedule->supermanager_id = Auth::id();
                        $schedule->shop_id = $shop->id;
                        $schedule->active = 1;
                        $schedule->monday = isset($pickupData['monday']) ? 1 : 0;
                        $schedule->tuesday = isset($pickupData['tuesday']) ? 1 : 0;
                        $schedule->wednesday = isset($pickupData['wednesday']) ? 1 : 0;
                        $schedule->thursday = isset($pickupData['thursday']) ? 1 : 0;
                        $schedule->friday = isset($pickupData['friday']) ? 1 : 0;
                        $schedule->saturday = isset($pickupData['saturday']) ? 1 : 0;
                        $schedule->sunday = isset($pickupData['sunday']) ? 1 : 0;
                        $schedule->quote_id = $quote->id;

                        if($pickupData['frequency'] == "weekly") {
                            $schedule->weekly = 1;
                        } elseif($pickupData['frequency'] == "biweekly") {
                            $schedule->biweekly = 1;
                        } elseif($pickupData['frequency'] == "fourweekly") {
                            $schedule->fourweekly = 1;
                        }

                        $schedule->save();

                        $scheduleCount++;

                    }

                }

            }
        }

        if($request->changeorder) {
            foreach($request->changeorder as $thisChangeOrder) {
                $changeOrder = new ChangeOrder();

                $changeOrder->shop_id = $thisChangeOrder['location'];
                $changeOrder->supermanager_id = Auth::id();
                $changeOrder->usd50 = $thisChangeOrder['50usd'];
                $changeOrder->usd20 =$thisChangeOrder['20usd'];
                $changeOrder->usd10 = $thisChangeOrder['10usd'];
                $changeOrder->usd5 = $thisChangeOrder['5usd'];
                $changeOrder->usd1 = $thisChangeOrder['1usd'];
                $changeOrder->cent1 = $thisChangeOrder['1cent'];
                $changeOrder->cent5 = $thisChangeOrder['5cents'];
                $changeOrder->cent10 = $thisChangeOrder['10cents'];
                $changeOrder->cent25 = $thisChangeOrder['25cents'];

                $changeOrder->date = $thisChangeOrder['date'];

                $changeOrder->status = "QUOTE";
                $changeOrder->quote_id = $quote->id;

                $changeOrder->save();

                $changeOrderCount++;

            }
        }

        if(!$pickupCount && !$scheduleCount && !$changeOrderCount) {
            flash("You must have at least one pickup.")->error();
            return redirect('/supermanager/newpickup');
        }

        return redirect('/supermanager/newpickup/confirm/' . $quote->id);

    }

    public function newPickupPayPost(Request $request) {

        checkUserIs('supermanager');

        $quote = Quote::findOrFail($request->quote);

        $cost = (count($quote->pickups) * 30) + (count($quote->totalChangeOrder() * 30));

        if($request->stripeToken && Auth::user()->stripe_id) {
            // The customer already has a card saved, but they have chosen to update it
            $customer = Stripe::updateCustomer($request->stripeToken, Auth::user());
        }

        if($request->stripeToken && !Auth::user()->stripe_id) {
            // If we have schedules and a token, we need to save the card.
            // This runs if the customer isn't already stored on Stripe
            $customer = Stripe::createCustomer($request->stripeToken, Auth::user());
        }

        // If neither of the two conditions above ran, we'll just use whatever card
        // is saved to their Stripe, if they have one.
        if(!isset($customer) && Auth::user()->stripe_id) {
            $customer = Stripe::getCustomer(Auth::user());
        }

        if(count($quote->pickups)) {

            // If we have pickups, charge the card now.
            $transaction = new Transaction();
            $transaction->type = "SUPERMANAGER_PAYMENT";
            $transaction->user_id = Auth::id();
            $transaction->quote_id = $quote->id;
            $transaction->amount = $cost;
            $transaction->status = "UNPAID";
            $transaction->save();

            // Charge the super admin
            if(isset($customer)) {
                // We saved the customer just further up, so charge that instead of the card
                $charge = Stripe::chargeCustomer(Auth::user(), $cost, 'QUOTE-' . $quote->id);
            } else {
                echo "Sorry, an error occurred. No Stripe customer.";
            }

            if($charge['paid']) {
                $transaction->status = "PAID";
                $transaction->save();
            } else {
                echo "There was an error charging your card. It may have been declined by your bank. Please contact support.";
            }

            foreach($quote->pickups as $pickup) {
                $pickup->status = "PENDING";
                $pickup->gross = 30;
                $pickup->save();
            }

        }

        foreach($quote->schedules as $schedule) {
            $schedule->active = 1;
            $schedule->save();
        }

        foreach($quote->changeOrders as $order) {
            $order->status = "PENDING";
            $order->save();
        }

        flash("Thank you. We're now processing your order.")->success();

        return redirect('/supermanager');

    }

    public function newPickupConfirmationHtml(Request $request, $quote) {

        checkUserIs('supermanager');

        $quote = Quote::findOrFail($quote);

        $pickups = Pickup::where('quote_id', $quote->id)->get();

        // todo user verification

        return view('supermanager.new_pickup_confirm', [
            'pickups' => $pickups,
            'quote' => $quote
        ]);

    }

    public function newChangeOrderPost(Request $request) {

        checkUserIs('supermanager');

        $quote = new Quote();
        $quote->save();

        $changeOrder = new ChangeOrder();

        $changeOrder->shop_id = $request->location;
        $changeOrder->supermanager_id = Auth::id();
        $changeOrder->usd50 = $request->input('50usd');
        $changeOrder->usd20 = $request->input('20usd');
        $changeOrder->usd10 = $request->input('10usd');
        $changeOrder->usd5 = $request->input('5usd');
        $changeOrder->usd1 = $request->input('1usd');
        $changeOrder->cent1 = $request->input('1cent');
        $changeOrder->cent5 = $request->input('5cents');
        $changeOrder->cent10 = $request->input('10cents');
        $changeOrder->cent25 = $request->input('25cents');

        $changeOrder->date = $request->date;

        $changeOrder->status = "QUOTE";
        $changeOrder->quote_id = $quote->id;

        $changeOrder->save();

//        Stripe::chargeCreditCard($request->stripeToken, 3000, 'CHANGEORDER' . $changeOrder->id);

//        flash("Thank you. We've received your change order request and will process it shortly.")->success();

        return redirect("/supermanager/newpickup/confirm/" . $quote->id);

    }

    public function viewPickupHtml(Request $request, $pickup) {

        checkUserIs('supermanager');

        $pickup = Pickup::findOrFail($pickup);

        return view('supermanager.view_pickup', [
            'pickup' => $pickup
        ]);

    }
    
    public function edit_location_form( $id ) {

        checkUserIs('supermanager');

        if(Auth::user()->shops->contains( $id )) {
            
            $location_info = Shop::where( [ 'id' => $id ] )->get();
            return view("supermanager.edit_location", compact( 'location_info' )  );
            

        } else {
            abort(404);
        }

    }
    
    
    
    public function edit_location( Request $request , $id ) {

        checkUserIs('supermanager');
        
        
        if(Auth::user()->shops->contains( $id )) {
            $data = $request->all();
            
            if ( !is_null( $data['placename'] ) or !is_null( $data['address'] ) ){
                
                Shop::where( [ 'id'=> $id ] )->update( 
                    ['name'         => $data['placename'],
                    'address'       => $data['address'],
                    'latitude'      => $data['lat'],
                    'longitude'     => $data['lng']
                    ]);
//                $location_info = Shop::where( [ 'id' => $id ] )->get();
                flash("Location update successfully")->success();
                return redirect('/supermanager/locations');
            }else{
                flash("Please add data")->success();
            }

        } else {
            abort(404);
        }

    }

}

<?php

namespace App\Http\Controllers;

use App\Job;
use App\Log;
use App\Pickup;
use App\Services\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{

    public function home() {

        checkUserIs('driver');

        return view('driver.home', [
            'jobs' => Auth::user()->jobs->whereIn('status', ['CLAIMED', 'STARTED'])
        ]);
    }

    public function findJobsHtml() {

        checkUserIs('driver');

        $jobs = Job::where('Status', 'PENDING')->get();

        return view('driver.find_jobs', [
            'jobs' => $jobs
        ]);

    }

    public function financeHtml() {

        checkUserIs('driver');

        $balance = Stripe::getBalance(Auth::user());

        return view('driver.finance', [
            'pending' => $balance['pending']['0']['amount'],
            'available' => $balance['available']['0']['amount']
        ]);

    }

    public function acceptJobPost(Request $request) {

        checkUserIs('driver');

        $job = Job::findOrFail($request->job_id);

        if(($job->driver_id && $job->driver_id != Auth::id()) || $job->status != "PENDING") {
            // Uh oh - someone just claimed this job
            return "Sorry - someone else just claimed this job.";
        }

        $job->driver_id = Auth::id();
        $job->status = "CLAIMED";

        $job->save();

        Log::insert([
            'job_id' => $job->id,
            'user_id' => Auth::id(),
            'message' => 'User #' . Auth::id() . ' (' . Auth::user()->name . ') accepted this job.',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        flash("You've taken on this job! Get started now.")->success();

        return redirect('/driver');

    }

    public function myAccountHtml(Request $request) {

        checkUserIs('driver');

        return view('driver.myaccount', []);

    }

    public function myAccountUpdate(Request $request) {

        checkUserIs('driver');

        $user = Auth::user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->badge = $request->badge;
        $user->address_1 = $request->address1;
        $user->address_2 = $request->address2;
        $user->city = $request->city;
        $user->state = $request->state;

        $user->save();

        flash('Your user information has been updated')->success();

        Log::insert([
            'user_id' => Auth::id(),
            'message' => 'User #' . Auth::id() . ' (' . Auth::user()->name . ') updated their account information.',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect('/driver/myaccount');

    }

    public function jobHistory() {
        
        checkUserIs('driver');

        return view('driver.history', [
            'jobs' => Job::where("user_id", Auth::id())->where("status", "COMPLETED")->where()->get()
        ]);

    }
    
    public function edit_profileHtml( ) {

        checkUserIs('driver');
        
        return view( "driver.edit_profile" );
    }
    

}

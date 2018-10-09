<?php

namespace App\Http\Controllers;

use App\Job;
use App\Pickup;
use Illuminate\Http\Request;
use Aloha\Twilio\Twilio;
use Illuminate\Support\Facades\Auth;
use App\Log;

class ActiveJobController extends Controller
{

    // TODO permissions / security

    public function start($jobId) {

        $job = Job::findOrFail($jobId);

        $pickups = $job->pickups()->orderBy('order')->get();

        foreach($pickups as $pickup) {
            if($pickup->status == "PENDING" || $pickup->status == "ONROUTE" || $pickup->status == "ARRIVED") {
                // This is the first one, re-direct to it
                return redirect("/driver/activejob/" . $job->id . "/pickup/" . $pickup->id);
            }
        }

        // If we get to here, then all jobs are done.
        // Go to bank drop off page.

        return view('driver.activejob.bank', [
            'job' => $job
        ]);

    }

    public function pickupPage($jobId, $pickupId) {

        $job = Job::findOrFail($jobId);
        $pickup = Pickup::findOrFail($pickupId);

        return view('driver.activejob.pickup', [
            'job' => $job,
            'pickup' => $pickup
        ]);

    }

    public function startPickupPost(Request $request) {

        $pickup = Pickup::findOrFail($request->pickup_id);
        $pickup->status = "ONROUTE";
        $pickup->save();

        $pickup->job->status = "INPROGRESS";
        $pickup->save();

        return redirect('/driver/activejob/' . $pickup->job->id . '/pickup/' . $pickup->id);

    }

    public function markArrivedPost(Request $request) {

        $pickup = Pickup::findOrFail($request->pickup_id);

        $pickup->status = "ARRIVED";

        $pickup->save();

        return redirect('/driver/activejob/' . $pickup->job->id . '/pickup/' . $pickup->id);

    }

    public function markJobFinishedPost(Request $request) {

        $pickup = Pickup::findOrFail($request->pickup_id);

        $pickup->status = "COMPLETED";

        // TODO Store the managers name and id

        $pickup->save();

        return redirect('/driver/activejob/' . $pickup->job->id);

    }

    public function finishBankPost(Request $request) {

        $job = Job::findOrFail($request->job_id);

        $job->status = "COMPLETED";

        $job->save();

        flash("The job was marked as completed. Thank you.")->success();

        Log::insert([
            'user_id' => Auth::id(),
            'job_id' => $job->id,
            'message' => "User #" . Auth::id() . " completed job #{$job->id}.",
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect('/driver');

    }

    public function emergencyStop(Request $request) {

        $job = Job::findOrFail($request->job_id);

        Log::insert([
            'user_id' => Auth::id(),
            'job_id' => $job->id,
            'message' => "Emergency stop {$request->action}: " . date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        


    }

}

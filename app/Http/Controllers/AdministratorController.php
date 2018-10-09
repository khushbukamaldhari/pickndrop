<?php

namespace App\Http\Controllers;

use App\Job;
use App\Log;
use App\Pickup;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ChangeOrder;
use Illuminate\Support\Facades\Auth;
use App\Schedule;

class AdministratorController extends Controller
{

    public function home() {

        return view('administrator.home', [
            'unsortedPickups' => Pickup::whereNull('job_id')->get(),
            'unsortedChangeOrders' => ChangeOrder::where('status', 'PENDING')->get()
        ]);

    }

    public function currentJobs() {

        return view('administrator.current_jobs', [
            'jobs' => Job::where('Status', '!=', 'COMPLETE')->orderBy('created_at', 'DESC')->get()
        ]);

    }

    public function ajaxGetPickups(Request $request) {

        $pickupList = explode(',', $request->pickups);

        $pickups = Pickup::whereIn('id', $pickupList)->get();

        return view('administrator.get_pickups_ajax', [
            'pickups' => $pickups
        ]);

    }

    public function mergePost(Request $request) {

        $pickupsList = explode(',', $request->pickups);

        $pickups = Pickup::whereIn('id', $pickupsList)->get();

        $job = new Job();
        $job->status = "PENDING";
        $job->save();

        foreach($pickups as $pickup) {

            $pickup->job_id = $job->id;
            $job->date = date('Y-m-d', strtotime($pickup->pickup_date));
            
            // Paid to driver
            $pickup->pay_to_driver = 20;

            $pickup->save();

        }

        $job->save();

        flash(count($pickupsList) . ' pickups were merged into a job, and sent to drivers.')->success();

        return redirect('/admin');

    }

    public function newSignups(Request $request) {

        $query = DB::table('users');

        $query->where(function ($query) {
            $query->where('activated', 0)->orWhereNull('activated');
        });

        $query->where(function ($query) {
            $query->where('rejected', 0)->orWhereNull('rejected');
        });

        $users = $query->get();

        return view('administrator.new_signups', [
            'users' => $users
        ]);

    }

    public function viewLog(Request $request) {

        return view('administrator.logs', [
            'logs' => Log::orderBy('id', 'desc')->get()
        ]);

    }



    public function acceptUser(Request $request) {

        $user = User::findOrFail($request->user);

        $user->activated = 1;
        $user->rejected = 0;

        $user->save();

        Log::insert([
            'user_id' => $user->id,
            'message' => 'User #' . $user->id . ' (' . $user->name . ') was accepted sign-up by admin.',
            'created_at' => date('Y-m-d H:i:s')
        ]);

    }

    public function rejectUser(Request $request) {

        $user = User::findOrFail($request->user);

        $user->activated = 0;
        $user->rejected = 1;

        $user->save();

        Log::insert([
            'user_id' => $user->id,
            'message' => 'User #' . $user->id . ' (' . $user->name . ') was rejected sign-up by admin.',
            'created_at' => date('Y-m-d H:i:s')
        ]);

    }

    public function completeChangeOrder(Request $request) {

        $changeOrder = ChangeOrder::findOrFail($request->id);

        $changeOrder->status = "COMPLETE";

        $changeOrder->save();

        Log::insert([
            'user_id' => Auth::id(),
            'message' => "Change order #{$changeOrder->id} was completed. $" . $changeOrder->totalAmount() . " was delivered.",
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return "success";

    }

    public function cancelChangeOrder(Request $request) {

        $changeOrder = ChangeOrder::findOrFail($request->id);

        $changeOrder->status = "CANCELLED";

        $changeOrder->save();

        Log::insert([
            'user_id' => Auth::id(),
            'message' => "Change order #{$changeOrder->id} was cancelled. Reason: " . $request->reason,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return "success";

    }


    public function viewPickup(Request $request, $pickupId) {

        $pickup = Pickup::findOrFail($pickupId);

        return view('administrator.view_pickup', [
            'pickup' => $pickup
        ]);

    }

    public function viewSchedules() {
        
        $schedules = Schedule::all()->sortByDesc('id');

        return view('administrator.schedules', [
            'schedules' => $schedules
        ]);

    }

}

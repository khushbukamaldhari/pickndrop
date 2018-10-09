<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class AdministratorUserManagementController extends Controller
{
    
    public function searchHome(Request $request) {

        return view('administrator.users.search_home');

    }

    public function searchResults(Request $request) {

        $query = DB::table('users');

        if($request->name) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if($request->email) {
            $query->where('name', 'LIKE', '%' . $request->email . '%');
        }

        if($request->zip_code) {
            $query->where('zip_code', 'LIKE', '%' . $request->zip_code . '%');
        }

        if($request->badge) {
            $query->where('badge', 'LIKE', '%' . $request->badge . '%');
        }

        if($request->user_type) {
            $query->where('access_level', $request->user_type);
        }

        if($request->user_status) {
            if($request->user_status == "rejected") {
                $query->where('rejected', 1);
            } elseif($request->user_status == "activated") {
                $query->where('activated', 1);
            }
        }

        $query->where('access_level', '!=', 'administrator');

        $users = $query->get();

        return view('administrator.users.search_results', [
            'users' => $users
        ]);

    }

    public function viewUser($id) {

        $user = User::findOrFail($id);

        return view('administrator.users.view_user', [
            'user' => $user
        ]);

    }

}

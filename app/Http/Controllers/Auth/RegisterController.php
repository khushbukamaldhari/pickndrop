<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Mail\mailtrap;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'type' => 'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        if($data['type'] == "supermanager") {
            $businessName = $data['business_name'];
            $ein = $data['ein'];
            $title = $data['title'];
            $add1 = $data['address_1'];
            $add2 = $data['address_2'];
            $city = $data['city'];
            $state = $data['state'];
            $zip = $data['zip_code'];
        } else {
            $businessName = "";
            $ein = "";
            $title = "";
            $add1 = "";
            $add2 = "";
            $city = "";
            $state = "";
            $zip = "";
        }
        Mail::to( $data['email'] )->send(new mailtrap());
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'access_level' => $data['type'],
            'business_name' => $businessName,
            'title' => $title,
            'address1' => $add1,
            'address2' => $add2,
            'city' => $city,
            'state' => $state,
            'zip' => $zip,
            'ein' => $ein
        ]);
    }
}

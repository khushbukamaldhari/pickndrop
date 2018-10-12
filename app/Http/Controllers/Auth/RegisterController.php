<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\UserMeta;
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
    public $insert_meta_data;
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
        
        
        $insert_id = User::create([
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
        
        $current_time = time();
        $key = md5( $insert_id['id']. '-' . $current_time );
        $meta_key = "varification_link_data";
        $meta_value = array( "generated_key" => $key,
                "generated_time" => $current_time,
                "link_verified" => 0 );
        $meta_value = json_encode( $meta_value );  
        $id = $insert_id['id'];
        $insert_meta_data = UserMeta::create([
            'id' => $id,
            'st_meta_key' => $meta_key,
            'st_meta_value' => $meta_value
        ]);
        
        $objDemo = new \stdClass();
        $objDemo->username = $data['name'];
        $objDemo->link = $key;
        $objDemo->type = 'signup';
        $objDemo->id = $id;
        
//        Mail::to( $data['email'] )->send( new mailtrap($objDemo) );
        Mail::to( 'webdev3514@gmail.com' )->send( new mailtrap($objDemo) );
        return $insert_id;
    }
}

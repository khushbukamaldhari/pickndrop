<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\UserMeta;
use App\Mail\mailtrap;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Redirect;

class EditProfileController extends Controller
{
    //
    
    
    public function verify_html( $id, $type , $key  ) {
         $checkkey = $key;
//       if( Auth::check() ) {
//
//            if( Auth::user()->access_level ==  "driver" ||  Auth::user()->access_level == "supermanager" ) {
        if( $type == "signup" ){
             $usermeta_info = UserMeta::where( [ 'id' => $id , 'st_meta_key' => 'varification_link_data' ] )->get();
        }else if( $type == "change_password" ){
             $usermeta_info = UserMeta::where( [ 'id' => $id , 'st_meta_key' => 'ch_pwd_varification_link_data' ] )->get();
        }else if( $type == "change_email" ){
             $usermeta_info = UserMeta::where( [ 'id' => $id , 'st_meta_key' => 'ch_email_varification_link_data' ] )->get();
        }
       
        $varification_data = json_decode( $usermeta_info[0]['st_meta_value'] );
        $verify_time = date( "Y-m-d H:i:s", $varification_data->generated_time  );
        $current_time = date( "Y-m-d H:i:s" );
        
        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $verify_time );
        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $current_time);
        $current_datetime = time();
        $key = md5( $id. '-' . $current_datetime );
        $meta_value = array( "generated_key" => $key,
                "generated_time" => $current_datetime,
                "link_verified" => 1 );
        $meta_value = json_encode( $meta_value ); 
        $diff = $to->diffInDays($from);
        
        //FOR ALSO KEY CHECKING
        if( $checkkey == $varification_data->generated_key ) {

        } else {
            flash( "Link is broken" )->success();
            return view( "user.verify" );
        }
        if ( $diff <= 0 || $varification_data->link_verified == 0) {  
            if( $type == "signup" ){
                $update_key = 'varification_link_data';
            }else if( $type == "change_password" ){
                $update_key = 'ch_pwd_varification_link_data';
            }else if( $type == "change_email" ){
                $update_key = 'ch_email_varification_link_data';
            }
            $update_id = UserMeta::where( [ 'id'=> $id ,'st_meta_key' => $update_key ] )->update( 
                [ 'st_meta_value'   => $meta_value
                ]);
            if( $update_id > 0 ){
                flash( "Link verified successfully." )->success();
            }
        }else{
            flash( "Link has been expire" )->success();
        }
        if( $type == "signup" ){
            return view( "user.verify" );
        } else if( $type == "change_password" ){
            $link_verify = "Verified";
            return view( "user.change_password", compact( 'link_verify' ) );
        }  else if( $type == "change_email" ){
            $link_verify = "Verified";
            return view( "user.change_email", compact( 'link_verify' ) );
        }  
        
//            }
//            
//            if( $level == "admin" ) {
//                return true;
//            }
//            
//        }
//        Redirect::to('/login')->send();
//        return false;
        
        
    }
    
    public function change_password_html( ) {

        if( Auth::check() ) {
//
            if( Auth::user()->access_level ==  "driver" ||  Auth::user()->access_level == "supermanager" ) {
                $id = Auth::user()->id;
                $link_verify = "link_verify";
                $usermeta_info = UserMeta::where( [ 'id' => $id , 'st_meta_key' => 'ch_pwd_varification_link_data' ] )->get();
                
                if ( isset( $usermeta_info[0]['st_meta_value'] ) ){
                    $varification_data = json_decode( $usermeta_info[0]['st_meta_value'] );
                    $link_varified = $varification_data->link_verified;
                    $current_time = time();
                    $key = md5( $id . '-' . $current_time );
                    $meta_key = "ch_pwd_varification_link_data";
                    $meta_value = array( "generated_key" => $key,
                            "generated_time" => $current_time,
                            "link_verified" => 0 );
                    $meta_value = json_encode( $meta_value );
                    $insert_meta_data = UserMeta::where( [ 'id'=> $id ,'st_meta_key' => 'ch_pwd_varification_link_data' ] )->update( 
                        ['st_meta_value' => $meta_value
                        ]);
                    if( $link_varified <= 0 ){
                        $link_verify = "link_verified";
                    }else{
                        $link_verify = "link_verify";
                    }
                    
                    $objDemo = new \stdClass();
                    $objDemo->username = Auth::user()->name;
                    $objDemo->link = $key;
                    $objDemo->type = 'change_password';
                    $objDemo->id = $id;

//                    Mail::to( Auth::user()->email )->send( new mailtrap($objDemo) );
                    Mail::to( 'webdev3514@gmail.com' )->send( new mailtrap($objDemo) );
                    
                    return view( "user.change_password", compact( 'link_verify' ) );
                }else{
                    $current_time = time();
                    $key = md5( $id . '-' . $current_time );
                    $meta_key = "ch_pwd_varification_link_data";
                    $meta_value = array( "generated_key" => $key,
                            "generated_time" => $current_time,
                            "link_verified" => 0 );
                    $meta_value = json_encode( $meta_value );
                    $insert_meta_data = UserMeta::create([
                        'id' => $id,
                        'st_meta_key' => $meta_key,
                        'st_meta_value' => $meta_value
                    ]);
                    
                    $link_verify = "link_verified";
                    $objDemo = new \stdClass();
                    $objDemo->username = Auth::user()->name;
                    $objDemo->link = $key;
                    $objDemo->type = 'change_password';
                    $objDemo->id = $id;

                    Mail::to( 'webdev3514@gmail.com' )->send( new mailtrap($objDemo) );
                    return view( "user.change_password", compact( 'link_verify' ) );
                }
                
            }
    //            
            if( $level == "admin" ) {
                return true;
            }

            }
        Redirect::to('/login')->send();
        return false;
    }
    
    public function change_password( Request $request ) {

        if( Auth::check() ) {
//
            if( Auth::user()->access_level ==  "driver" ||  Auth::user()->access_level == "supermanager" ) {
                $id = Auth::user()->id;
                $currentuser = user::find($id);
                $data = $currentuser->all();
                $form_data = $request->all();
                $old_password = bcrypt( $form_data['old_password'] );
                $password =  bcrypt( $form_data['password'] );
                $db_password =  $data[0]['password'];
                if ( !is_null( $form_data['old_password'] ) or !is_null( $form_data['password'] ) ){
                    if ( Hash::check( $form_data['old_password'], Auth::user()->password ) ) {

                        $update_id = User::where( [ 'id'=> $id ] )->update( 
                            ['password'   => $password
                            ]);
                        if( $update_id > 0){
                            flash("Password update successfully")->success();
                             if( Auth::user()->access_level ==  "driver"){
                                 return redirect('/driver/edit_profile');
                             }else{
                                 return redirect('/supermanager/edit_profile');
                             }
                            
                            }else{
                            flash("Password is wrong")->success();
                            return redirect('/user/change_password_html');
                        }

                    }else{
                        flash("Password is wrong")->success();
                        return redirect('/user/change_password_html');
                    }

                }else{
                    flash("Please add Password")->success();
                }
            }
    //            
            if( $level == "admin" ) {
                return true;
            }

            }
        Redirect::to('/login')->send();
        return false;

    }

    public function change_email_html( ) {

        if( Auth::check() ) {
//
            if( Auth::user()->access_level ==  "driver" ||  Auth::user()->access_level == "supermanager" ) {
                $id = Auth::user()->id;
                $link_verify = "link_verify";
                $usermeta_info = UserMeta::where( [ 'id' => $id , 'st_meta_key' => 'ch_email_varification_link_data' ] )->get();
                
                if ( isset( $usermeta_info[0]['st_meta_value'] ) ){
                    $current_time = time();
                    $key = md5( $id . '-' . $current_time );
                    $meta_key = "ch_email_varification_link_data";
                    $meta_value = array( "generated_key" => $key,
                            "generated_time" => $current_time,
                            "link_verified" => 0 );
                    $meta_value = json_encode( $meta_value );
                    $insert_meta_data = UserMeta::where( [ 'id'=> $id ,'st_meta_key' => 'ch_email_varification_link_data' ] )->update( 
                        ['st_meta_value' => $meta_value
                        ]);
                    $varification_data = json_decode( $usermeta_info[0]['st_meta_value'] );
                    $link_varified = $varification_data->link_verified;
                    if( $link_varified <= 0 ){
                        $link_verify = "link_verified";
                    }else{
                        $link_verify = "link_verify";
                    }
                    $objDemo = new \stdClass();
                    $objDemo->username = Auth::user()->name;
                    $objDemo->link = $key;
                    $objDemo->type = 'change_email';
                    $objDemo->id = $id;

//                    Mail::to( Auth::user()->email )->send( new mailtrap($objDemo) );
//                    Mail::to( 'webdev3514@gmail.com' )->send( new mailtrap($objDemo) );
                    
                    return view( "user.change_email", compact( 'link_verify' ) );
                }else{
                    $current_time = time();
                    $key = md5( $id . '-' . $current_time );
                    $meta_key = "ch_email_varification_link_data";
                    $meta_value = array( "generated_key" => $key,
                            "generated_time" => $current_time,
                            "link_verified" => 0 );
                    $meta_value = json_encode( $meta_value );
                    $insert_meta_data = UserMeta::create([
                        'id' => $id,
                        'st_meta_key' => $meta_key,
                        'st_meta_value' => $meta_value
                    ]);
                    
                    $link_verify = "link_verified";
                    $objDemo = new \stdClass();
                    $objDemo->username = Auth::user()->name;
                    $objDemo->link = $key;
                    $objDemo->type = 'change_email';
                    $objDemo->id = $id;

//                    Mail::to( 'webdev3514@gmail.com' )->send( new mailtrap($objDemo) );
                    return view( "user.change_email", compact( 'link_verify' ) );
                }
                
            }
    //            
            if( $level == "admin" ) {
                return true;
            }

            }
        Redirect::to('/login')->send();
        return false;
    }
    
    public function change_email( Request $request ) {

        if( Auth::check() ) {
//
            if( Auth::user()->access_level ==  "driver" ||  Auth::user()->access_level == "supermanager" ) {
                $id = Auth::user()->id;
                
                $form_data = $request->all();
                $new_email = $form_data['email'];
                if ( !is_null( $form_data['email'] ) ){
                    $usermeta_info = User::where( ['email' => $new_email ] )->get();
                 
                    if( isset ( $usermeta_info[0]['email'] ) && $usermeta_info[0]['email'] == $new_email ){
                        flash("Email already exists")->success();
                        return view( "user.change_email");
                    }else{
                        $current_datetime = time();
                        $key = md5( $id. '-' . $current_datetime );
                        $meta_value = array( "generated_key" => $key,
                                "generated_time" => $current_datetime,
                                "link_verified" => 0 );
                        $meta_value = json_encode( $meta_value ); 
                        $insert_meta_data = UserMeta::where( [ 'id'=> $id ,'st_meta_key' => 'ch_email_varification_link_data' ] )->update( 
                        ['st_meta_value' => $meta_value
                        ]);
                         $usermeta_infom = UserMeta::where( [ 'id' => $id , 'st_meta_key' => 'ch_email_varification_link_data' ] )->get();
                        $varification_data = json_decode( $usermeta_infom[0]['st_meta_value'] );
                        $link_varified = $varification_data->link_verified;
                        if( $link_varified <= 0 ){
                            $link_verify = "link_verified"; 
                        }
//                        else{
                            $insert_data_id = User::where( [ 'id'=> $id ] )->update( 
                            ['email' => $new_email
                            ]);
                            $link_verify = "link_verify";
//                        }
                          
                        $objDemo = new \stdClass();
                        $objDemo->username = Auth::user()->name;
                        $objDemo->link = $key;
                        $objDemo->type = 'change_email';
                        $objDemo->id = $id;
                        flash( "Please link verified" )->success();
                        Mail::to( 'webdev3514@gmail.com' )->send( new mailtrap($objDemo) );
                        return view( "user.change_email");
                    }                

                }else{
                    flash("Please add email")->success();
                }
            }

            }
        Redirect::to('/login')->send();
        return false;

    }

}

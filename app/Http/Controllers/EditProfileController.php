<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class EditProfileController extends Controller
{
    //
    public function edit_profileHtml( ) {

        checkUserIs('supermanager');
        
        return view( "user.edit_profile" );
    }
    
    public function change_password_html( ) {

        checkUserIs('supermanager');
        
        return view( "user.change_password" );
    }
    
    public function change_password( Request $request ) {

        checkUserIs('supermanager');
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
                        return redirect('/user/edit_profile');
                    }else{
                        flash("Password not update successfully")->success();
                        return redirect('/user/change_password_html');
                    }
                    
                }else{
                    flash("Password not update successfully")->success();
                    return redirect('/user/change_password_html');
                }
                
            }else{
                flash("Please add Password")->success();
            }

    }
}

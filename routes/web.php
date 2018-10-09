<?php

// User types: admin, driver, manager, supermanager
use Aloha\Twilio\Twilio;

require_once('useful.php');

Route::get('/', function () {
    return view('welcome');
});
Route::get('/supermanager', 'SuperManagerController@home');
Route::get('/supermanager/history', 'SuperManagerController@history');
Route::get('/supermanager/newpickup', 'SuperManagerController@newPickupHtml');
Route::post('/supermanager/newpickup', 'SuperManagerController@newPickupPost');
Route::get('/supermanager/newpickup/confirm/{quote}', 'SuperManagerController@newPickupConfirmationHtml');
Route::post('/supermanager/newpickup/pay', 'SuperManagerController@newPickupPayPost');
Route::get('/supermanager/newchangeorder', 'SuperManagerController@newChangeOrderHtml');
Route::post('/supermanager/newchangeorder', 'SuperManagerController@newChangeOrderPost');
Route::get('/supermanager/locations', 'SuperManagerController@myLocationsHtml');
Route::post('/supermanager/locations', 'SuperManagerController@createLocationPost');


Route::get('/supermanager/delete-location-ajax', 'SuperManagerController@deleteLocationAjax');
Route::get('/supermanager/edit_location_form/{id}', 'SuperManagerController@edit_location_form');
Route::post('/supermanager/edit_location/{id}', 'SuperManagerController@edit_location');
Route::get('/supermanager/pickup/{pickup}', 'SuperManagerController@viewPickupHtml');
Route::get('/supermanager/newchangeorder/confirm/{quote}', 'SuperManagerController@newChangeOrderConfirmationHtml');

Route::post('/supermanager/locations/ajax', 'SuperManagerController@createLocationAjax');
Route::post('/supermanager/locations/ajax', 'SuperManagerController@createLocationAjax');

Route::get('/admin', 'AdministratorController@home');
Route::get('/admin/current-jobs', 'AdministratorController@currentJobs');
Route::get('/admin/new-signups', 'AdministratorController@newSignups');
Route::get('/admin/log', 'AdministratorController@viewLog');
Route::get('/admin/ajax-get-pickups', 'AdministratorController@ajaxGetPickups');
Route::post('/admin/merge-pickups', 'AdministratorController@mergePost');

Route::get('/admin/accept-user', 'AdministratorController@acceptUser');
Route::get('/admin/reject-user', 'AdministratorController@rejectUser');

Route::get('/admin/users', 'AdministratorUserManagementController@searchHome');
Route::get('/admin/users/search', 'AdministratorUserManagementController@searchResults');
Route::get('/admin/users/{id}', 'AdministratorUserManagementController@viewUser');

Route::get('/admin/change-order-complete', 'AdministratorController@completeChangeOrder');
Route::get('/admin/change-order-cancel', 'AdministratorController@cancelChangeOrder');

Route::get('/admin/pickups/{id}', 'AdministratorController@viewPickup');

Route::get('/admin/schedules', 'AdministratorController@viewSchedules');



Route::get('/driver', 'DriverController@home')->middleware('auth', 'activated');

Route::get('/driver/setup', 'DriverRegisterController@registerHtml')->middleware('auth');
Route::post('/driver/setup', 'DriverRegisterController@registerPost')->middleware('auth');

Route::get('/driver/bankaccount', 'DriverRegisterController@bankAccountHtml')->middleware('auth');
Route::post('/driver/bankaccount', 'DriverRegisterController@bankAccountSave')->middleware('auth');

Route::get('/driver/finance', 'DriverController@financeHtml')->middleware('auth');

Route::get('/driver/findjobs', 'DriverController@findJobsHtml')->middleware('auth');

Route::post('/driver/acceptjob', 'DriverController@acceptJobPost')->middleware('auth');


Route::get('/driver/myaccount', 'DriverController@myAccountHtml')->middleware('auth');
Route::post('/driver/myaccount', 'DriverController@myAccountUpdate')->middleware('auth');

Route::get('/driver/history', 'DriverController@jobHistory')->middleware('auth');

Route::get('/user/edit_profile', 'EditProfileController@edit_profileHtml');
Route::get('/user/change_password_html', 'EditProfileController@change_password_html');
Route::post('/user/change_password', 'EditProfileController@change_password');


Route::get('/driver/activejob/{jobId}', 'ActiveJobController@start')->middleware('auth');
Route::get('/driver/activejob/{jobId}/pickup/{pickupId}', 'ActiveJobController@pickupPage')->middleware('auth');

Route::post('/driver/activejob/emergency-stop', 'ActiveJobController@emergencyStop')->middleware('auth');

Route::post('/driver/start-pickup', 'ActiveJobController@startPickupPost');
Route::post('/driver/mark-arrived', 'ActiveJobController@markArrivedPost');
Route::post('/driver/mark-job-finished', 'ActiveJobController@markJobFinishedPost');

Route::post('/driver/finish-bank', 'ActiveJobController@finishBankPost');

Route::get('/manager', 'ManagerController@homeHtml');
Route::get('/manager/verify', 'ManagerController@viewPickupHtml');
Route::post('/manager/verify', 'ManagerController@confirmAmount');

Route::get('/manager/setamount', 'ManagerController@setAmount');

Auth::routes();

Route::get('/supermanager/pickuphtml', function(Request $request) {
    return view('supermanager.new_pickup_box');
});
Route::get('/supermanager/changeorderhtml', function(Request $request) {
    return view('supermanager.new_change_order_box');
});

Route::get('/home', function () {
    if(Auth::user()->access_level == "driver") {
        return redirect('/driver');
    }
    if(Auth::user()->access_level == "manager") {
        return redirect('/manager');
    }
    if(Auth::user()->access_level == "supermanager") {
        return redirect('/supermanager');
    }
    if(Auth::user()->access_level == "admin") {
        return redirect('/admin');
    }
});

Route::get('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/login');
});

Route::get('/lala', function () {
    $twilio = new Aloha\Twilio\Twilio('AC4b8919332c8b1e732bc5192a529e157b', 'f448d559e0ef664f227193175910f6fc', '441173254234');
    $twilio->message('+447414108399', 'Pink Elephants and Happy Rainbows');
});

Route::get('/locked', function () {
    return view('locked');
});
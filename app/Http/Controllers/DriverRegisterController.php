<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Services\Stripe;
use Illuminate\Http\Request;
use GuzzleHttp;
use Illuminate\Support\Facades\Auth;


class DriverRegisterController extends Controller
{
    
    public function registerHtml() {
        return view('driver.setup');
    }

    public function registerPost(Request $request) {

        // TODO validation

        $data = [
            'country' => 'US',
            'type' => 'custom',
            'legal_entity' => [
                'type' => 'individual',
                'first_name' => $request->legal_first_name,
                'last_name' => $request->legal_last_name,
                'address' => [
                    'line1' => $request->address_1,
                    'line2' => $request->address_2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'postal_code' => $request->postal_code,
                ],
                'dob' => [
                    'day' => date('d', strtotime($request->date_of_birth)),
                    'month' => date('m', strtotime($request->date_of_birth)),
                    'year' => date('Y', strtotime($request->date_of_birth))
                ],
                'ssn_last_4' => $request->ssn,
            ],
            'tos_acceptance' => [
                'date' => strtotime('now'),
                'ip' => '127.0.0.1'
            ]
        ];
        
        $client = new GuzzleHttp\Client();
        $res = $client->post('https://api.stripe.com/v1/accounts', [
            'auth' => [env('STRIPE_SECRET_KEY'), ''],
            'form_params' => $data
        ]);

        $json = json_decode($res->getBody(), true);

        Auth::user()->activated = 1;
        Auth::user()->stripe_id = $json['id'];

        Auth::user()->save();

        // Todo need to sort out the status and stuff

        return redirect('/driver');

    }

    public function bankAccountHtml(Request $request) {

        return view('driver.bank_account');

    }

    public function bankAccountSave(Request $request) {

        $client = new GuzzleHttp\Client();
        $res = $client->post('https://api.stripe.com/v1/accounts/' . Auth::user()->stripe_id, [
            'auth' => [env('STRIPE_SECRET_KEY'), ''],
            'form_params' => [
                'bank_account' => $request->stripe_token
            ]
        ]);

        $json = json_decode($res->getBody(), true);

        $bank = new Bank();
        $bank->user_id = Auth::id();
        $bank->stripe_id = $request->stripe_token;
        $bank->name = $json['external_accounts']['data'][0]['bank_name'];
        $bank->routing_number = $json['external_accounts']['data'][0]['routing_number'];
        $bank->account_last_4 = $json['external_accounts']['data'][0]['last4'];; // todo last 4
        $bank->save();

        return redirect('/driver/bankaccount');

    }

}

<?php

namespace App\Services;

use GuzzleHttp;
use Illuminate\Support\Facades\Auth;

class Stripe {

    public static function getBalance($user) {

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $balance = \Stripe\Balance::retrieve(
            array("stripe_account" => $user->stripe_id)
        );

        return $balance;

    }

    public static function chargeCreditCard($token, $amount, $transferGroup) {

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        return $charge = \Stripe\Charge::create(array(
            "amount" => $amount * 100,
            "currency" => "usd",
            "source" => $token,
            "transfer_group" => $transferGroup,
        ));

    }

    public static function transferToAccount($amount, $transferTo, $charge, $transferGroup) {

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $payout = \Stripe\Transfer::create(array(
            "amount" => $amount * 100,
            "currency" => "usd",
            "destination" => "acct_1C6QwCAxgN9nxATy",
            "transfer_group" => $transferGroup,
            "source_transaction" => $charge['id']
        ));

    }

    public static function createCustomer($token, $user) {

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $customer = \Stripe\Customer::create([
            'source' => $token,
            'email' => $user->email
        ]);

        $user->stripe_id = $customer->id;

        $user->save();

        return $customer;

    }

    public static function updateCustomer($token, $user) {

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $customer = \Stripe\Customer::retrieve(Auth::user()->stripe_id);
        $customer->source = $token;
        $customer->save();

        return $customer;

    }

    public static function getCustomer($user) {

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $customer = \Stripe\Customer::retrieve(Auth::user()->stripe_id);

        return $customer;

    }

    public static function chargeCustomer($user, $amount, $transferGroup) {

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        return $charge = \Stripe\Charge::create(array(
            "amount" => $amount * 100,
            "currency" => "usd",
            "customer" => Auth::user()->stripe_id,
            "transfer_group" => $transferGroup,
        ));

    }

}
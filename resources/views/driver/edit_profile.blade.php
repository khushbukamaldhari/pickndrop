@extends('driver.master')

@section('page')

    <div class="jumbotron">
        <h4>My Account</h4>
    </div>

    @include('flash::message')

    <h5>My Account: Banking Information</h5>

    <hr />

    <div class="row mt-4">
        <div class="col-md-3">

            <div class="list-group">
                <a href="/driver/myaccount" class="list-group-item list-group-item-action ">
                    My Information
                </a>
                <a href="/driver/bankaccount" class="list-group-item list-group-item-action">
                    Bank Account
                </a>
                <a href="/driver/edit_profile" class="list-group-item list-group-item-action active">
                    Edit Profile
                </a>
            </div>

        </div>
        <div class="col-md-9">
            <div>
                <h5><a href="/user/change_password_html"><button class="btn btn-primary">Change Password</button></a></h5>
                <h5><a href="/user/change_email_html"><button class="btn btn-primary">Change Email</button></a></h5>
            </div>

            <div class="clearfix"></div>

        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>

@endsection
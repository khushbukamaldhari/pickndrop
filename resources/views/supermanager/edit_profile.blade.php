@extends('supermanager.master')

@section('page')

    <div class="jumbotron">
        <h4>My Account</h4>
    </div>

    @include('flash::message')

    <h5>My Account Information</h5>

    <hr/>

    <div class="row mt-4">
        <div class="col-md-3">

            <div class="list-group">
                <a href="/supermanager/myaccount" class="list-group-item list-group-item-action ">
                    My Information
                </a>
                <a href="/supermanager/edit_profile" class="list-group-item list-group-item-action active">
                    Change Email and Password
                </a>
            </div>

        </div>
        <div class="col-md-9">

            <div>
                <h5><a href="/user/change_password_html"><button class="btn btn-primary">Change Password</button></a></h5>
                <h5><a href="/user/change_email_html"><button class="btn btn-primary">Change Email</button></a></h5>
            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>

@endsection
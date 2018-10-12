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
                <a href="/driver/myaccount" class="list-group-item list-group-item-action active">
                    My Information
                </a>
                <a href="/driver/bankaccount" class="list-group-item list-group-item-action">
                    Bank Account
                </a>
                <a href="/driver/edit_profile" class="list-group-item list-group-item-action">
                    Edit Profile
                </a>
            </div>

        </div>
        <div class="col-md-9">

            <h4 class="mb-4">My Information</h4>

            <form method="post">

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="text" class="form-control" name="email" value="{{ Auth::user()->email }}">
                </div>

                <div class="form-group">
                    <label>Cell Phone</label>
                    <input type="text" class="form-control" name="mobile" value="{{ Auth::user()->mobile }}">
                </div>

                <div class="form-group">
                    <label>Badge / ID Number</label>
                    <input type="text" class="form-control" name="badge" value="{{ Auth::user()->badge }}">
                </div>

                <hr />

                <div class="form-group">
                    <label>Address Line 1</label>
                    <input type="text" class="form-control" name="address1" value="{{ Auth::user()->address_1 }}">
                </div>

                <div class="form-group">
                    <label>Address Line 2</label>
                    <input type="text" class="form-control" name="address2" value="{{ Auth::user()->address_2 }}">
                </div>

                <div class="form-group">
                    <label>City</label>
                    <input type="text" class="form-control" name="city" value="{{ Auth::user()->city }}">
                </div>

                <div class="form-group">
                    <label>State</label>
                    <input type="text" class="form-control" name="state" value="{{ Auth::user()->state }}">
                </div>

                <hr />

                <button type="submit" class="btn btn-primary mb-5">Save Changes</button>

                {{ csrf_field() }}

            </form>

        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>

@endsection
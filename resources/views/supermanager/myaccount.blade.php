@extends('supermanager.master')

@section('page')

    <div class="jumbotron">
        <h4>My Account</h4>
    </div>

    @include('flash::message')

    <h5>My Account Information</h5>
    <hr />

    <div class="row mt-4">
        <div class="col-md-3">

            <div class="list-group">
                <a href="/supermanager/myaccount" class="list-group-item list-group-item-action active">
                    My Information
                </a>
                <a href="/supermanager/edit_profile" class="list-group-item list-group-item-action">
                    Change Email and Password
                </a>
            </div>

        </div>
        <div class="col-md-9">

            <div></div>
            <div></div>
            
            <h4 class="mb-4">My Information</h4>
            
            
            <form method="post">

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">
                </div>

                <div class="form-group">
                    <label>Cell Phone</label>
                    <input type="text" class="form-control" name="mobile" value="{{ Auth::user()->mobile }}">
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
                
                <div class="form-group">
                    <label>Report Email Id</label>
                    <input type="text" class="form-control" name="report_email" value="{{ $usersetting_info[0]['report_email'] }} ">
                </div>
                
                <div class="form-group">
                    <label>pick-up Notification</label>
                    <div>
                        
                        <input type="radio" class="" name="pick_up" {{  $usersetting_info[0]['delivery_pickup_notification']  == '1' ? 'checked' : '' }}  value="1">Yes
                        <input type="radio" class="" name="pick_up"   {{  $usersetting_info[0]['delivery_pickup_notification']  == '0' ? 'checked' : '' }}   value="0">No
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Delivery completion Notification</label>
                    <div>
                        
                        <input type="radio" class="" name="delivery_completion"  {{  $usersetting_info[0]['delivery_completion_notification']  == '1' ? 'checked' : '' }}  value="1">Yes
                        <input type="radio" class="" name="delivery_completion"  {{  $usersetting_info[0]['delivery_completion_notification']  == '0' ? 'checked' : '' }}  value="0">No
                    </div>
                </div>
                
                

                <hr />

                <button type="submit" class="btn btn-primary mb-5">Save Changes</button>

                {{ csrf_field() }}

            </form>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>

@endsection
@extends('administrator.master')

@section('page')

    <h3 class="float-left mb-4">Search Users</h3>

    <div class="clearfix"></div>

    @include('flash::message')

    <div class="card">
        <div class="card-body">

            <form action="/admin/users/search" method="get">
                
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Person's Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>

                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="text" class="form-control" name="email">
                        </div>

                        <div class="form-group">
                            <label>ZIP Code</label>
                            <input type="text" class="form-control" name="zip_code">
                        </div>

                        <div class="form-group">
                            <label>Badge / ID Number</label>
                            <input type="text" class="form-control" name="badge">
                        </div>

                        <div class="form-group">
                            <label>User Type</label>
                            <select name="user_type" class="form-control">
                                <option value="" selected>Any Type</option>
                                <option value="supermanager">Business Owners</option>
                                <option value="driver">Drivers</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>User Status</label>
                            <select name="user_status" class="form-control">
                                <option value="" selected>Any Status</option>
                                <option value="activated">Active</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Search Users</button>
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection
    

@push('javascript')



@endpush
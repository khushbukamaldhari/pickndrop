@extends('manager.master')

@section('page')

    <div class="card">
        <div class="card-body pb-2">

            @include('flash::message')

            <h5>Store Manager Pickup Check</h5>
            <p>Enter your store code, pickup code, and the driver's badge / ID number.</p>

            <form action="/manager/verify" method="get">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Pickup Code</label>
                        <input type="text" name="pickup" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Badge / ID Number</label>
                        <input type="text" name="badge" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Store Name</label>
                        <input type="text" name="store" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">Check Now</button>
                    </div>
                </div>
                {{ csrf_field() }}
            </form>

        </div>
    </div>

@endsection
@extends('supermanager.master')

@section('page')

    <h3 class="float-left">Request New Change Order</h3>

    <div class="clearfix"></div>

    <hr />

    <div class="row">
        <div class="col-6">
            <form method="post">
                <div class="form-group">
                    <label>Location</label>
                    <select name="location" class="form-control">
                        <option selected disabled required>-- Please Select --</option>
                        @foreach(auth()->user()->shops as $shop)
                            <option value="{{ $shop->id }}">{{ $shop->name }} ({{ $shop->address }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Date</label>
                            <input type="date" class="form-control" name="date" required>
                        </div>
                    </div>
                </div>
                <hr />
                <h5>Denominations</h5>
                <div class="form-group">
                    <div class="row mt-3">
                        <div class="col-md">
                            <label>$50</label>
                            <input type="text" class="form-control" data-denomination="50" value="0" name="50usd">
                        </div>
                        <div class="col-md">
                            <label>$20</label>
                            <input type="text" class="form-control" data-denomination="20" value="0" name="20usd">
                        </div>
                        <div class="col-md">
                            <label>$10</label>
                            <input type="text" class="form-control" data-denomination="10" value="0" name="10usd">
                        </div>
                        <div class="col-md">
                            <label>$5</label>
                            <input type="text" class="form-control" data-denomination="5" value="0" name="5usd">
                        </div>
                        <div class="col-md">
                            <label>$1</label>
                            <input type="text" class="form-control" data-denomination="1" value="0" name="1usd">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md">
                            <label>1¢</label>
                            <input type="text" class="form-control" data-denomination="0.01" value="0" name="1cent">
                        </div>
                        <div class="col-md">
                            <label>5¢</label>
                            <input type="text" class="form-control" data-denomintation="0.05" value="0" name="5cents">
                        </div>
                        <div class="col-md">
                            <label>10¢</label>
                            <input type="text" class="form-control" data-denomination="0.10" value="0" name="10cents">
                        </div>
                        <div class="col-md">
                            <label>25¢</label>
                            <input type="text" class="form-control" data-denomination="0.25" value="0" name="25cents">
                        </div>
                    </div>
                </div>
                <hr />
                {{ csrf_field() }}
                <button type="submit" class="btn btn-primary">Next Step</button>
                {{--<script--}}
                        {{--src="https://checkout.stripe.com/checkout.js" class="stripe-button"--}}
                        {{--data-key="pk_test_iP4nPvZTu2h7griQfbGaYb51"--}}
                        {{--data-amount="3000"--}}
                        {{--data-name="Brigloo Test"--}}
                        {{--data-description="Pay for change order"--}}
                        {{--data-image="https://stripe.com/img/documentation/checkout/marketplace.png"--}}
                        {{--data-locale="auto"--}}
                        {{--data-email="{{ Auth::user()->email }}"--}}
                        {{--data-currency="usd">--}}
                {{--</script>--}}
            </form>
        </div>
    </div>

@endsection

@push('javascript')



@endpush
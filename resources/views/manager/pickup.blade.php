@extends('manager.master')

@section('page')

    <h4>Pickup #{{ $pickup->id }} - {{ $pickup->shop->name }}</h4>

    <div class="card">
        <div class="card-body pb-2">

            @include('flash::message')

            <h3 class="text-center">Valid - okay to continue</h3>
            <p class="text-center">The driver's badge / ID number matches up to this pickup. Please confirm the amount
            of cash, then click "finish".</p>

            <hr />

            <form method="post">
                <div class="form-group row">
                    <label>Cash Amount</label>
                    <div class="col">
                        @if($pickup->amount)
                            <input type="text" class="form-control" placeholder="Amount" name="amount" value="{{ $pickup->amount }}" required>
                        @else
                            <input type="text" class="form-control" placeholder="Amount" name="amount" value="" required>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <input type="hidden" name="badge" value="{{ request()->badge }}">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary">Finish</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection
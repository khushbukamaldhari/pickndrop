@extends('supermanager.master')

@section('page')

    <h3 class="float-left">Super Manager Dashboard</h3>
    <a href="/supermanager/newpickup" class="btn btn-success float-right">New Pickup Request</a>

    <div class="clearfix"></div>

    <hr />

    @include('flash::message')

    <h5>Current Pickups</h5>

    <div class="row">
        @foreach($pendingPickups as $pickup)
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $pickup->amount ? '$' . $pickup->amount : 'Pickup ' }} from {{ $pickup->shop->name }}</h5>
                        @if($pickup->status == "PENDING")
                            <p class="card-text">Processing job..</p>
                        @elseif($pickup->status == "WAITING")
                            <p class="card-text">Waiting for driver..</p>
                        @elseif($pickup->status == "ACCEPTED")
                            <p class="card-text">Driver has accepted..</p>
                        @elseif($pickup->status == "ONROUTE")
                            <p class="card-text">Driver is on route..</p>
                        @endif
                        <a href="/supermanager/pickup/{{ $pickup->id }}" class="btn btn-primary btn-sm">View Pickup</a>
                    </div>
                </div>
            </div>
        @endforeach
        @if(!count($pendingPickups))
            <div class="col">
                <span>No pending pickups.</span>
            </div>
        @endif
    </div>

    <hr />

    <h5>Pending Change Orders</h5>

    <div class="row">
        @foreach($changeOrders as $changeOrder)
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $changeOrder->shop->name }}</h5>
                        <table width="100%">
                            <tr>
                                <td><strong class="text-primary">$50</strong> x {{ $changeOrder->usd50 }}</td>
                                <td><strong class="text-primary">$20</strong> x {{ $changeOrder->usd20 }}</td>
                                <td><strong class="text-primary">$50</strong> x {{ $changeOrder->usd10 }}</td>
                            </tr>
                            <tr>
                                <td><strong class="text-primary">$5</strong> x {{ $changeOrder->usd5 }}</td>
                                <td><strong class="text-primary">$1</strong> x {{ $changeOrder->usd2 }}</td>
                                <td><strong class="text-primary">$0.25</strong> x {{ $changeOrder->cent25 }}</td>
                            </tr>
                            <tr>
                                <td><strong class="text-primary">$0.10</strong> x {{ $changeOrder->cent10 }}</td>
                                <td><strong class="text-primary">$0.05</strong> x {{ $changeOrder->cent5 }}</td>
                                <td><strong class="text-primary">$0.01</strong> x {{ $changeOrder->cent1 }}</td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <strong>Total: ${{ number_format($changeOrder->totalAmount(), 2) }}</strong>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
        @if(!count($changeOrders))
            <div class="col">
                <span>No pending change orders.</span>
            </div>
        @endif
    </div>

@endsection
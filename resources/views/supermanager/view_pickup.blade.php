@extends('supermanager.master')

@section('page')

    <h3>View Pickup #{{ $pickup->id }}</h3>
    <h6 class="text-secondary">Order Date: {{ $pickup->created_at->format('m/d/Y') }}</h6>

    <div class="clearfix"></div>

    <hr />

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <table width="100%">
                                <tr>
                                    <td><strong>Location:</strong></td>
                                    <td>
                                        {{ $pickup->shop->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Pickup Date:</strong></td>
                                    <td>{{ $pickup->pickup_date->format('m/d/Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Pickup Amount:</strong></td>
                                    <td>{{ $pickup->amount ? '$' . $pickup->amount : "-" }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Pickup Cost:</strong></td>
                                    <td>${{ number_format($pickup->gross, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Transaction ID:</strong></td>
                                    <td>{{ $pickup->quote->transaction->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>{{ $pickup->status }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

            <h5 class="mt-4 mb-3">Other pickups in this order</h5>

            <div class="card">
                <div class="card-body">
                    @if(count($pickup->quote->pickups) > 1)
                        <table width="100%" class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Pickup ID</th>
                                    <th>Store Location</th>
                                    <th>Pickup Date</th>
                                    <th>Cost</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            @foreach($pickup->quote->pickups as $singlePickup)
                                @if($singlePickup->id != $pickup->id)
                                    <tr>
                                        <td>#{{ $singlePickup->id }}</td>
                                        <td>{{ $singlePickup->shop->name }}</td>
                                        <td>{{ $singlePickup->pickup_date->format('d/m/Y') }}</td>
                                        <td>${{ number_format($singlePickup->gross, 2) }}</td>
                                        <td><a href="/supermanager/pickup/{{ $singlePickup->id }}">View Pickup</a></td>
                                    </tr>
                                @endif
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><strong>Total: ${{ number_format($pickup->quote->transaction->amount, 2) }}</strong></td>
                                <td></td>
                            </tr>
                        </table>
                    @else
                        No other pickups in this order
                    @endif
                </div>
            </div>

        </div>
    </div>

@endsection

@push('javascript')

    <script>



    </script>

@endpush
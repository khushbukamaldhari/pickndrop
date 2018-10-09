@extends('administrator.master')

@section('page')

    <h3 class="float-left mb-4">
        User: <em>{{  $user->name }}</em>
        @if($user->access_level == "driver")
            (Driver)
        @elseif($user->access_level == "supermanager")
            (Business)
        @endif

    </h3>

    <div class="clearfix"></div>

    @include('flash::message')

    @if(!$user->activated && !$user->rejected)
        <div class="card mb-3">
            <div class="card-body">
                <p>This user is still pending. Please accept or reject them.</p>
                <button class="btn btn-success btn-sm accept-btn" data-id="{{ $user->id }}">Accept</button>
                <button class="btn btn-danger btn-sm reject-btn" data-id="{{ $user->id }}">Reject</button>
            </div>
        </div>
    @endif
    
    <div class="card">
        <div class="card-body">

            <h5 class="mb-3">User Information</h4>

            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Mobile:</strong></td>
                            <td>{{ $user->mobile }}</td>
                        </tr>
                        @if($user->access_level == "driver")
                            <tr>
                                <td><strong>Badge:</strong></td>
                                <td>{{ $user->badge }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <td><strong>Address:</strong></td>
                            <td>
                                {!! $user->address_1 ? $user->address_1 . '<br>' : "" !!}
                                {!! $user->address_2 ? $user->address_2 . '<br>' : "" !!}
                                {!! $user->city ? $user->city . '<br>' : "" !!}
                                {!! $user->state ? $user->state . '<br>' : "" !!}
                                {!! $user->zip_code ? $user->zip_code . '<br>' : "" !!}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            </table>

        </div>
    </div>

    @if($user->access_level == "supermanager")
        <div class="card mt-3">
            <div class="card-body">
                
                <h5 class="mb-3">Pickup History</h5>

                @if(!count($user->pickups))
                    <p class="text-center text-muted">No Logs For This User</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <th>ID</th>
                            <th>Request Date</th>
                            <th>Pickup Date</th>
                            <th>Store</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            @foreach($user->pickups->where("status", "!=", "QUOTE")->sortBy() as $pickup)
                                <tr>
                                    <td><a href="/admin/pickups/{{ $pickup->id }}">#{{ $pickup->id }}</a></td>
                                    <td>{{ $pickup->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>{{ $pickup->pickup_date->format('Y-m-d') }}</td>
                                    <td>{{ $pickup->shop->name }}</td>
                                    <td>{{ $pickup->amount ? '$' . number_format($pickup->amount) : '' }}</td>
                                    <td>{{ $pickup->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    @endif


    <div class="card mt-3">
        <div class="card-body">
            
            <h5 class="mb-3">Logs ({{ count($user->logs) }})</h5>

            @foreach($user->logs as $log)
                <div class="card">
                    <div class="card-body">
                        <p>{{ $log->message }}</p>
                        <strong>{{ $log->created_at }} ({{ $log->created_at->diffForHumans() }})</strong>
                    </div>
                </div>
            @endforeach

            @if(!count($user->logs))
                <p class="text-center text-muted">No Logs For This User</p>
            @endif

        </div>
    </div>

@endsection
    

@push('javascript')

    <script>

        $('.accept-btn').click(function () {
            var user = $(this).data('id');
            var check = confirm("Are you sure you want to ACCEPT user #" + user + "?");
            if(check) {
                $.get("/admin/accept-user", {user: user}, function (data) {
                    // Successful
                    $('#row-' + user).addClass('bg-success');
                    $('#row-' + user + ' button').hide();
                }).fail(function (data) {
                    alert("Sorry, an error occurred.");
                });
            }
        });

        $('.reject-btn').click(function () {
            var user = $(this).data('id');
            var check = confirm("Are you sure you want to REJECT user #" + user + "?");
            if(check) {
                $.get("/admin/reject-user", { user: user }, function(data) {
                    // Successful
                    $('#row-' + user).addClass('bg-warning');
                    $('#row-' + user + ' button').hide();
                }).fail(function (data) {
                    alert("Sorry, an error occurred.");
                });
            }
        });

    </script>

@endpush
@extends('administrator.master')

@section('page')

    <h3 class="float-left mb-4">
        Pickup: #{{ $pickup->id }} / {{ $pickup->pickup_date->format('Y-m-d') }} / {{ $pickup->shop->name }} <strong>({{ $pickup->status }})</strong>
    </h3>

    <div class="clearfix"></div>

    @include('flash::message')
    
    <div class="card">
        <div class="card-body">

            <h5 class="mb-3">Pickup Information</h4>

            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <td><strong>Super Manager:</strong></td>
                            <td>
                                <a href="/admin/users/{{ $pickup->supermanager->id }}">(#{{ $pickup->supermanager->id }}) {{ $pickup->supermanager->name }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Driver:</strong></td>
                            @if($pickup->job)
                                <td>{{ $pickup->job->user ? "(#{$pickup->job->user_id}) {$pickup->job->user->name}" : "None" }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td><strong>Job:</strong></td>
                            <td>{{ $pickup->job ? "#{$pickup->job->id}" : "No Job Yet" }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <td><strong>Store:</strong></td>
                            <td>
                                <strong>{{ $pickup->shop->name }}</strong><br>
                                {{ $pickup->shop->address }}<br>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Google Maps:</strong></td>
                            <td>
                                <a class="btn btn-secondary btn-sm" target="_blank" href="https://maps.google.com/maps?q={{ $pickup->shop->latitude }},{{ $pickup->shop->longitude }}">Open in Google Maps</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            </table>

        </div>
    </div>

    {{-- <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    @if($pickup->status == "PENDING")
                        <button class="btn btn-danger btn-sm">Cancel Pickup (TODO)</button>
                    @endif
                </div>
            </div>
        </div>
    </div> --}}

    <div class="card mt-3">
        <div class="card-body">
            <h5 class="mb-3">Pickup Logs</h4>
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered">
                        <tr>
                            <td width="10%"><strong>ID</strong></td>
                            <td width="20%"><strong>User</strong></td>
                            <td width="70%"><strong>Message</strong></td>
                        </tr>
                        @foreach($pickup->logs as $log)
                            <tr>
                                <td>#{{ $log->id }}</td>
                                <td>
                                    @if($log->user)
                                        <a href="/admin/users/{{ $log->user->id }}">(#{{ $log->user->id }}) {{ $log->user->name }}</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    {{ $log->message }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <iframe src="https://maps.google.com/maps?output=embed&q={{ $pickup->shop->latitude }},{{ $pickup->shop->longitude }}" frameborder="0" width="100%" height="400px"></iframe>
                </div>
            </div>
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
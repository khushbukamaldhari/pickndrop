@extends('driver.master')

@section('page')

    <div class="jumbotron">
        <h4>Welcome, {{ Auth::user()->name }}</h4>
        <p class="mb-0">You currently have {{ count(Auth::user()->jobs) }} job on the go</p>
    </div>

    @include('flash::message')

    <h5>My Jobs</h5>
    <hr />

    @foreach($jobs as $job)
        <div class="card mb-3">
            <div class="card-header">
                Current Active Job (${{ 20 * number_format(count($job->pickups), 2) }})
                {{-- Job not started --}}
                {{--<button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#jobmodal-{{ $job->id }}">Go to job</button>--}}
                <a href="/driver/activejob/{{ $job->id }}" class="btn btn-primary btn-sm float-right">Go to job</a>
                <!-- Modal -->
                <div class="modal fade" id="jobmodal-{{ $job->id }}" tabindex="-1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Job #{{ $job->id }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Lorem ipsum dolor sit amet.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <form method="get" action="/driver/launchmaps" id="launch-maps-{{ $job->id }}" class="launch-maps-form">
                                    <input type="hidden" name="job_id" value="{{ $job->id }}">
                                    <input type="hidden" name="latitude" class="latitude-field">
                                    <input type="hidden" name="longitude" class="longitude-field">
                                </form>
                                <button class="btn btn-primary launch-maps-btn" data-form="#launch-maps-{{ $job->id }}">Launch Google Maps</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="list-group list-group-flush">
                @foreach($job->pickups as $pickup)
                    <div class="list-group-item">
                        <strong>{{ $pickup->shop->name }}</strong><br />
                        {{ $pickup->shop->address }}
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

@endsection

@push('javascript')
    <script>

        $('.launch-maps-btn').click(function (e) {
            var that = this;
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    $('.latitude-field').val(position.coords.latitude);
                    $('.longitude-field').val(position.coords.longitude);
                    $($(that).data('form')).submit();
                });
            } else {
                x.innerHTML = "Geolocation is not supported by this browser. Please check permissions.";
            }
            return false;
        });

    </script>
@endpush
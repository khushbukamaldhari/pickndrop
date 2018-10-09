@extends('driver.master')

@section('page')

    <div class="jumbotron">
        <h4>Pickup #{{ $pickup->id }}</h4>
        <p class="mb-0">{{ $pickup->shop->name }}</p>
    </div>

    @include('flash::message')


    @if($pickup->status == "PENDING")
        <button class="btn btn-success btn-lg mb-3" id="startBtn" style="width:100%">Ready To Start?</button>
        <hr />
        <button class="btn btn-danger btn-sm mb-3 mt-3" onclick="emergencyStop()" style="width:100%">Emergency Stop</button>

        <form id="startForm" method="post" action="/driver/start-pickup">
            {{ csrf_field() }}
            <input type="hidden" name="pickup_id" value="{{ $pickup->id }}">
        </form>
    @endif

    @if($pickup->status == "ONROUTE")
        <a href="https://www.google.com/maps/dir/?api=1&dir_action=navigate&destination={{ $pickup->shop->latitude }},{{ $pickup->shop->longitude }}" target="_blank" class="btn btn-secondary btn-lg mb-3" style="width:100%">Navigate in Google Maps</a>
        <button class="btn btn-primary btn-lg mb-3" id="arriveBtn" style="width:100%">Tap On Arrival</button>
        <hr />
        <button class="btn btn-danger btn-sm mb-3 mt-3" onclick="emergencyStop()" style="width:100%">Emergency Stop</button>

        <form id="arriveForm" method="post" action="/driver/mark-arrived">
            {{ csrf_field() }}
            <input type="hidden" name="pickup_id" value="{{ $pickup->id }}">
        </form>
    @endif

    @if($pickup->status == "ARRIVED")
        <div class="card mb-3 text-center">
            <div class="card-body">
                <small>Your pickup code is:</small>
                <h2>{{ $pickup->code }}</h2>
            </div>
        </div>
        <form id="jobFinishedForm" method="post" action="/driver/mark-job-finished" style="margin:0 15px">
            {{ csrf_field() }}
            <div class="form-group row">
                <label>Manager's Name</label>
                <input type="text" class="form-control" name="managers_name">
            </div>
            <div class="form-group row">
                <label>Manager's ID</label>
                <input type="text" class="form-control" name="managers_id">
            </div>
            <input type="hidden" name="pickup_id" value="{{ $pickup->id }}">
        </form>
        <button class="btn btn-success btn-lg mb-3" id="jobFinishedBtn" style="width:100%">Tap When Job Complete</button>
        <hr />
        <button class="btn btn-danger btn-sm mb-3 mt-3" onclick="emergencyStop()" style="width:100%">Emergency Stop</button>
    @endif

@endsection

@push('javascript')
    <script>

        $('#startBtn').click(function () {
            if(confirm("Are you ready to start this pickup?")) {
                $.LoadingOverlay('show');
                $('#startForm').submit();
            }
        });

        $('#arriveBtn').click(function () {
            $.LoadingOverlay('show');
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;
                    var lat_min = "{{ $pickup->shop->latitude - 0.002}}";
                    var lat_max = "{{ $pickup->shop->latitude + 0.002}}";
                    var long_min = "{{ $pickup->shop->latitude - 0.0028}}";
                    var long_max = "{{ $pickup->shop->latitude + 0.0028}}";
                    if(latitude > lat_min && latitude < lat_max && longitude > long_min && longitude < long_max) {
                        // good to go
                        $('#arriveForm').submit();
                    } else {
                        if(confirm("You appear to be quite far from the pickup point. Are you sure you want to mark yourself as arrived?")) {
                            // good to go
                            $('#arriveForm').submit();
                        }
                    }
                });
            } else {
                x.innerHTML = "Geolocation is not supported by this browser. Please check permissions.";
            }
        });

        $('#jobFinishedBtn').click(function () {
            if(confirm("Are you sure you want to mark this job as complete?")) {
                $.LoadingOverlay('show');
                $('#jobFinishedForm').submit();
            }
        });

        function emergencyStop() {
            if(confirm("Are you sure you want to emergency stop?")) {
                
                $.post("/driver/activejob/emergency-stop", 
                    { 'pickup_id': '{{ $pickup->id }}' }
                , function(data) {

                // Successful
                $('.location-field').append('<option value="' + data.id + '" selected>' + data.title + '</option>');
                $('.modal').modal('hide');


                $("input[name='placename']").val('');
                $("input[name='address']").val('');

                }).fail(function (data) {
                alert("Sorry, there was an error. Please try again.");
                });

            }
        }

    </script>
@endpush
@extends('driver.master')

@section('page')

    <div class="jumbotron">
        <h4>Find Jobs</h4>
    </div>

    @include('flash::message')

    <h5>Available Jobs</h5>
    <hr />

    @foreach($jobs as $job)

        <div class="card mb-3">
            <div class="card-header">
                <strong>(${{ number_format(20 * count($job->pickups), 2) }}) {{ $job->date->format('M jS Y') }}</strong>
                <form style="display:inline-block" class="float-right accept-job-form" method="post" action="/driver/acceptjob">
                    <input type="hidden" name="job_id" value="{{ $job->id }}">
                    {{ csrf_field() }}
                    <button class="btn btn-primary float-right btn-sm" type="submit">Accept Job</button>
                </form>
            </div>
            <div class="list-group list-group-flush">
                <div class="list-group-item">
                    Number of Pickups: {{ count($job->pickups) }}
                </div>
                <div class="list-group-item">
                    Estimated Time: {{ count($job->pickups) * 10 }} minutes
                </div>
            </div>
            <div class="card-footer">
                Job #{{ $job->id }}
            </div>
        </div>

    @endforeach

@endsection

@push('javascript')

    <script>

        $('.accept-job-form').submit(function () {
            var confirm = confirm("Are you sure you're ready to accept this job?");
            if(confirm) {
                return true;
            } else {
                return false;
            }
        });

    </script>

@endpush
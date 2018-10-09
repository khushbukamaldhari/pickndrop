@extends('driver.master')

@section('page')

    <div class="jumbotron">
        <h4>Job #{{ $job->id }} Completed</h4>
        <p class="mb-0">Now navigate to the bank</p>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <p class="mb-0">Navigate to the nearest Old National Bank to drop off the cash.</p>
        </div>
    </div>

    <a href="https://www.google.com/maps/dir/?api=1&dir_action=navigate&destination=Old National Bank" target="_blank" class="btn btn-secondary btn-lg mb-3" style="width:100%">Navigate in Google Maps</a>

    <button class="btn btn-primary btn-lg" id="arrivedAtBankBtn" style="width:100%">Arrived At Bank</button>

    <form id="finishBankForm" method="post" action="/driver/finish-bank">
        {{ csrf_field() }}
        <input type="hidden" name="job_id" value="{{ $job->id }}">
    </form>

    @include('flash::message')




@endsection

@push('javascript')
    <script>

        $("#arrivedAtBankBtn").click(function () {
            var check = confirm("Are you sure? This will complete the job.");
            if(check) {
                $("#finishBankForm").submit();
            }
        });

    </script>
@endpush
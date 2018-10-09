@extends('administrator.master')

@section('page')

    <h3 class="float-left">Current Jobs</h3>

    <div class="clearfix"></div>

    <hr />

    @include('flash::message')

    @foreach($jobs as $job)
        <div class="card job-card mb-3">
            <div class="card-body">
                <h5><div class="badge badge-warning">Sent to Drivers - Waiting...</div> - {{ count($job->pickups) }} Pickups ({{ $job->date }})</h5>
                <hr />
                <div class="row">
                    @foreach($job->pickups as $pickup)
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <strong>{{ $pickup->shop->name }}</strong>
                                    <p class="mb-0">${{ $pickup->amount }}</p>
                                    <hr>
                                    <a href="/admin/pickups/{{ $pickup->id }}" class="btn btn-primary btn-sm">View Pickup</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal -->
    <div class="modal fade" id="mergeConfirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Merge these pickups?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        You are now merging the following pickups into one job. Would you like to continue?
                        This job offer will be sent to all drivers immedietely.
                    </p>
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">#003 - Shell Romford Gas Station</h5>
                            </div>
                            <p class="mb-1">Company A - March 4th 2018</p>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">#005 - McDonalds Romford</h5>
                            </div>
                            <p class="mb-1">Company B - March 4th 2018</p>
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Merge & Send</button>
                </div>
            </div>
        </div>
    </div>

@endsection
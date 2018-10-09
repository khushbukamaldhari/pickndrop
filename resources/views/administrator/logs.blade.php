@extends('administrator.master')

@section('page')

    <h3 class="float-left">System Log (Past 7 Days)</h3>

    <div class="clearfix"></div>

    @include('flash::message')

    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Timestamp</th>
                <th>Relation</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>#{{ $log->id }}</td>
                    <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>-</td>
                    <td>{{ $log->message }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


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
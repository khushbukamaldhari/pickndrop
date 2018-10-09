@extends('administrator.master')

@section('page')

    <h3 class="float-left">Administrator Dashboard</h3>

    <div class="clearfix"></div>

    @include('flash::message')

    <hr />

    <h5>Pending Change Orders ({{ count($unsortedChangeOrders) }})</h5>

    <hr />

    <div class="table-responsive">
        <table class="table table-bordered mb-5">
            <thead>
                <th>ID</th>
                <th>Store</th>
                <th>Denominations</th>
                <th>Date Requested</th>
                <th>Date Due</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @foreach($unsortedChangeOrders as $changeOrder)
                    <tr id="changeOrder-{{ $changeOrder->id }}">
                        <td>#{{ $changeOrder->id }}</td>
                        <td>
                            <strong>{{ $changeOrder->shop->name }}</strong>
                            <p>{{ $changeOrder->shop->address }}</p>
                        </td>
                        <td>
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
                        </td>
                        <td>{{ $changeOrder->created_at }}</td>
                        <td>{{ $changeOrder->date }}</td>
                        <td>
                            <button class="btn btn-success btn-sm" onclick="completeChangeOrder({{ $changeOrder->id }})">Mark Complete</button>
                            <button class="btn btn-danger btn-sm" onclick="cancelChangeOrder({{ $changeOrder->id }})">Cancel</button>
                        </td>
                    </tr>
                @endforeach
                @if(!count($unsortedChangeOrders))
                    <td colspan="7" class="text-center">
                        There are no pending change orders.
                    </td>
                @endif
            </tbody>
        </table>
    </div>


    <h5 class="float-left">Pickups that need sorting ({{ count($unsortedPickups) }})</h5>

    <button class="btn btn-sm btn-primary mb-3 float-right" onclick="mergeJobsOpen()">Merge selected into job</button>

    <div id="map" class="mb-2" style="width:100%;height:500px;"></div>

    <table class="table table-bordered" width="100%">
        <thead>
            <tr>
                <td></td>
                <td>ID</td>
                <td>Date Requested</td>
                <td>Pickup Date</td>
                <td>Location</td>
                <td>Amount</td>
                <td>Requested By</td>
            </tr>
        </thead>
        <tbody>
            @foreach($unsortedPickups as $pickup)
                <tr>
                    <td><input type="checkbox" data-pickup="{{ $pickup->id }}"></td>
                    <td>#{{ $pickup->id }}</td>
                    <td>{{ $pickup->created_at }}</td>
                    <td>{{ $pickup->pickup_date }}</td>
                    <td>{{ $pickup->shop->name }}</td>
                    <td>${{ $pickup->amount }}</td>
                    <td>{{ $pickup->supermanager->name }}</td>
                </tr>
            @endforeach
            @if(!count($unsortedPickups))
                <td colspan="7" class="text-center">
                    There are no pending pickups.
                </td>
            @endif
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
                    <div class="list-group" id="pickupsModalContent">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="mergeAndSubmit()">Merge & Send</button>
                </div>
            </div>
        </div>
    </div>

    <form id="mergeForm" method="post" action="/admin/merge-pickups">
        <input type="hidden" name="pickups" id="mergeFormPickups">
        {{ csrf_field() }}
    </form>

@endsection

@push('javascript')

    <script>

        function initMap() {
            var uluru = {lat: 41.079273, lng: -85.13935129}; // Fort Wayne
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13, //13
                center: uluru
            });

            @foreach($unsortedPickups as $pickup)

                var marker{{ $pickup->id }} = new google.maps.Marker({
                    position: {lat: {{ $pickup->shop->latitude }}, lng: {{ $pickup->shop->longitude }}},
                    map: map,
                    title: "location",
                    label: "{{ $pickup->id }}",
                });

                marker{{ $pickup->id }}.addListener('click', markerClick({{ $pickup->id }}));

            @endforeach

        }

        var selectedPickups = [];

        $('[data-pickup]').change(function () {
            if(this.checked) {
                selectedPickups.push($(this).data('pickup'));
                console.log(selectedPickups);
            } else {
                selectedPickups.pop($(this).data('pickup'));
                console.log(selectedPickups);
            }
        });

        function mergeJobsOpen() {
            if(selectedPickups.toString() === "") {
                alert("Error: you have not selected any jobs yet.");
                return false;
            }

            $.ajax({
                url: '/admin/ajax-get-pickups',
                data: {
                    'pickups': selectedPickups.toString()
                },
                success: function (data) {
                    $('#pickupsModalContent').html(data);
                }
            });
            $('#mergeConfirmModal').modal();
        }

        function mergeAndSubmit() {

            $('#mergeFormPickups').val(selectedPickups.toString());
            $('#mergeForm').submit();

        }

        function markerClick(id) {
            // alert(id);
            // $("[data-pickup=" + id + "]").prop('checked', true);
            // selectedPickups.pop(id);
            // console.log(selectedPickups);
        }

        function completeChangeOrder(id) {

            $.get("/admin/change-order-complete", {
                id: id
            }, function(data) {

                alert("Change order #" + id + " has been marked as complete.");
                $("#changeOrder-" + id).hide();

            });

        }

        function cancelChangeOrder(id) {

            var reason = prompt("Reason:");

            if(reason != null && reason != "") {

                $.get("/admin/change-order-cancel", {
                    id: id,
                    reason: reason
                }, function(data) {

                    alert("Change order #" + id + " has been CANCELLED.");
                    $("#changeOrder-" + id).hide();

                });

            }

        }

    </script>

@endpush
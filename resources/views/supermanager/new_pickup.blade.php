@extends('supermanager.master')

@section('page')

    <h3 class="float-left">Request New Pickups / Change Orders</h3>

    <div class="clearfix"></div>

    <hr />

    <div class="row">
        <div class="col">

            <form method="post">

                <div class="pickups">

                </div>

                <div class="card">
                    <div class="card-body">
                        <a href="javascript:;" class="btn btn-success float-left mr-3" onclick="addPickup()">Add Pickup</a>
                        <a href="javascript:;" class="btn btn-success float-left" onclick="addChangeOrder()">Add Change Order</a>
                        <button type="submit" class="btn btn-primary float-right">Next Step</button>
                    </div>
                </div>

                <div class="clearfix"></div>

                {{ csrf_field() }}

            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="newLocationModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Locaation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="addLocationForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col">
                                <label>Location Name</label>
                                <input type="text" class="form-control" name="placename" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label>Full Address</label>
                                <input type="text" name="address" id="addressField" class="form-control">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="lng">
                    <input type="hidden" name="lat">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save New Location</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('javascript')

    <script>

        $("#addressField").geocomplete({ details: "form" });

        $('#addLocationForm').submit(function () {
            if($("[name='lat']").val() === "") {
                alert("You must select an address from the list.");
                return false;
            }
            return true;
        });

        var pickupCount = 0;
        var changeOrderCount = 0;

        function addPickup() {
            pickupCount++;
            $.get('/supermanager/pickuphtml?i=' + pickupCount, function(data){
                $('.pickups').append(data);
            });
            return false;
        }

        function changeType(i) {

            var choice = $('#type-' + i).val();

            if(choice == "oneoff") {
                $('#date-' + i).show();
                $('#schedule-' + i).hide();
            } else {
                $('#date-' + i).hide();
                $('#schedule-' + i).show();
            }

        }

        function addChangeOrder() {
            changeOrderCount++;
            $.get('/supermanager/changeorderhtml?i=' + changeOrderCount, function(data){
                $('.pickups').append(data);
            });
            return false;
        }

        $('#addLocationForm').submit(function () {
            $.post("/supermanager/locations/ajax", $("#addLocationForm").serialize(), function(data) {

                // Successful
                $('.location-field').append('<option value="' + data.id + '" selected>' + data.title + '</option>');
                $('.modal').modal('hide');

                $("input[name='placename']").val('');
                $("input[name='address']").val('');

            }).fail(function (data) {
                alert("Sorry, there was an error. Please try again.");
            });
            return false;
        });

    </script>

@endpush
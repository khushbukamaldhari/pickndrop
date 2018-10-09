@extends('supermanager.master')

@section('page')

    <?php // print_r( $location_info[0]->name ); ?>
    <h3 class="float-left">My Locations</h3>

    <div class="clearfix"></div>

    @include('flash::message')

    <div class="card mb-4 mt-4">
        <div class="card-body pb-1">
            <h5>Edit Location</h5>
            <hr />
            <form method="post" action="{{  url( '/supermanager/edit_location/'. $location_info[0]->id )  }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Location Name</label>
                        <input type="text" value="{{ $location_info[0]->name }}" class="form-control" name="placename" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Full Address</label>
                        <input type="text" value="{{ $location_info[0]->address }}" class="form-control" name="address" required>
                    </div>
                </div>
                <input type="hidden" name="lng">
                <input type="hidden" name="lat">
                <div class="form-group row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">Edit Location</button>
                    </div>
                </div>
                
            </form>
            
        </div>
    </div>

@endsection


@push('javascript')
    <script>

//        $('form').submit(function () {
//            if($("[name='lat']").val() === "") {
//                alert("You must select an address from the list.");
//                return false;
//            }
//            return true;
//        });
    

        function editStore(id) {

           
            $.get("/supermanager/delete-location-ajax", { id: id}, function(data) {
                location.reload();
            });
            
        }

        $("#addressField").geocomplete({ details: "form" });

    </script>
@endpush
@extends('supermanager.master')

@section('page')

    <h3 class="float-left">My Locations</h3>

    <div class="clearfix"></div>

    @include('flash::message')

    <div class="card mb-4 mt-4">
        <div class="card-body pb-1">
            <h5>Add New Location</h5>
            <hr />
            <form method="post">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Location Name</label>
                        <input type="text" class="form-control" name="placename" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Full Address</label>
                        <input type="text" class="form-control" name="address" id="addressField" required>
                    </div>
                </div>
                <input type="hidden" name="lng">
                <input type="hidden" name="lat">
                <div class="form-group row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">Add New Location</button>
                    </div>
                </div>
                {{ csrf_field() }}
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table class="table">
                @foreach($shops as $shop)
                    <tr>
                        <td><strong>#{{ $shop->id }}</strong></td>
                        <td>{{ $shop->name }}</td>
                        <td>{{ $shop->address }}</td>
                        <td>
                            <button class="btn btn-danger btn-sm float-right ml-2" onclick="deleteStore('{{ $shop->id }}')">Delete</button>
                            <button class="btn btn-secondary btn-sm float-right" ><a href="{{ url( '/supermanager/edit_location_form/'. $shop->id ) }}">Edit</a></button>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection


@push('javascript')
    <script>

        $('form').submit(function () {
            if($("[name='lat']").val() === "") {
                alert("You must select an address from the list.");
                return false;
            }
            return true;
        });
    
        function deleteStore(id) {

            var check = confirm("Are you sure you wish to delete this location? This action cannot be undone.");

            if(check) {
                $.get("/supermanager/delete-location-ajax", { id: id}, function(data) {
                    location.reload();
                });
            }
            
        }
        
        function editStore(id) {

            $.get("/supermanager/edit_location", { id: id}, function(data) {
                
            });
//            $.get("/supermanager/delete-location-ajax", { id: id}, function(data) {
//                location.reload();
//            });
            
        }

        $("#addressField").geocomplete({ details: "form" });

    </script>
@endpush
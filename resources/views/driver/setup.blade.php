@extends('driver.master')

@section('page')

    <div class="jumbotron">
        <h4>Setup</h4>
        <p class="mb-0">We just need some information before we can get you setup.</p>
    </div>

    @include('flash::message')

    <h5>Account Setup</h5>

    <hr />

    <form method="post" action="">

        <div class="form-group">
            <label>Legal First Name *</label>
            <input type="text" class="form-control" id="legalFirstName" name="legal_first_name" required>
        </div>

        <div class="form-group">
            <label>Legal Last Name *</label>
            <input type="text" class="form-control" id="legalLastName" name="legal_last_name" required>
        </div>

        <div class="form-group">
            <label>Address Line 1 *</label>
            <input type="text" class="form-control" id="address1" name="address_1" required>
        </div>

        <div class="form-group">
            <label>Address Line 2</label>
            <input type="text" class="form-control" id="address2" name="address_2">
        </div>

        <div class="form-group">
            <label>City *</label>
            <input type="text" class="form-control" id="city" name="city" required>
        </div>

        <div class="form-group">
            <label>State *</label>
            <input type="text" class="form-control" id="state" name="state" required>
        </div>

        <div class="form-group">
            <label>Zip Code *</label>
            <input type="text" class="form-control" id="postalCode" name="postal_code" required>
        </div>

        <div class="form-group">
            <label>Date of Birth *</label>
            <input type="date" class="form-control" id="dob" name="date_of_birth" required>
        </div>

        <div class="form-group">
            <label>Last 4 Digits of SSN *</label>
            <input type="text" class="form-control" id="ssn" name="ssn" maxlength="4" required>
        </div>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="tos" name="tos" required>
            <label class="form-check-label" for="tos">I agree to the <a href="javascript:;" onclick="$('#tosModal').modal()">terms and conditions.</a></label>
        </div>

        <hr />

        <button type="submit" class="btn btn-primary mb-5">Submit My Information</button>

        {{ csrf_field() }}

    </form>

    <!-- Modal -->
    <div class="modal fade" id="tosModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Terms and Conditions</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('javascript')



@endpush
@extends('layouts.app')

@section('content')

<div class="container">

    <h4 class="mb-4 mt-5">Register with Brigloo</h4>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Full Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="accesslevel" class="col-md-4 control-label">What type of user are you?</label>

                            <div class="col-md-6">
                                <select class="form-control" name="type" id="accesslevel" onchange="changeAccessLevel()">
                                    <option value="">-- Please Select --</option>
                                    <option value="driver">Driver</option>
                                    <option value="supermanager">Business Entity</option>
                                </select>
                            </div>
                        </div>

                        <div class="business d-none">
                            <h5 class="ml-3 mt-4 mb-4">Business Details</h5>
                            <div class="form-group">
                                <label for="business_name" class="col-md-4 control-label">Business Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="business_name" id="business_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ein" class="col-md-4 control-label">EIN Number</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="ein" id="ein">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="title" class="col-md-4 control-label">Job Title</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="title" id="title">
                                </div>
                            </div>
                            <h5 class="ml-3 mt-4 mb-4">Business Address</h5>
                            <div class="form-group">
                                <label for="address_1" class="col-md-4 control-label">Address Line 1</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="address_1" id="address_1">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address_2" class="col-md-4 control-label">Address Line 2</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="address_2" id="address_2">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="city" class="col-md-4 control-label">City</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="city" id="city">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="state" class="col-md-4 control-label">State</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="state" id="state">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="zip_code" class="col-md-4 control-label">Zip Code</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="zip_code" id="zip_code">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="tos" name="tos" required>
                            <label class="form-check-label" for="tos">I agree to the <a href="javascript:;" onclick="$('#tosModal').modal()">terms and conditions.</a></label>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')

    <script>

        function changeAccessLevel() {
            if($('#accesslevel').val() === "supermanager") {
                $('.business').removeClass('d-none')
            } else {
                $('.business').addClass('d-none')
            }
        }

        $('form').submit(function () {

            $('.invalid').removeClass('invalid');

            var error = false;

            if($('#accesslevel').val() === "supermanager") {

                // Business Validation

                if($('#business_name').val() === "") {
                    $('#business_name').addClass('invalid');
                    error = true;
                }
                if($('#ein').val() === "") {
                    $('#ein').addClass('invalid');
                    error = true;
                }
                if($('#title').val() === "") {
                    $('#title').addClass('invalid');
                    error = true;
                }
                if($('#address_1').val() === "") {
                    $('#address_1').addClass('invalid');
                    error = true;
                }
                if($('#city').val() === "") {
                    $('#city').addClass('invalid');
                    error = true;
                }
                if($('#state').val() === "") {
                    $('#state').addClass('invalid');
                    error = true;
                }
                if($('#zip_code').val() === "") {
                    $('#zip_code').addClass('invalid');
                    error = true;
                }

            }

            if(error === true) {
                return false;
            }

        });

    </script>

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

@endpush
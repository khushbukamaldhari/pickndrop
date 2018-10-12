@extends('supermanager.master')

@section('page')

    <div class="container">

    <h4 class="mb-4 mt-5">Change Password</h4>
    
    @include('flash::message')
    
    
    
    <div class="row">
        <div class="col">
            <div class="card">
                @if ( $link_verify == "link_verified" )
                    <div class="card-body">
                        Link has been sent to your mail id for change password verification.
                    </div>
                @else
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ url( '/user/change_password' ) }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Old Password</label>

                            <div class="col-md-6">
                                <input id="old_password" type="password" class="form-control" name="old_password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
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
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Change Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

    

@endsection


@push('javascript')
    <script>

        $('form').submit( function () {

            $('.invalid').removeClass('invalid');
            var error = false;
            if( error === true ) {
                return false;
            }

        });
        
    </script>
@endpush
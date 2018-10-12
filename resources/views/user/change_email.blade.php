@extends('supermanager.master')

@section('page')

    <div class="container">

    <h4 class="mb-4 mt-5">Change Email</h4>
    
    @include('flash::message')
    
    
    
    <div class="row">
        <div class="col">
            <div class="card">
                
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ url( '/user/change_email' ) }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">New Email</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="email" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Change email
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
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
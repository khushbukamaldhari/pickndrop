@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="clearfix"></div>

                <div class="card mb-4 mt-4">
                    <div class="card-body pb-1">
                        @include('flash::message')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('script')
    <script>
            setTimeout(function(){  
                $.get("/logout", function(data) {

                });
            }, 3000);
    </script>
@endpush
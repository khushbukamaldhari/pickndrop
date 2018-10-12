@extends('supermanager.master')

@section('page')

    <?php // print_r( $location_info[0]->name ); ?>
    <h3 class="float-left">Edit Profile</h3>
    <a href="/user/change_password_html">Change Password</a>

    <div class="clearfix"></div>

    @include('flash::message')

    

@endsection


@push('javascript')
    <script>


    </script>
@endpush
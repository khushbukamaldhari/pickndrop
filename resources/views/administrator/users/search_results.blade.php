@extends('administrator.master')

@section('page')

    <h3 class="float-left mb-4">({{ count($users) }}) Search Results</h3>

    <div class="clearfix"></div>

    @include('flash::message')

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td><strong>ID</strong></td>
                        <td><strong>Name / Contact</strong></td>
                        <td><strong>Type</strong></td>
                        <td><strong>Badge No</strong></td>
                        <td><strong>Status</strong></td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>#{{ $user->id }}</td>
                            <td><strong>{{ $user->name }}</strong><br>{{ $user->email }}<br>{{ $user->mobile }}</td>
                            <td>
                                @if($user->access_level == "driver")
                                    <span class="badge badge-success">Driver</span>
                                @elseif($user->access_level == "supermanager")
                                    <span class="badge badge-primary">Business</span>
                                @endif
                            </td>
                            <td>{{ $user->badge ? $user->badge : '-' }}</td>
                            <td>
                                @if($user->activated)
                                    <span class="badge badge-success">Active</span>
                                @elseif($user->rejected)
                                    <span class="badge badge-danger">Rejected</span>
                                @else
                                    <span class="badge badge-warning">Pending</span>
                                @endif
                            </td>
                            <td><a href="/admin/users/{{ $user->id }}" class="btn btn-primary btn-sm">View User</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

@endsection
    

@push('javascript')



@endpush
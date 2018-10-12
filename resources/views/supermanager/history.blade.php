@extends('supermanager.master')

@section('page')

<h3>My Pickup History</h3> <div style="float: right"><a href="/supermanager/download">Download</a></div>
    
    <table class="table table-striped" width="100%">
        <thead>
            <tr>
                <td>ID</td>
                <td>Date Requested</td>
                <td>Pickup Date</td>
                <td>Location</td>
                <td>Amount</td>
                <td>Status</td>
                <td>Requested By</td>
                <td>Manager</td>
            </tr>
        </thead>
        <tbody>
            @foreach($pastPickups as $pickup)
                <tr>
                    <td>#{{ $pickup->id }}</td>
                    <td>{{ $pickup->created_at->format('m/d/Y') }}</td>
                    <td>{{ $pickup->pickup_date->format('m/d/Y') }}</td>
                    <td>{{ $pickup->shop->name }}</td>
                    <td>${{ number_format($pickup->amount) }}</td>
                    @if($pickup->status == "COMPLETED")
                        <td><div class="badge badge-success">Completed</div></td>
                    @elseif($pickup->status == "CANCELLED")
                        <td><div class="badge badge-danger">Cancelled</div></td>
                    @else
                        <td>{{ $pickup->status }}</td>
                    @endif
                    <td>{{ $pickup->supermanager->name }}</td>
                    <td>
                        @if($pickup->manager)
                            {{ $pickup->manager->name }}
                        @endif
                    </td>
                    <td>
                        <a href="/supermanager/pickup/{{ $pickup->id }}" class="btn btn-primary btn-sm">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection

@push('javascript')

    <script>



    </script>

@endpush
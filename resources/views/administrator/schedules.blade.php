@extends('administrator.master')

@section('page')

    <h3 class="float-left">Scheduling System</h3>

    <div class="clearfix"></div>

    @include('flash::message')

    <table class="table mt-4">
        <thead>
            <tr>
                <th width="10%">ID</th>
                <th width="40%">Store</th>
                <th width="25%">Days</th>
                <th width="25%">Schedule</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $schedule)
                <tr>
                    <td>{{ $schedule->id }}</td>
                    <td>
                        @if($schedule->shop)
                            {{ $schedule->shop->name }}<br><small>{{ $schedule->shop->address }}</small>
                        @else
                            <span class="text-danger">No store!</span>
                        @endif
                    </td>
                    <td>
                        @if($schedule->monday)Monday<br>@endif
                        @if($schedule->tuesday)Tuesday<br>@endif
                        @if($schedule->wednesday)Wednesday<br>@endif
                        @if($schedule->thursday)Thursday<br>@endif
                        @if($schedule->friday)Friday<br>@endif
                        @if($schedule->saturday)Saturday<br>@endif
                        @if($schedule->sunday)Sunday<br>@endif
                    </td>
                    <td>
                        @if($schedule->weekly)Weekly @endif
                        @if($schedule->biweekly)Bi Weekly @endif
                        @if($schedule->fourweekly)Four Weekly @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
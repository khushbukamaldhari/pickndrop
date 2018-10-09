
@foreach($pickups as $pickup)
    <div class="list-group-item flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">#{{ $pickup->id }} - {{ $pickup->shop->name }}</h5>
        </div>
        <p class="mb-1">{{ $pickup->supermanager->name }} - {{ $pickup->pickup_date->format('M jS Y') }}</p>
    </div>
@endforeach

@if(!count($pickups))
    <div class="alert alert-danger">
        You have not yet selected any pickups.
    </div>
@endif
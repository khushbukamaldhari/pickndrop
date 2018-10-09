@extends('supermanager.master')

@section('page')

    <h3 class="float-left">Confirm Your Order</h3>

    <div class="clearfix"></div>

    <hr />

    <form method="post" action="/supermanager/newpickup/pay" method="post">
        <input type="hidden" name="quote" value="{{ $quote->id }}">
        <div class="row">
            <div class="col-9">

                @if(count($quote->schedules))
                    <div class="alert alert-info">
                        You'll be charged on the Sunday before a scheduled pickup.
                        If you have a scheduled pickup before the next Sunday, you'll be charged immedietely for it once you confirm.
                    </div>
                @endif

                <div class="pickups">

                    @foreach($quote->pickups as $pickup)
                        <div class="card mb-3">
                            <div class="card-body pb-3">
                                <h5>{{ $pickup->shop->name }}</h5>
                                <span>
                                    <strong>Amount: </strong>
                                    @if($pickup->amount)
                                        ${{ number_format($pickup->amount, 2) }}
                                    @else
                                        Unspecified
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endforeach

                    @foreach($quote->schedules as $schedule)
                        <div class="card mb-3">
                            <div class="card-body pb-3">
                                <h5>{{ $schedule->shop->name }}</h5>
                                {{ $schedule->collectionDaysText() }}
                                <hr />
                                <span>Cost for each pickup: ${{ number_format($schedule->gross, 2) }}</span>
                                <hr />
                                <label for="">First Pickup Date:</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select name="schedule[{{ $schedule->id }}][date]" id="" class="form-control">
                                            @foreach($schedule->nextDatesForDropdown() as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @foreach($quote->changeOrders as $order)
                        <div class="card mb-3">
                            <div class="card-body pb-3">
                                <h5>{{ $order->shop->name }}</h5>
                                <span>Change Order Request</span>
                                <table width="100%" class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <th>$50</th>
                                            <th>$20</th>
                                            <th>$10</th>
                                            <th>$5</th>
                                            <th>$1</th>
                                            <th>1¢</th>
                                            <th>5¢</th>
                                            <th>10¢</th>
                                            <th>25¢</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $order->usd50 }}</td>
                                            <td>{{ $order->usd20 }}</td>
                                            <td>{{ $order->usd10 }}</td>
                                            <td>{{ $order->usd5 }}</td>
                                            <td>{{ $order->usd1 }}</td>
                                            <td>{{ $order->cent1 }}</td>
                                            <td>{{ $order->cent5 }}</td>
                                            <td>{{ $order->cent10 }}</td>
                                            <td>{{ $order->cent25 }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr />
                                <span>Service Charge: $30.00</span><br>
                                <span>Total Change Amount: ${{ number_format($order->totalAmount()) }}</span><br>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Order Details</h5>
                        <hr />
                        <table width="100%">
                            @if(count($pickups))
                                <tr>
                                    <td><strong>Collecting: </strong></td>
                                    <td>{{ $pickups->sum('amount') ? '$' . number_format($pickups->sum('amount'), 2) : 'Unknown' }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td><strong>Change Order Amount: </strong></td>
                                    <td>${{ number_format($quote->totalChangeOrder(), 2) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td><strong>To Pay Now: </strong></td>
                                <td>${{ number_format((30 * count($pickups)) + (30 * count($quote->changeOrders)), 2) }}</td>
                            </tr>
                        </table>
                        <hr />
                        {{ csrf_field() }}

                        @if(auth()->user()->stripe_id)
                            {{-- Already has a card stored --}}
                            <button type="submit" class="btn btn-primary mb-3">Confirm & Use Saved Card</button><br />
                            <a href="javascript:;" onclick="alert('Stripe API: error 435')">Change My Saved Card</a>
                        @else
                            <script
                                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                    data-key="{{ env('STRIPE_PUBLISHABLE_KEY') }}"
                                    data-amount="{{ ((count($pickups) * 30) + (count($quote->changeOrders) * 30)) * 100 }}"
                                    data-name="Brigloo"
                                    {{-- Has pickups & card is NOT saved --}}
                                    @if((count($quote->pickups) || count($quote->changeOrders)) && !Auth::user()->stripe_id)
                                    data-label="Enter Card Details & Pay"
                                    data-panel-label="Pay"
                                    @endif
                                    {{-- Has pickups & card IS IS saved --}}
                                    @if((count($quote->pickups) || count($quote->changeOrders)) && Auth::user()->stripe_id)
                                    data-label="Update Card & Pay"
                                    data-panel-label="Pay"
                                    @endif
                                    {{-- Has pickups & card is NOT saved --}}
                                    @if(count($quote->pickups) && !Auth::user()->stripe_id)
                                    data-label="Set Card Details & Pay"
                                    data-panel-label="Pay Now"
                                    @endif
                                    {{-- No pickups, just schedule & card is NOT saved --}}
                                    @if(count($quote->schedules) && !count($pickups) && !Auth::user()->stripe_id)
                                    data-label="Set Credit Card & Confirm"
                                    data-panel-label="Confirm Schedules"
                                    @endif
                                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                    data-locale="auto"
                                    data-email="{{ Auth::user()->email }}"
                                    data-currency="usd"
                                    data-allow-remember-me="false">
                            </script>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('javascript')

    <script>



    </script>

@endpush
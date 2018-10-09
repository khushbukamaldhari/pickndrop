@extends('driver.master')

@section('page')

    <div class="jumbotron">
        <h4>My Account</h4>
    </div>

    @include('flash::message')

    <h5>My Account: Banking Information</h5>

    <hr />

    <div class="row mt-4">
        <div class="col-md-3">

            <div class="list-group">
                <a href="/driver/myaccount" class="list-group-item list-group-item-action">
                    My Information
                </a>
                <a href="/driver/bankaccount" class="list-group-item list-group-item-action active">
                    Bank Account
                </a>
            </div>

        </div>
        <div class="col-md-9">

            <h4 class="mb-4">Bank Account</h4>

            @if(count(Auth::user()->banks))

                <div class="alert alert-success">
                    <strong>Your bank is setup - {{ Auth::user()->banks->first()->name }} XXXXXXXX{{ Auth::user()->banks->first()->account_last_4 }}</strong><br />
                    <p class="mb-0">This bank account is setup and ready to go</p>
                </div>

            @else

                <div class="alert alert-warning">
                    You do not have a bank account setup yet.
                </div>

            @endif

            <form id="stripeForm">

                <h5 class="mt-5">Change Bank Account:</h5>

                <div class="form-group">
                    <label>Account Holder Name</label>
                    <input type="text" class="form-control" id="accountHolderName" value="">
                </div>

                <div class="form-group">
                    <label>Routing Number</label>
                    <input type="text" class="form-control" id="routingNumber" value="">
                </div>

                <div class="form-group">
                    <label>Account Number</label>
                    <input type="text" class="form-control" id="accountNumber" value="">
                </div>

                <hr />

                <button type="submit" class="btn btn-primary mb-5">Save New Bank</button>

                {{ csrf_field() }}

            </form>

        </div>
    </div>

    <form method="post" id="hiddenForm">
        <input type="hidden" name="stripe_token" id="stripeToken">
        {{ csrf_field() }}
    </form>

    <script src="https://js.stripe.com/v3/"></script>

    <script>

        var stripe = Stripe('{{ env('STRIPE_PUBLISHABLE_KEY') }}');

        document.getElementById('stripeForm').addEventListener('submit', function(e) {
            e.preventDefault();
            var bankAccountParams = {
                country: "US",
                currency: "USD",
                account_number: $('#accountNumber').val(),
                account_holder_name: $('#accountHolderName').val(),
                account_holder_type: "individual",
                routing_number: $('#routingNumber').val()
            };
            stripe.createToken('bank_account', bankAccountParams).then(function (result) {
                if (result.token) {
                    $('#stripeToken').val(result.token.id);
                    $('#hiddenForm').submit();
                } else {
                    alert('Sorry, there was a problem updating your bank account details.');
                }
            });
        });


    </script>

@endsection
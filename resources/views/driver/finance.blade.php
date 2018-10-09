@extends('driver.master')

@section('page')

    <div class="jumbotron">
        <h4>My Balance</h4>
        <p>Pending: ${{ number_format($pending / 100, 2) }}</p>
        <p>Available: ${{ number_format($available / 100, 2) }}</p>
        <hr />
        <a href="/driver/bankaccount" class="btn btn-secondary">Update My Bank Account</a><br />
        <small>Your balance is automatically deposited into your bank on a daily rolling basis.</small>
    </div>

    @include('flash::message')


@endsection
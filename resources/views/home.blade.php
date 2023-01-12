@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Make a payment</div>

                <div class="card-body">
                    <form
                        action="{{ route('pay') }}"
                        method="POST"
                        id="paymentForm"
                    >
                        @csrf
                        <div class="row">
                            <div class="col-auto">
                                <label for="value">How much you want to pay?</label>
                                <input
                                    type="number"
                                    min="5"
                                    step="0.01"
                                    class="form-control"
                                    name="value"
                                    value="{{ mt_rand(500, 100000) / 100 }}"
                                    required
                                >
                                <small class="form-text text-muted">
                                    Use values with up to two decimal positions, using a dot.
                                </small>
                            </div>
                            <div class="col-auto">
                                <label for="currency">Currency</label>
                                <select
                                    class="form-select"
                                    name="currency"
                                    required
                                >
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->iso }}">
                                            {{ strtoupper($currency->iso) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label>
                                    Select the desired payment platform
                                </label>
                                <div
                                    class="form-group"
                                    id="toggler"
                                >
                                    <div
                                        class="btn-group btn-group-toggle"
                                        role="group"
                                    >
                                        @foreach ($paymentPlatforms as $paymentPlatform)
                                            <label
                                                class="btn btn-outline-secondary rounded m-2 p-1"
                                                data-bs-target="#{{ $paymentPlatform->name }}Collapse"
                                                data-bs-toggle="collapse"
                                            >
                                                <input
                                                    type="radio"
                                                    name="payment_platform"
                                                    value="{{ $paymentPlatform->id }}"
                                                    required
                                                >
                                                <img
                                                    class="img-thumbnail"
                                                    src="{{ asset($paymentPlatform->image) }}"
                                                    alt="Payment platform logo">
                                            </label>
                                        @endforeach
                                    </div>
                                    @foreach ($paymentPlatforms as $paymentPlatform)
                                        <div
                                            id="{{ $paymentPlatform->name }}Collapse"
                                            class="collapse"
                                            data-bs-parent="#toggler"
                                        >
                                            @includeIf("components." . strtolower($paymentPlatform->name) . "-collapse")
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-auto">
                                    @if (!optional(auth()->user())->hasActiveSubscription())
                                        <p class="border-bottom border-primary pb-1">
                                            Would you like a discount for every purchase? <a href="#">Subscribe</a>
                                        </p>
                                    @else
                                        <p class="border-bottom border-primary pb-1 mb-0">
                                            You get <span class="fw-bold">10% discount</span> for every purchase as part of your subscription.
                                        </p>
                                        <p style="font-size: 14px" class="text-muted">
                                            (It will be applied in the checkout)
                                        </p>
                                    @endif
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <button
                                class="btn btn-primary btn-lg"
                                type="submit"
                                id="payButton"
                            >
                                Pay
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

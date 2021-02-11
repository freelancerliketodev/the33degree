@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('custom.deposit') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                   
                    <input id="card-holder-name" type="text">

                    <!-- Stripe Elements Placeholder -->
                    <div id="card-element"></div>

                    <button id="card-button">
                        Process Payment
                    </button>
                    <script src="https://js.stripe.com/v3/"></script>

                    <script>
                        const stripe = Stripe('{{$stripKey}}');

                        const elements = stripe.elements();
                        const cardElement = elements.create('card');

                        cardElement.mount('#card-element');
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

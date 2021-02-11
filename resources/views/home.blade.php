@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                   
                    <?php /* <input id="card-holder-name" type="text">

                    <!-- Stripe Elements Placeholder -->
                    <div id="card-element"></div>

                    <button id="card-button">
                        Process Payment
                    </button>

                   <script src="https://js.stripe.com/v3/"></script>

                    <script>
                        const stripe = Stripe('pk_test_51I8tLUBc9f1u8GdC2ifRz96SdXtb5PicQB335QSGlwDR0LXqXV1xSqi2aldGF14VjxLkPqatMucDvzSDgyhZVvQo002n80SSBe');

                        const elements = stripe.elements();
                        const cardElement = elements.create('card');

                        cardElement.mount('#card-element');
                    </script> */?>
                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

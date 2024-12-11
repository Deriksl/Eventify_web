@extends('layouts.app')

@section('title', 'Comprar boletos')

@section('content')
    <div class="container">
        <h1>Comprar boletos para {{ $event->name }}</h1>
        <form action="{{ route('events.purchase.process', $event->id) }}" method="POST" id="payment-form">
            @csrf
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="card-element">Detalles de la tarjeta</label>
                <div id="card-element" class="form-control"></div>
                <div id="card-errors" role="alert"></div>
            </div>
            <button type="submit" class="btn btn-primary">Pagar ${{ number_format($event->price, 2) }}</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('{{ config('services.stripe.key') }}');
        var elements = stripe.elements();

        var card = elements.create('card', {
            hidePostalCode: true
        });
        card.mount('#card-element');

        card.addEventListener('change', function (event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            stripe.createToken(card).then(function (result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', result.token.id);
                    form.appendChild(hiddenInput);

                    form.submit();
                }
            });
        });
    </script>
@endpush

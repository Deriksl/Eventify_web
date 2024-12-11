@extends('layouts.app')

@section('content')

<script src="https://js.stripe.com/v3/"></script>

<form id="payment-form">
    <div id="card-element">
        <!-- A Stripe Element will be inserted here. -->
    </div>

    <!-- Used to display form errors. -->
    <div id="card-errors" role="alert"></div>

    <button type="submit">Pagar</button>
</form>

<script>
    var stripe = Stripe('pk_test_51QTcyGJBuz8s3lAbq0JwvCr6QERmOoNd2PISRfnJU22zSkZPKP1maECaCqq1JcptS2TChQEB9XYUr3oN1qNSSyW400acbWJz48'); // Usar tu clave pública de Stripe
    var elements = stripe.elements();
    var card = elements.create('card');
    card.mount('#card-element');

    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe.confirmCardPayment('{{ $clientSecret }}', {
            payment_method: {
                card: card,
                billing_details: {
                    name: 'Nombre del usuario', // Aquí puedes capturar el nombre del usuario si es necesario
                },
            }
        }).then(function(result) {
            if (result.error) {
                // Informar al usuario de un error
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // El pago fue exitoso
                alert('Pago exitoso!');

                // Opcional: redirigir a una página de confirmación o a una vista de detalles del ticket
                window.location.href = '/tickets/' + '{{ $ticket->id }}'; // Redirigir a una página de detalles del ticket
            }
        });

    });
</script>
@endsection

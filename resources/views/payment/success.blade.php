@extends('layouts.app')

@section('title', 'Pago Exitoso')

@section('content')
    <div class="container centered-content">
        <div class="text-center">
            <h1>¡Gracias por tu compra!</h1>
            <p>Tu pago se realizó con éxito. ¡Nos vemos en el evento!</p>
            <div class="btn-container">
                <a href="{{ route('home') }}" class="btn btn-primary">Volver al inicio</a>
            </div>
        </div>
    </div>
@endsection

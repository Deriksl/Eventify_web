@extends('layouts.app')

@section('title', 'Pago Cancelado')

@section('content')
    <div class="container centered-content">
        <div class="text-center">
            <h1>Pago Cancelado</h1>
            <p>Tu pago fue cancelado. Si tienes dudas, contáctanos.</p>
            <div class="btn-container">
                <a href="{{ route('home') }}" class="btn btn-secondary">Volver al inicio</a>
            </div>
        </div>
    </div>
@endsection

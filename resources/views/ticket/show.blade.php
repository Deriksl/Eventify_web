@extends('layouts.app')

@section('content')
<h1>Detalles del Ticket</h1>
<p>Evento: {{ $ticket->event->name }}</p>
<p>Precio: ${{ $ticket->price }}</p>
<p>Código del Ticket: {{ $ticket->ticket_code }}</p>
<p>Estado: {{ $ticket->status }}</p>
<p>Fecha de compra: {{ $ticket->purchase_date }}</p>
@endsection

@extends('layouts.app')

@section('title', 'Events')

@section('content')
    <div class="events-grid">
        @foreach($events as $event)
            <div class="event">
                <img src="{{ $event->image_url }}" alt="Event Image">
                <h3>{{ $event->name }}</h3>
                <p>Organizador: {{ $event->organizer->name }}<br>Fecha: {{ $event->date }}</p>
                <a href="{{ route('events.purchase', $event->id) }}" class="btn btn-primary">Comprar boletos</a>
            </div>
        @endforeach
    </div>
    <div class="pagination">
        @for ($i = 1; $i <= 10; $i++)
            <a href="#"> {{ $i }} </a>
        @endfor
        <a href="#">Siguiente</a>
    </div>
@endsection

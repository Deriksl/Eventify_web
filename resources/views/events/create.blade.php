@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Crear Nuevo Evento</h3>

        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Nombre del Evento</label>
                <input type="text" name="name" class="form-control" id="name" required>
            </div>

            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea name="description" class="form-control" id="description" required></textarea>
            </div>

            <div class="form-group">
                <label for="location">Ubicación</label>
                <input type="text" name="location" class="form-control" id="location" required>
            </div>

            <div class="form-group">
                <label for="date">Fecha</label>
                <input type="date" name="date" class="form-control" id="date" required>
            </div>

            <div class="form-group">
                <label for="logo">Logo (Opcional)</label>
                <input type="file" name="logo" class="form-control" id="logo">
            </div>

            <div class="form-group">
                <label for="ticket_price">Precio del Ticket</label>
                <input type="number" name="ticket_price" class="form-control" id="ticket_price" step="0.01" required>
            </div>

            <button type="submit" class="btn btn-primary">Crear Evento</button>
        </form>
    </div>
@endsection

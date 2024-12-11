@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Evento</h2>
        <form>
            <div class="form-group">
                <label for="event-name">Nombre del Evento</label>
                <input type="text" id="event-name" class="form-control" placeholder="Nombre del evento">
            </div>

            <div class="form-group">
                <label for="event-description">Descripción</label>
                <textarea id="event-description" class="form-control" rows="4" placeholder="Descripción del evento"></textarea>
            </div>

            <div class="form-group">
                <label for="event-location">Localidad</label>
                <input type="text" id="event-location" class="form-control" placeholder="Localidad del evento">
            </div>

            <div class="form-group">
                <label for="event-date">Fecha</label>
                <input type="datetime-local" id="event-date" class="form-control">
            </div>

            <div class="form-group">
                <label for="event-logo">Logo del Evento</label>
                <input type="file" id="event-logo" class="form-control-file">
            </div>

            <div class="form-group">
                <label for="ticket_price">Precio del Ticket</label>
                <input type="number" name="ticket_price" class="form-control" value="{{ $event->ticket_price }}" step="0.01" required>
            </div>




            <!-- Botón para guardar cambios -->
            <button type="button" class="btn btn-success">Guardar Cambios</button>
        </form>
    </div>
@endsection

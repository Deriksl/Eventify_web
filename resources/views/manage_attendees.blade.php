@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Gestión de Asistentes para el Evento {{ $event->name }}</h1>

        <h3>Lista de Asistentes</h3>
        <table class="table">
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo Electrónico</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($attendees as $attendee)
                <tr>
                    <td>{{ $attendee->user->name }}</td>
                    <td>{{ $attendee->user->email }}</td>
                    <td>{{ $attendee->status }}</td>
                    <td>
                        <form action="{{ route('attendees.destroy', $attendee->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

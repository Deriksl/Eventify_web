@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">{{ $event->name }}</h1>

        <div class="row">
            <!-- Columna izquierda: Imagen y detalles -->
            <div class="col-md-6">
                <!-- Imagen del evento -->
                @if($event->logo)
                    <div class="event-image mb-3">
                        <img src="{{ asset('storage/' . $event->logo) }}" alt="Logo del evento">
                    </div>
                @endif

                <div class="mb-3">
                    <p><strong>Descripción:</strong> {{ $event->description }}</p>
                    <p><strong>Ubicación:</strong> {{ $event->location }}</p>
                    <p><strong>Fecha:</strong> {{ $event->date }}</p>
                    <p><strong>Precio del Ticket:</strong> ${{ number_format($event->ticket_price, 2) }}</p>
                </div>
            </div>

            <!-- Columna derecha: Botón de compra -->
            <div class="col-md-6">
                <!-- Botón de compra -->
                <form action="{{ route('purchase.ticket', $event->id) }}" method="POST" class="mb-3">
                    @csrf
                    <button type="submit" class="btn btn-success w-100">Comprar Ticket</button>
                </form>

                <!-- Formulario para agregar comentarios -->
                <h4 class="mt-3">Deja un comentario</h4>
                <form action="{{ route('comments.store', $event->id) }}" method="POST" class="comment-form">
                    @csrf
                    <div class="form-group">
                        <label for="comment">Comentario:</label>
                        <textarea id="comment" name="comment" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="rating">Calificación:</label>
                        <select id="rating" name="rating" class="form-control">
                            <option value="">Selecciona una calificación (opcional)</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }} estrella{{ $i > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Enviar Comentario</button>
                </form>
            </div>
        </div>

        <!-- Comentarios -->
        <div class="mt-4">
            <h3>Comentarios</h3>
            @forelse($event->comments as $comment)
                <div class="comment">
                    <strong>{{ $comment->user->name }}</strong>
                    <span class="rating">({{ $comment->rating }} estrellas)</span>
                    <p>{{ $comment->comment }}</p>
                </div>
            @empty
                <p class="text-center">No hay comentarios aún. ¡Sé el primero en comentar!</p>
            @endforelse
        </div>
    </div>
@endsection

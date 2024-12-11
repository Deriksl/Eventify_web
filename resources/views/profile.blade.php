@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Perfil de Usuario</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="profile-header text-center">
            <div class="profile-picture-container">
                @if(Auth::check() && Auth::user()->profile_picture) <!-- Verifica si el usuario tiene una foto de perfil -->
                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Foto de perfil" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
                @else
                    <img src="{{ asset('assets/img/default-profile.png') }}" alt="Foto de perfil predeterminada" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
                @endif
            </div>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" readonly>
            </div>

            <div class="form-group">
                <label for="lastname">Apellido</label>
                <input type="text" name="lastname" id="lastname" class="form-control" value="{{ $user->lastname }}" readonly>
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" readonly>
            </div>

            <div class="form-group">
                <label for="phone_number">Teléfono</label>
                <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ $user->phone_number }}" readonly>
            </div>

            <div class="form-group">
                <label for="username">Nombre de Usuario</label>
                <input type="text" name="username" id="username" class="form-control" value="{{ $user->username }}" readonly>
            </div>

            <div class="form-group">
                <label for="profile_picture">Foto de Perfil</label>
                <input type="file" name="profile_picture" id="profile_picture" class="form-control">
            </div>

            <div class="form-group" id="password-group" style="display: none;">
                <label for="password">Nueva Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Dejar en blanco si no desea cambiarla">
            </div>

            <div class="form-group" id="password_confirmation-group" style="display: none;">
                <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Dejar en blanco si no desea cambiarla">
            </div>

            <button type="button" class="btn btn-link" onclick="toggleEdit()">Editar Información</button>
            <button type="submit" class="btn btn-primary">Actualizar Perfil</button>

            <!-- Contenedor para los botones -->
            <div class="buttons-container" style="margin-top: 20px;">
                <a href="{{ route('profile') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        function toggleEdit() {
            const fields = ['name', 'lastname', 'email', 'phone_number', 'username'];
            fields.forEach(field => {
                const input = document.getElementById(field);
                input.readOnly = !input.readOnly;

                // Si el campo se vuelve editable, agregar un placeholder
                if (!input.readOnly) {
                    input.placeholder = "Por favor, complete este campo";
                    input.focus();
                } else {
                    // Limpiar el placeholder cuando se vuelve no editable
                    input.placeholder = "";
                }
            });

            // Mostrar los campos de contraseña solo si se está editando
            const passwordGroup = document.getElementById(' password-group');
            const passwordConfirmationGroup = document.getElementById('password_confirmation-group');
            const isEditing = !document.getElementById('name').readOnly; // Verifica si se está editando

            passwordGroup.style.display = isEditing ? 'block' : 'none';
            passwordConfirmationGroup.style.display = isEditing ? 'block' : 'none';
        }
    </script>
@endsection

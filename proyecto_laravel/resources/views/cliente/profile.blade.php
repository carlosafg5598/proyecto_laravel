@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="card shadow-lg p-4" style="max-width: 600px; width: 100%; border-radius: 15px;">
        <h2 class="text-center mb-4">Mi Perfil</h2>

        <!-- Mostrar Mensajes de Éxito -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Mostrar Errores -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario para Editar Perfil -->
        <form action="{{ route('cliente.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Nombre</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label fw-bold">Dirección</label>
                <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $cliente->direccion) }}">
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label fw-bold">Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $cliente->telefono) }}">
            </div>

            <button type="submit" class="btn btn-primary w-100">Actualizar Perfil</button>
        </form>

        <!-- Botón para Cambiar Contraseña -->
        <button class="btn btn-warning mt-3 w-100" onclick="document.getElementById('changePasswordForm').classList.toggle('d-none')">
            Cambiar Contraseña
        </button>

        <!-- Formulario para Cambiar Contraseña (Oculto al inicio) -->
        <div id="changePasswordForm" class="mt-3 d-none">
            <form action="{{ route('cliente.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="current_password" class="form-label fw-bold">Contraseña Actual</label>
                    <input type="password" name="current_password" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label fw-bold">Nueva Contraseña</label>
                    <input type="password" name="new_password" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label fw-bold">Confirmar Nueva Contraseña</label>
                    <input type="password" name="new_password_confirmation" class="form-control">
                </div>

                <button type="submit" class="btn btn-success w-100">Actualizar Contraseña</button>
            </form>
        </div>

        <!-- Botón para Eliminar Cuenta -->
        <form action="{{ route('cliente.delete') }}" method="POST" class="mt-3">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger w-100">Eliminar Cuenta</button>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Perfil del Administrador</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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
    <form action="{{ route('admin.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
        </div>

        <div class="mb-3">
            <label for="departamento" class="form-label">Departamento</label>
            <input type="text" name="departamento" class="form-control" value="{{ old('departamento', $admin->departamento) }}">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
    </form>

    <!-- Botón para Cambiar Contraseña -->
    <button class="btn btn-warning mt-3" onclick="document.getElementById('changePasswordForm').style.display='block'">
        Cambiar Contraseña
    </button>

    <!-- Formulario para Cambiar Contraseña -->
    <div id="changePasswordForm" style="display:none;" class="mt-3">
        <form action="{{ route('admin.password') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="current_password" class="form-label">Contraseña Actual</label>
                <input type="password" name="current_password" class="form-control">
            </div>

            <div class="mb-3">
                <label for="new_password" class="form-label">Nueva Contraseña</label>
                <input type="password" name="new_password" class="form-control">
            </div>

            <div class="mb-3">
                <label for="new_password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                <input type="password" name="new_password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Actualizar Contraseña</button>
        </form>
    </div>
</div>
@endsection

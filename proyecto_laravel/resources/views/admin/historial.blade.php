@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Historial de Cambios</h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Administrador</th>
                <th>Acción</th>
                <th>Detalles</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($acciones as $accion)
                <tr>
                    <td>{{ $accion->administrador->name }}</td>
                    <td>{{ $accion->accion }}</td>
                    <td>{{ $accion->detalles }}</td>
                    <td>{{ $accion->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

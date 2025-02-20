<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">Inicio</a>

                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">
                        @auth
                        @if(Auth::user()->role == 'admin')
                        <!-- Opciones para ADMINISTRADORES -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.clientes') }}">Gestionar Clientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.historial') }}">Historial de Cambios</a> <!-- 🔹 Nuevo enlace -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.profile') }}">Mi Perfil</a>
                        </li>
                        @else
                        <!-- Opciones para CLIENTES -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cliente.profile') }}">Mi Perfil</a>
                        </li>
                        @endif

                        <!-- Botón de Cerrar Sesión -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Cerrar Sesión
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                        @else
                        <!-- Opciones para Usuarios No Autenticados -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>


        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
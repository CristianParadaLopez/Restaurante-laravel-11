<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Estilos generales del panel -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
    @stack('styles')
</head>
<body class="container-scroller">

    <!-- Navbar unificado -->
    @include('admin.layouts.navbar')

    <!-- Contenido principal -->
    <div class="main-panel">
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <!-- Scripts generales -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @include('admin.layouts.scripts')
    @stack('scripts')
</body>
</html>

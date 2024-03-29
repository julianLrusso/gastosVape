<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta charset="UTF-8">
    <title>Resumen de stock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <style>
        .estasAca {
            border-bottom: 1px solid #0a53be;
        }
    </style>
</head>
<body style="background-color: #2a268f">
<?php
$rutacompleta = Illuminate\Support\Facades\Route::currentRouteName();
$route = explode('.',$rutacompleta)[0];
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Ganancias</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item ">
                    <a class="nav-link active {{$route == 'productos' ? 'estasAca' : ''}}" aria-current="page" href="{{route('productos.listado')}}">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active {{$route == 'clientes' ? 'estasAca' : ''}}" aria-current="page" href="{{route('clientes.listado')}}">Clientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active {{$route == 'facturacion' && $rutacompleta != 'facturacion.ingresos' && $rutacompleta != 'facturacion.showVentas' ? 'estasAca' : ''}}"
                       aria-current="page" href="{{route('facturacion.listado')}}">Facturas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active {{$rutacompleta == 'facturacion.ingresos' ? 'estasAca' : ''}}" aria-current="page" href="{{route('facturacion.ingresos')}}">Ingreso</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active {{$rutacompleta == 'facturacion.showVentas' ? 'estasAca' : ''}}" aria-current="page" href="{{route('facturacion.showVentas')}}">Venta</a>
                </li>
                @if(Auth::user()->rol == 'admin')
                    <li class="nav-item">
                        <a class="nav-link active {{$rutacompleta == 'formRegister' || $route == 'usuarios' ? 'estasAca' : ''}}" aria-current="page" href="{{route('usuarios.listado')}}">Usuarios</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route('logout')}}">Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

@if(Session::has('message.success'))
    <div class="alert alert-success container my-3">
        {!! Session::get('message.success') !!}
    </div>
@endif
@if(Session::has('message.error'))
    <div class="alert alert-danger container my-3">
        {!! Session::get('message.error') !!}
    </div>
@endif

<main class="mt-3">
    @yield('main')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>

</body>
</html>

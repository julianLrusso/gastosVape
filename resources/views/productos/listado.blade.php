@extends('layouts.main')

@section('title', 'Listado de productos')

<script
    src="https://code.jquery.com/jquery-3.6.3.slim.min.js"
    integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo="
    crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@section('main')
    <div class="container">

        <a href="{{route('productos.agregar')}}">
            <button class="btn btn-warning w-100 mt-2">Agregar producto</button>
        </a>

        <div class="card mt-2 mb-4">
            <div class="card-body">
                <form action="{{route('productos.listadoFiltrado')}}" method="POST">
                    @csrf
                    <div>
                        <label for="nombreProducto" class="form-label">Selección específica</label>
                        <select name="nombreProducto" id="nombreProducto" class="form-control">
                            <option value="">Seleccione un producto...</option>
                            @foreach($productos as $producto)
                                <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="nombreLike" class="form-label">Buscar por nombre</label>
                        <input type="text" name="nombreLike" id="nombreLike" class="form-control" value="{{$input??''}}">
                    </div>
                    <div class="mt-2 text-center">
                        <button class="btn btn-warning w-75">Buscar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-1" style="background-color: whitesmoke">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Stock</th>
                    <th scope="col">#</th>
                </tr>
                </thead>
                <tbody>
                @foreach($productos as $producto)
                <tr style="{{$producto->trashed() ? 'background-color: rgba(227, 59, 59, 0.5)' : ''}}">
                    <th>{{ $producto->nombre }}</th>
                    <td>{{ $producto->stock }}</td>
                    <td>
                        <a class="btn btn-warning" href="{{ route('productos.show', ['id' => $producto->id]) }}">
                            Ver
                        </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <script>
        $('#nombreProducto').select2();
    </script>
@endsection

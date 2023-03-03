@extends('layouts.main')

@section('title', 'Resumen general')

@section('main')
    <div class="container">

        <a href="{{route('clientes.agregar')}}">
            <button class="btn btn-warning w-100 mt-2">Agregar Cliente</button>
        </a>

        <div class="card mt-2 mb-4">
            <div class="card-body">
                <form action="{{route('clientes.listadoFiltrado')}}" method="POST">
                    @csrf
                    <div>
                        <label for="nombreCliente" class="form-label">Selección específica</label>
                        <select name="nombreCliente" id="nombreCliente" class="form-control">
                            <option value="">Seleccione un cliente...</option>
                            @foreach($clientes as $cliente)
                                <option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
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
                    <th scope="col">Dirección</th>
                    <th scope="col">Telefono</th>
                    <th scope="col">#</th>
                </tr>
                </thead>
                <tbody>
                @foreach($clientes as $cliente)
                    <tr style="{{$cliente->trashed() ? 'background-color: rgba(227, 59, 59, 0.5)' : ''}}">
                        <th>{{ $cliente->nombre }}</th>
                        <td>{{ $cliente->direccion }}</td>
                        <td>{{ $cliente->telefono }}</td>
                        <td>
                            <a class="btn btn-warning" href="{{ route('clientes.show', ['id' => $cliente->id]) }}">
                                Ver
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection

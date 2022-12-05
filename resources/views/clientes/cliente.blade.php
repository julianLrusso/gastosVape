@extends('layouts.main')

@section('title', 'Resumen general')

@section('main')
    <div class="container">

        <div class="card mt-2">
            <div class="card-body">
                <form action="{{route('clientes.update', ['id' => $cliente->id])}}" method="POST">
                    @csrf
                    @method('PUT')
                    <label>Nombre: <input class="form-control" type="text" name="nombre" id="nombre" value="{{$cliente->nombre}}"></label>
                    @error('nombre')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <div class="mt-3 d-flex justify-content-center">
                        <button class="btn btn-warning w-75">Editar</button>
                    </div>

                </form>

                <div class="mt-3">
                    @if($cliente->trashed())
                    <form class="w-100 d-flex justify-content-center" action="{{route('clientes.restore', ['id' => $cliente->id])}}" method="POST">
                        @csrf
                        <button class="btn btn-success w-75">Restaurar</button>
                    </form>
                    @else
                        <form class="w-100 d-flex justify-content-center" action="{{route('clientes.delete', ['id' => $cliente->id])}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger w-75">Eliminar</button>
                        </form>
                    @endif
                </div>


            </div>
        </div>

        <div class="row mt-3">
            <div class="card col">
                <div class="card-body">

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Stock</th>
                            <th scope="col">Precio</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td style="color: green">+50</td>
                            <td>$-575.000,00</td>
                        </tr>
                        <tr>
                            <td style="color: red">-20</td>
                            <td>$126.000,00</td>
                        </tr>
                        <tr style="background-color: #ffe480">
                            <td class="fw-bold">Total</td>
                            <td class="fw-bold">$-449.000,00</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
@endsection

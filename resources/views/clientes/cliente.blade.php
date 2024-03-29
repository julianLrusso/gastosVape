@extends('layouts.main')

@section('title', 'Resumen general')
<?php $total = 0; ?>
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
                    <label>Telefono: <input class="form-control" type="text" name="telefono" id="telefono" value="{{$cliente->telefono}}"></label>
                    @error('telefono')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <label>Direccion: <input class="form-control" type="text" name="direccion" id="direccion" value="{{$cliente->direccion}}"></label>
                    @error('direccion')
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

        <div class="row mt-3" style="max-height: 35vh; overflow-y: auto">
            <div class="card col">
                <div class="card-body">

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Factura tipo</th>
                            <th scope="col">Productos</th>
                            <th scope="col">Precio</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($facturas as $factura)

                            <tr>
                                <td><a href="{{route('facturacion.showIngreso', $factura->id)}}"> {{$factura->tipo->tipo}} </a></td>

                                <td>
                                    @foreach($factura->productos as $producto)
                                        <a href="{{route('productos.show', $producto->id)}}">{{$producto->nombre}}</a> -
                                    @endforeach
                                </td>

                                <td>${{ number_format($factura->monto_total, 2) }}</td>
                                    <?php if ($factura->tipo->id == 1) {
                                    $total -= $factura->monto_total;
                                } else{
                                    $total += $factura->monto_total;
                                } ?>


                            </tr>

                        @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <div class="card mt-3 bg-warning">
            <div class="card-body text-center">
                <p class="h3 fw-bold">Total: $ {{number_format($total, 2)}}</p>
            </div>
        </div>
    </div>
@endsection

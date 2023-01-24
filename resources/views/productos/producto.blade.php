@extends('layouts.main')

@section('title', $producto->nombre)
<?php
$total = 0;
?>
@section('main')
    <div class="container">

        <div class="card mt-2">
            <div class="card-body">
                <form action="{{route('productos.update', ['id' => $producto->id])}}" method="POST">
                    @csrf
                    @method('PUT')
                    <label>Nombre: <input class="form-control" type="text" name="nombre" id="nombre" value="{{$producto->nombre}}"></label>
                    @error('nombre')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label>Peso en gramos: <input class="form-control" name="peso" id="peso" type="text" value="{{$producto->peso}}"></label>
                    @error('peso')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <div class="mt-3 d-flex justify-content-center">
                        <button class="btn btn-warning w-75">Editar</button>
                    </div>

                </form>

                <div class="mt-3">
                    @if($producto->trashed())
                    <form class="w-100 d-flex justify-content-center" action="{{route('productos.restore', ['id' => $producto->id])}}" method="POST">
                        @csrf
                        <button class="btn btn-success w-75">Restaurar</button>
                    </form>
                    @else
                        <form class="w-100 d-flex justify-content-center" action="{{route('productos.delete', ['id' => $producto->id])}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger w-75">Eliminar</button>
                        </form>
                    @endif
                </div>

                <div class="card mt-3" style="max-height: 35vh; overflow-y: auto">
                    <div class="card-body text-center">
                        <p class="h4 fw-bold">Stock Total: {{ $producto->stock }}</p>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Disponibles</th>
                                <th scope="col">Comprados a</th>
                                <th scope="col">En la factura</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($producto->facturas as $factura)
                                    @if($factura->pivot->disponible > 0)
                                        <tr>
                                            <td>{{$factura->pivot->disponible}}</td>
                                            <td>$ {{$factura->pivot->precio}}</td>
                                            <td>
                                                <a href="{{route('facturacion.showIngreso', ['id' => $factura->id])}}">
                                                    {{$factura->id}}
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
                                <th scope="col">Cliente</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Disponible</th>
                                <th scope="col">Precio / Utilidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($producto->facturas as $factura)
                            <tr>
                                <td><a href="{{route('facturacion.showIngreso', $factura->id)}}"> {{$factura->tipo->tipo}} </a></td>

                                @if($factura->cliente)
                                    <td>{{$factura->cliente->nombre}}</td>
                                @else
                                    <td> - </td>
                                @endif

                                @if($factura->tipo->id == 1)
                                    <td style="color: green">+{{$factura->pivot->cantidad}}</td>
                                @else
                                    <td style="color: red">-{{$factura->pivot->cantidad}}</td>
                                @endif


                                @if($factura->pivot->disponible > 1)
                                    <td>{{$factura->pivot->disponible}}</td>
                                @else
                                    <td> - </td>
                                @endif

                                @if($factura->tipo->id == 1)
                                    <td style="color: red;">${{ number_format( ($factura->pivot->precio * $factura->pivot->cantidad), 2 ) }}</td>
                                @else
                                    <td style="color: green">${{ number_format( $factura->pivot->utilidad, 2 ) }}</td>
                                @endif


                                <?php if ($factura->tipo->id == 1) {
                                    $total -= ($factura->pivot->precio * $factura->pivot->cantidad);
                                } else{
                                    $total += $factura->pivot->utilidad;
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

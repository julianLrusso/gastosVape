@extends('layouts.main')

@section('title', 'Ingreso de stock')
<?php
  /** @var $factura \App\Models\Facturas */
  /** @var $producto \App\Models\Productos */
?>
@section('main')
    <div class="container">

        <a href="{{route('facturacion.listado')}}">
            <button class="btn btn-warning w-100 mt-2">Volver al listado</button>
        </a>

        <div class="row justify-content-center mt-1">
            <div class="card col m-2">
                <div class="card-body">

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Fecha</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Flete</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Utilidad</th>
                            <th scope="col">Monto Total</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>{{ \Carbon\Carbon::parse($factura->created_at)->format('d/m/Y')}}</th>
                                <td>{{ $factura->tipo->tipo }}</td>
                                <td>{{ $factura->descripcion }}</td>
                                <td>{{ $factura->flete > 0 ? $factura->flete : '-' }}</td>
                                <td>{{ $factura->cliente->nombre ?? '-' }}</td>
                                <td>{{ $factura->utilidadTotal > 0 ? $factura->utilidadTotal : '-' }}</td>
                                <td>{{ number_format($factura->monto_total, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-5">
                        <p class="h4">Productos:</p>
                    </div>
                    <div>
                        @foreach($factura->productos as $producto)

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Precio</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th>{{ $producto->nombre}}</th>
                                    <td>{{ $producto->pivot->cantidad }}</td>
                                    <td>{{ number_format($producto->pivot->precio, 2) }}</td>
                                </tr>
                                </tbody>
                            </table>
                        @endforeach

                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection

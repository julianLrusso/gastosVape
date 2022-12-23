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
                    <p> {{ \Carbon\Carbon::parse($factura->created_at)->format('d/m/Y')}} </p>
                    <p><b>Descripcion:</b> {{ $factura->descripcion }}</p>
                    <p><b>Flete:</b> {{ $factura->flete }}</p>
                    <p><b>Monto total:</b> ${{ $factura->monto_total }}</p>
                    <p>Productos:</p>
                    <div>
                        @foreach($factura->productos as $producto)
                            <ul>
                                <li>{{$producto->nombre}} </li>
                                <li>Cantidad: {{$producto->pivot->cantidad}}</li>
                                <li>Precio: {{$producto->pivot->precio}}</li>
                            </ul>
                        @endforeach

                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection

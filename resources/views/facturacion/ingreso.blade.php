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
                    <p><b>Tipo:</b> {{ $factura->tipo->tipo }}</p>
                    <p><b>Descripcion:</b> {{ $factura->descripcion }}</p>
                    @if($factura->fk_cliente)
                        <p><b>Cliente:</b> {{ $factura->cliente->nombre }}</p>
                    @endif
                    <p><b>Flete:</b> {{ $factura->flete == 0 ? '-' : $factura->flete}}</p>
                    <p><b>Monto total:</b> ${{ number_format($factura->monto_total, 2) }}</p>
                    <p>Productos:</p>
                    <div>
                        @foreach($factura->productos as $producto)
                            <ul>
                                <li>{{$producto->nombre}} </li>
                                <li>Cantidad: {{$producto->pivot->cantidad}}</li>
                                <li>Precio: ${{number_format($producto->pivot->precio, 2) }}</li>
                            </ul>
                        @endforeach

                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection

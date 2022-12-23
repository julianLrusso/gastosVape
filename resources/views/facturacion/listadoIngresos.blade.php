@extends('layouts.main')

@section('title', 'Listado de facturas')

@section('main')
    <div class="container">

        <a href="{{route('facturacion.ingresos')}}">
            <button class="btn btn-warning w-100 mt-2">Agregar Ingreso</button>
        </a>

        <div class="row justify-content-center mt-1">
            @foreach($facturas as $factura)
                <div class="card col-lg-3 m-2">
                    <a href="{{ route('facturacion.showIngreso', ['id' => $factura->id]) }}" style="text-decoration: none; color: black">
                        <div class="card-body">
                            <p> {{ \Carbon\Carbon::parse($factura->created_at)->format('d/m/Y')}} </p>
                            <p>Descripcion: {{ $factura->descripcion }}</p>
                            <p>Flete: {{ $factura->flete }}</p>
                            <p>Monto total: ${{ $factura->monto_total }}</p>
                        </div>
                    </a>
                </div>
            @endforeach

        </div>

    </div>
@endsection

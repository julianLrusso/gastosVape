@extends('layouts.main')

@section('title', 'Listado de facturas')

@section('main')
    <div class="container">

        <div class="card">
            <div class="card-body">
                <form action="{{route('facturacion.listadoFiltrado')}}" method="POST">
                    @csrf
                    <div>
                        <label for="firstDate" class="fw-bold">Fecha desde</label>
                        <input class="form-control" type="date" name="firstDate" id="firstDate">
                    </div>
                    <div class="mt-2">
                        <label for="lastDate" class="fw-bold">Fecha hasta</label>
                        <input class="form-control" type="date" name="lastDate" id="lastDate">
                    </div>
                    <div class="mt-2">
                        <label for="lastDate" class="fw-bold">Tipo</label>
                        <select name="factura_tipo" id="factura_tipo" class="form-control">
                            <option value="">Seleccione una opción...</option>
                            <option value="1">Ingreso</option>
                            <option value="2">Venta</option>
                        </select>
                    </div>
                    <div class="mt-2 text-center">
                        <button class="btn btn-warning w-75">Filtrar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row justify-content-center mt-1">
            @foreach($facturas as $factura)
                <div class="card col-lg-3 m-2">
                    <a href="{{ route('facturacion.showIngreso', ['id' => $factura->id]) }}" style="text-decoration: none; color: black">
                        <div class="card-body">
                            <p> {{ \Carbon\Carbon::parse($factura->created_at)->format('d/m/Y')}} </p>
                            <p>Tipo: {{ $factura->tipo->tipo }} </p>
                            <p>Descripcion: {{ $factura->descripcion }}</p>
                            <p>Flete: {{ $factura->flete }}</p>
                            <p><b>Monto total: ${{ number_format($factura->monto_total, 2)}}</b></p>
                        </div>
                    </a>
                </div>
            @endforeach

        </div>

    </div>
@endsection

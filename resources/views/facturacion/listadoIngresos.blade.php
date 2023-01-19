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
                        <input class="form-control" type="date" name="firstDate" id="firstDate"
                        @if(isset($fechaInicialSeleccionada))
                            value="{{$fechaInicialSeleccionada}}"
                        @endif
                        >
                    </div>
                    <div class="mt-2">
                        <label for="lastDate" class="fw-bold">Fecha hasta</label>
                        <input class="form-control" type="date" name="lastDate" id="lastDate"
                           @if(isset($fechaFinalSeleccionada))
                               value="{{$fechaFinalSeleccionada}}"
                           @endif
                        >
                    </div>
                    <div class="mt-2">
                        <label for="factura_tipo" class="fw-bold">Tipo</label>
                        <select name="factura_tipo" id="factura_tipo" class="form-control">
                            <option value="">Seleccione una opción...</option>
                            <option value="1" {{isset($tipoSeleccionado) && $tipoSeleccionado == 1 ? 'selected' : ''}}>Ingreso</option>
                            <option value="2" {{isset($tipoSeleccionado) && $tipoSeleccionado == 2 ? 'selected' : ''}}>Venta</option>
                        </select>
                    </div>
                    <div class="mt-2">
                        <label for="cliente" class="fw-bold">Cliente</label>
                        <select name="cliente" id="cliente" class="form-control">
                            <option value="">Seleccione una opción...</option>
                           @foreach($clientes as $cliente)
                                <option value="{{$cliente->id}}"
                                    @if(isset($clienteSeleccionado) && $clienteSeleccionado == $cliente->id)
                                        selected=""
                                    @endif
                                >
                                    {{$cliente->nombre}}
                                </option>
                           @endforeach
                        </select>
                    </div>
                    <div class="mt-2 text-center">
                        <button class="btn btn-warning w-75">Filtrar</button>
                    </div>
                </form>
            </div>
        </div>
        @if(isset($facturas))
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
        @endif


    </div>
@endsection

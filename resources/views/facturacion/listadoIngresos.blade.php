@extends('layouts.main')

@section('title', 'Listado de facturas')

<script
    src="https://code.jquery.com/jquery-3.6.3.slim.min.js"
    integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo="
    crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

            <div class="mt-1" style="background-color: whitesmoke">
                <table class="table table-striped" id="tablaFacturas">
                    <thead>
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Monto Total</th>
                        <th scope="col">#</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($facturas as $factura)
                        <tr>
                            <th>{{ \Carbon\Carbon::parse($factura->created_at)->format('d/m/Y')}}</th>
                            <td>{{ $factura->tipo->tipo }}</td>
                            <td>{{ $factura->descripcion }}</td>
                            <td>{{ number_format($factura->monto_total, 2) }}</td>
                            <td class="d-flex">
                                <a class="btn btn-warning" href="{{ route('facturacion.showIngreso', ['id' => $factura->id]) }}">
                                    Ver
                                </a>
                                @if($factura->tipo->tipo == 'Ingreso')
                                    <form id="eliminarFactura" style="margin: 0 0 0 10px;" action="{{route('facturacion.eliminarFacturaCompra', ['id' => $factura->id])}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger eliminarFactura" type="button">Eliminar</button>
                                    </form>
                                @else

                                    <form id="eliminarFactura" style="margin: 0 0 0 10px;" action="{{route('facturacion.eliminarFacturaVenta', ['id' => $factura->id])}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger eliminarFactura" type="button">Eliminar</button>
                                    </form>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        @endif


    </div>
    <script>
        $(document).ready(function() {
            $('#cliente').select2();
        });
        const tablaFacturas = document.getElementById('tablaFacturas');

        tablaFacturas.addEventListener('click', (e) => {
            if(e.target.classList.contains('eliminarFactura')){
                const formEliminarFactura = e.target.parentNode;
                if(confirm('¿Estás seguro que deseas eliminar la factura?')){
                    formEliminarFactura.submit();
                }
            }
        })

    </script>
@endsection

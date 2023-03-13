@extends('layouts.main')

@section('title', 'Resumen general')

@section('main')
<?php /** @var  $factura \App\Models\Facturas  */
$total = 0;
$totalUtilidad = 0;
?>
<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{route('home')}}" method="POST">
                @csrf
                <div>
                    <label for="firstDate">Fecha desde</label>
                    <input class="form-control" type="date" name="firstDate" id="firstDate">
                </div>
                <div class="mt-2">
                    <label for="lastDate">Fecha hasta</label>
                    <input class="form-control" type="date" name="lastDate" id="lastDate">
                </div>
                <div class="mt-2 text-center">
                    <button class="btn btn-warning w-75">Filtrar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-3">
        <div class="card col">
            <div class="card-body">

                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Factura Nro</th>
                        <th scope="col">Tipo Factura</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Utilidad</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($facturas as $factura)
                        <tr>

                            <td><a href="{{route('facturacion.showIngreso',$factura->id)}}">{{$factura->id}}</a></td>

                            <td>{{$factura->tipo->tipo}}</td>

                            @if($factura->cliente)
                                <td><a href="{{route('clientes.show',$factura->cliente->id)}}">{{$factura->cliente->nombre}}</a></td>
                            @else
                                <td> - </td>
                            @endif

                            @if($factura->tipo->id == 1)
                                <td style="color: red">- ${{$factura->monto_total}}</td>
                                <?php $total -=  $factura->monto_total?>
                            @else
                                <td style="color: green">+ ${{$factura->monto_total}}</td>
                                    <?php $total +=  $factura->monto_total?>
                            @endif

                            @if($factura->utilidadTotal > 0)
                                <td style="color: green">+ ${{$factura->utilidadTotal}}</td>
                                    <?php $totalUtilidad +=  $factura->utilidadTotal?>
                            @else
                                <td>-</td>
                            @endif

                        </tr>
                    @endforeach

                    </tbody>
                </table>
                {{ $facturas->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    <div class="card mt-3 bg-warning">
        <div class="card-body text-center">
            <p class="h3 fw-bold">Total: {{number_format( $total, 2)}}</p>
            <p class="h3 fw-bold">Total Utilidad: {{number_format($totalUtilidad, 2)}}</p>
        </div>
    </div>

</div>
@endsection

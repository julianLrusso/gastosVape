@extends('layouts.main')

@section('title', 'Resumen general')

@section('main')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div>
                <label for="">Fecha desde</label>
                <input class="form-control" type="date">
            </div>
            <div class="mt-2">
                <label for="">Fecha hasta</label>
                <input class="form-control" type="date">
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="card col">
            <div class="card-body">

                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Producto</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Precio</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Vaporesso - XROS 2 Pod</td>
                        <td style="color: green">+50</td>
                        <td>$-575.000,00</td>
                    </tr>
                    <tr>
                        <td>Vaporesso - XROS 2 Pod</td>
                        <td style="color: red">-20</td>
                        <td>$126.000,00</td>
                    </tr>
                    <tr>
                        <td>Voopoo - Argus Air Pod</td>
                        <td style="color: green">+30</td>
                        <td>$-192.000,00</td>
                    </tr>
                    <tr style="background-color: #ffe480">
                        <td colspan="2" class="fw-bold">Total</td>
                        <td class="fw-bold">$-641.000,00</td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>
@endsection

@extends('layouts.main')

@section('title', 'Resumen general')

@section('main')
    <div class="container">

        <div class="card mt-4">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Producto</label>
                    <select class="form-control" name="" id="">
                        <option value="Vaporesso - XROS 2 Pod">Vaporesso - XROS 2 Pod</option>
                        <option value="Voopoo - Argus Air Pod">Voopoo - Argus Air Pod</option>
                        <option value="Asvape - Hita Kit">Asvape - Hita Kit</option>
                    </select>

                </div>
                <div class="mb-3">
                    <label class="form-label">Valor de flete</label>
                    <input type="number" value="10" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Cantidad</label>
                    <input type="number" value="5" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Total de gastos</label>
                    <input type="number" class="form-control">
                </div>
                <button type="submit" class="btn btn-warning w-100">Agregar venta</button>

            </div>
        </div>

    </div>
@endsection

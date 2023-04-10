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
                    <form action="{{route('facturacion.editFactura', ['id' => $factura->id])}}" method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" value="{{$factura->id}}">
                        <div>
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
                                    <td>
                                        <select name="tipo" id="tipo" class="form-control">
                                            <option value="1" {{ $factura->tipo->id == 1 ? 'selected' : '' }}>Ingreso
                                            </option>
                                            <option value="2" {{ $factura->tipo->id == 2 ? 'selected' : '' }}>Venta
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                    <textarea name="descripcion" id="descripcion" cols="20"
                                              rows="2">{{ $factura->descripcion }}</textarea>
                                    </td>
                                    <td>
                                        <input type="number" value="{{$factura->flete}}" name="flete" id="flete">
                                    </td>
                                    <td>
                                        <select name="cliente" id="cliente" class="form-control">
                                            <option value=""> -</option>
                                            @foreach($clientes as $cliente)
                                                <option
                                                    value="{{$cliente->id}}" {{isset($factura->cliente->id) && $factura->cliente->id == $cliente->id ? 'selected' : ''}} >
                                                    {{$cliente->nombre}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="utilidadTotal" id="utilidadTotal"
                                               value="{{$factura->utilidadTotal}}">
                                    </td>
                                    <td>
                                        <input type="number" name="monto_total" id="monto_total"
                                               value="{{$factura->monto_total}}">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-5">
                            <p class="h4">Productos:</p>
                        </div>
                        <div class="my-4 d-flex">
                            <select name="agregarProductos" id="agregarProductos" class="form-control w-25">
                                <option value="">Seleccione un producto...</option>
                                @foreach($productos as $producto)
                                    <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                                @endforeach
                            </select>

                            <button class="btn btn-warning" type="button">Agregar</button>
                        </div>
                        <div>


                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Utilidad</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                                </thead>
                                <tbody id="tablaProductos">
                                @foreach($factura->productos as $producto)
                                    <tr id="rowProducto-{{$producto->id}}">
                                        <th class="producto" data-idproducto="{{$producto->id}}">
                                            {{ $producto->nombre}}
                                        </th>
                                        <td>
                                            <input id="cantidad-{{$producto->id}}" type="number" min="1"
                                                   value="{{ $producto->pivot->cantidad }}" class="form-control">
                                        </td>
                                        <td>
                                            <input id="precio-{{$producto->id}}" type="number" min="1"
                                                   value="{{ $producto->pivot->precio }}" class="form-control">
                                        </td>
                                        <td>
                                            <input id="utilidad-{{$producto->id}}" type="number" min="1"
                                                   value="{{ $producto->pivot->utilidad }}" class="form-control">
                                        </td>
                                        <td>
                                            <button class="btn btn-danger eliminarProd"
                                                    data-idproducto="{{$producto->id}}" type="button">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>


                            <button class="btn btn-warning w-100" type="submit">Editar</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>

    <script>
        const tablaProductos = document.getElementById('tablaProductos');

        tablaProductos.addEventListener('click', (e) => {
            if (e.target.classList.contains('eliminarProd')) {
                console.log(e.target.dataset.idproducto);
                document.getElementById('rowProducto-'+e.target.dataset.idproducto).remove();
            }
        })
    </script>
@endsection

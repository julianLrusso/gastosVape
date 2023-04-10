@extends('layouts.main')

@section('title', 'Ingreso de stock')
<?php
/** @var $factura \App\Models\Facturas */
/** @var $producto \App\Models\Productos */
?>


<script
    src="https://code.jquery.com/jquery-3.6.3.slim.min.js"
    integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo="
    crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@section('main')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{route('facturacion.editFactura', ['id' => $factura->id])}}" method="POST">
            @csrf
            @method('PUT')
            <div class="card mt-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="productos">Producto</label>
                        <div class="row">
                            <div class="col-md-4">
                                <select class="form-control" id="productos">
                                    <option value="">Seleccione un producto...</option>
                                    @foreach($productos as $producto)
                                        <option data-peso="{{$producto->peso}}" value="{{$producto->id}}">{{$producto->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex">
                                    <label for="cantidad">Cantidad: </label>
                                    <div class="px-2">
                                        <input id="cantidad" name="cantidad" type="number" step="1" min="0" class="form-control cantidad">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex">
                                    <label for="precio">Precio unitario: </label>
                                    <div class="px-2">
                                        <input id="precio" name="precio" type="number" step="0.1" min="0" class="form-control precio">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-warning w-100" id="botonAgregar" type="button"><b>+</b></button>
                            </div>
                        </div>

                        <div class="mt-3">
                            <input type="hidden" name="json_productos" id="json_productos">
                            <p>Productos agregados</p>
                            <div id="divProductos">
                                <div class="border rounded p-4">
                                    Todavía no has añadido ningún producto.
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="flete">Valor de flete</label>
                        <input required name="flete" id="flete" type="number" min="0" class="form-control" value="{{$factura->flete}}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="descripcion">Descripcion</label>
                        <textarea class="form-control" name="descripcion" id="descripcion" cols="20" rows="2" required>{{$factura->descripcion}}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="total">Total de gastos</label>
                        <input required name="total" id="total" type="number" class="form-control" step="0.01" value="{{$factura->monto_total}}">
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Editar Ingreso</button>

                </div>
            </div>
        </form>
    </div>

    <script src="{{asset('js/edicion/editarCompra.js')}}"></script>
    <script>
        let productoPreCargado;

        $('#productos').select2();

        @foreach($factura->productos as $product)
            productoPreCargado = {
            'producto': "{{$product->nombre}}",
            'peso': "{{$product->peso}}",
            'id': "{{$product->id}}",
            'cantidad': "{{ $product->pivot->disponible }}",
            'precio': "{{$product->pivot->precio }}"
        }
        listadoProductos = listadoProductos.filter(product => product.id !== productoPreCargado.id);
        listadoProductos.push(productoPreCargado);
        setListado(listadoProductos);
        selectProductos.value = '';
        cantidad.value = '';
        precio.value = '';
        @endforeach
    </script>
@endsection

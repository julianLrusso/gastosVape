@extends('layouts.main')

@section('title', 'Agregar Ingreso')
<?php
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
        <form action="{{route('facturacion.crearIngreso')}}" method="POST">
            @csrf
        <input type="hidden" name="tipo" value="1">
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
                        <input required name="flete" id="flete" type="number" min="0" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="descripcion">Descripcion</label>
                        <textarea class="form-control" name="descripcion" id="descripcion" cols="20" rows="2" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="total">Total de gastos</label>
                        <input required name="total" id="total" type="number" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Agregar Ingreso</button>

                </div>
            </div>
        </form>
    </div>

    <script>
        const botonAgregar = document.getElementById('botonAgregar')
        const selectProductos = document.getElementById('productos');
        const htmlProductos = document.getElementById('divProductos');
        const cantidad = document.getElementById('cantidad');
        const precio = document.getElementById('precio');
        const total = document.getElementById('total');
        const flete = document.getElementById('flete');
        const json_productos = document.getElementById('json_productos');
        const kilo = 1000;
        let listadoProductos = [];

        // Escucha el botón agregar para agregar un producto
        botonAgregar.addEventListener('click', ()=>{
            if(selectProductos.value && cantidad.value && precio.value){
                let producto = {
                    'producto': selectProductos.options[selectProductos.selectedIndex].text,
                    'peso': selectProductos.options[selectProductos.selectedIndex].dataset.peso,
                    'id': selectProductos.value,
                    'cantidad': cantidad.value,
                    'precio': precio.value
                }
                listadoProductos = listadoProductos.filter(product => product.id !== producto.id);
                listadoProductos.push(producto);
                setListado(listadoProductos);
                selectProductos.value = ''
                cantidad.value = ''
                precio.value = ''
            }
        })

        // Escucha el click para saber que se borra.
        htmlProductos.addEventListener('click', (e) =>{
            if(e.target.dataset.id){
                borrarDelListado(e.target.dataset.id);
            }
        })

        flete.addEventListener('change', () => setListado(listadoProductos))

        /**
         * Se le pasa un array de objetos producto para armar el listado a mostrar
         * @param {array} listadoProductos
         */
        function setListado(listadoProductos){
            htmlProductos.innerHTML = '';
            if(listadoProductos.length < 1){
                htmlProductos.innerHTML = `
                    <div class="border rounded p-4">
                        Todavía no has añadido ningún producto.
                    </div>`;
            }
            let valorFlete = flete.value ? parseInt(flete.value) : 0;

            listadoProductos.forEach(producto => {

                let precioFleteUnitario = 0;
                if (valorFlete) {
                    let cantidadPorKilo = (kilo * producto.cantidad)/(producto.peso * producto.cantidad);
                    precioFleteUnitario = valorFlete/cantidadPorKilo;
                }
                let totalUnitario = parseFloat(parseFloat(producto.precio).toFixed(2)) + parseFloat(parseFloat(precioFleteUnitario).toFixed(2));
                producto.precioUnitario = totalUnitario;

                let div = document.createElement('div');
                div.classList.add('row');
                div.classList.add('border');
                div.classList.add('rounded');
                div.classList.add('p-2');
                div.classList.add('border-warning');
                div.innerHTML = `<div class="col-md-4">
                            <p>${producto.producto}</p>
                        </div>
                        <div class="col-md-2">
                            <p>Cantidad: ${producto.cantidad}</p>
                        </div>
                        <div class="col-md-4">
                            <p>Precio unitario: $${producto.precio} + flete: $${precioFleteUnitario} = $${totalUnitario} c/u</p>
                            <p><b>Total: $${Number( (totalUnitario*producto.cantidad).toFixed(2) )}</b></p>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-danger" data-id="${producto.id}">Borrar</button>
                        </div>`;
                htmlProductos.append(div);
            })
            calcularPrecioTotal(listadoProductos);
            setJsonProductos(listadoProductos);
        }

        /**
         * Borra del listado el item con id especificado
         * @param {int} id
         */
        function borrarDelListado(id){
            listadoProductos = listadoProductos.filter(product => product.id !== id);
            setListado(listadoProductos);
        }

        /**
         * Calcula el precio total y lo plasma en el input.
         * @param {array} listadoProductos
         */
        function calcularPrecioTotal(listadoProductos){
            let totalProvisorio = 0;

            if (listadoProductos.length > 0){
                listadoProductos.forEach(producto => {
                    totalProvisorio += (producto.cantidad * producto.precioUnitario);
                })

            }

            total.value = totalProvisorio;
        }

        /**
         * Transforma el listado en json y lo pone en el input
         * @param {array} listadoProductos
         */
        function setJsonProductos(listadoProductos){
            json_productos.value = JSON.stringify(listadoProductos);
        }

        $('#productos').select2();
    </script>
@endsection

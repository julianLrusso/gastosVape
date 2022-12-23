@extends('layouts.main')

@section('title', 'Resumen general')
<?php
/** @var $producto \App\Models\Productos */
?>
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
                        <textarea class="form-control" name="descripcion" id="descripcion" cols="20" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="total">Total de gastos</label>
                        <input required name="total" id="total" type="number" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Agregar venta</button>

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
        let listadoProductos = [];

        // Escucha el botón agregar para agregar un producto
        botonAgregar.addEventListener('click', ()=>{
            if(selectProductos.value && cantidad.value && precio.value){
                let producto = {
                    'producto': selectProductos.options[selectProductos.selectedIndex].text,
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

        flete.addEventListener('change', () => calcularPrecioTotal(listadoProductos))

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
            listadoProductos.forEach(producto => {
                let div = document.createElement('div');
                div.classList.add('row');
                div.classList.add('border');
                div.classList.add('rounded');
                div.classList.add('p-2');
                div.classList.add('border-warning');
                div.innerHTML = `<div class="col-md-4">
                            <p>${producto.producto}</p>
                        </div>
                        <div class="col-md-3">
                            <p>Cantidad: ${producto.cantidad}</p>
                        </div>
                        <div class="col-md-3">
                            <p>Precio unitario: ${producto.precio}</p>
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
            let valorFlete = flete.value ? parseInt(flete.value) : 0;
            if (listadoProductos.length > 0){
                listadoProductos.forEach(producto => {
                    totalProvisorio += producto.cantidad * producto.precio;
                })
                totalProvisorio = totalProvisorio + valorFlete;
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

    </script>
@endsection

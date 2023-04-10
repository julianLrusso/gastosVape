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
        let totalUnitario = Number(Number(producto.precio).toFixed(2)) + Number(Number(precioFleteUnitario).toFixed(2));
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



/*const tablaProductos = document.getElementById('tablaProductos');

tablaProductos.addEventListener('click', (e) => {
    eliminarRowProducto(e.target);
})

function eliminarRowProducto(target){
    if (target.classList.contains('eliminarProd')) {
        console.log(target.dataset.idproducto);
        document.getElementById('rowProducto-'+target.dataset.idproducto).remove();
    }
}*/

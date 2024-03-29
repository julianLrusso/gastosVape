const botonAgregar = document.getElementById('botonAgregar')
const selectProductos = document.getElementById('productos');
const htmlProductos = document.getElementById('divProductos');
const cantidad = document.getElementById('cantidad');
const precio = document.getElementById('precio');
const total = document.getElementById('total');
const utilidadTotal = document.getElementById('utilidadTotal');
const json_productos = document.getElementById('json_productos');
const json_productosAntiguos = document.getElementById('productosAntiguos');
let listadoProductos = [];

cantidad.addEventListener('change', () => {
    let disponible = parseInt(selectProductos.options[selectProductos.selectedIndex].dataset.disponible);
    if( parseInt(cantidad.value) > disponible){
        cantidad.value = disponible;
    }
})

// Escucha el botón agregar para agregar un producto
botonAgregar.addEventListener('click', ()=>{
    if(selectProductos.value && cantidad.value && precio.value){
        let producto = {
            'producto': selectProductos.options[selectProductos.selectedIndex].text,
            'id': selectProductos.value,
            'cantidad': cantidad.value,
            'precio': precio.value,
            'disponible': selectProductos.options[selectProductos.selectedIndex].dataset.disponible,
            'factura': selectProductos.options[selectProductos.selectedIndex].dataset.factura,
            'precioAntiguo': selectProductos.options[selectProductos.selectedIndex].dataset.precio
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
                        <div class="col-md-2">
                            <p>Cantidad: ${producto.cantidad}</p>
                        </div>
                        <div class="col-md-4">
                            <p>Precio unitario: $${producto.precio} c/u</p>
                            <p><b>Total: $${producto.precio*producto.cantidad}</b></p>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-danger" data-id="${producto.id}">Borrar</button>
                        </div>`;
        htmlProductos.append(div);
    })
    calcularGananciasTotales(listadoProductos);
    setJsonProductos(listadoProductos);
    cambiarOption();
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
 * Calcula el total de las ganancias.
 * @param {array} listadoProductos
 */
function calcularGananciasTotales(listadoProductos){
    let totalProvisorio = 0;
    let totalUtilidad = 0;

    if (listadoProductos.length > 0){
        listadoProductos.forEach(producto => {
            totalProvisorio += (producto.cantidad * producto.precio);
            producto.utilidad = (producto.cantidad * producto.precio) - (producto.cantidad * producto.precioAntiguo);
            totalUtilidad += producto.utilidad;
        })

    }

    total.value = totalProvisorio;
    utilidadTotal.value = totalUtilidad;
}

/**
 * Transforma el listado en json y lo pone en el input
 * @param {array} listadoProductos
 */
function setJsonProductos(listadoProductos){
    json_productos.value = JSON.stringify(listadoProductos);
    json_productosAntiguos.value = JSON.stringify(productosAntiguos);
}

function cambiarOption(){
    let opciones = Array.from(selectProductos.options);
    opciones.forEach(option => {
        if(option.value){
            listadoProductos.forEach(producto => {
                if (option.value === producto.id && option.dataset.factura === producto.factura){
                    option.text = option.text + ' - Utilizado';
                }
            })
        }
    })
}

$('#productos').select2();
$('#cliente').select2();

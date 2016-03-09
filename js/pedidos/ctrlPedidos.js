var productos = new Array();
var promociones = new Array();
var datosComentario = new Array();
var total = 0;

function agregarProducto( id, producto, precio, id_lp ){
    var tupla = {'id':id,'producto':producto,'precio':precio, 'id_lp': id_lp, 'comentarios':'Sin comentarios.'}; 
    productos.push(tupla);
    total += precio;
    Materialize.toast(producto + ' agregado.', 2000,'toast-ok');
}

function agregarPromocion( id, nombre, precio ){
    var tupla = {'id':id,'nombre': nombre, 'precio':precio, 'comentarios':'Sin comentarios.'}; 
    promociones.push(tupla);
    total += precio;
    Materialize.toast('Promoción agregada.', 2000,'toast-ok');
}

function quitarProducto( posicion ){
    var tupla = productos[posicion];
    productos.splice(posicion,1);
    total -= tupla['precio'];
    listarCarrito();
    Materialize.toast(tupla['producto'] + ' eliminado correctamente.', 2000,'toast-error');
}

function quitarPromocion( posicion ){
    var tupla = promociones[posicion];
    promociones.splice(posicion,1);
    total -= tupla['precio'];
    listarCarrito();
    Materialize.toast('Promoción eliminada correctamente.', 2000,'toast-error');
}

function vaciarCarrito(){
    if (productos.length===0 && promociones.length===0){
        Materialize.toast('No hay nada en el carrito.', 2000,'toast-error');
    }else{
        productos = new Array();
        promociones = new Array();
        precio = 0;
        listarCarrito();
        Materialize.toast('Se vació correctamente el carrito.', 2000,'toast-ok');
    }
}

function comentarProducto(posicion){
    datosComentario.id = posicion;
    datosComentario.tipo = 'producto';
    $('#inputComentario').val(productos[posicion]['comentarios']);
    $('#modalComentarios').openModal();
}

function comentarPromocion(posicion){
    datosComentario.id = posicion;
    datosComentario.tipo = 'promocion';
    $('#inputComentario').val(promociones[posicion]['comentarios']);
    $('#modalComentarios').openModal();
}

function enviarComentario(){
    var posicion =  datosComentario.id;
    var tipo = datosComentario.tipo;
    var comentario = $('#inputComentario').val();
    
    if (comentario.lenght === 0){
        comentario = 'Sin comentarios.';
    }
    
    if (tipo === 'promocion'){
        promociones[posicion]['comentarios'] = comentario;
    }else{
        productos[posicion]['comentarios'] = comentario;
    }
    listarCarrito();
    Materialize.toast('Comentario adherido.', 2000,'toast-ok');
}

function confirmarPedido(){
    if (productos.length===0 && promociones.length===0){
        Materialize.toast('No hay nada en el carrito.', 2000,'toast-error');
    }else{
        $.ajax({
            data:  {'productosPedidos': productos, 'promocionesPedidas':promociones},
            url:   '/IAW-PF/clientes/alta_pedido',
            type:  'post',
            error: function(response){
                Materialize.toast('Se produjo un error en la conexión.', 5000,'toast-error');
                Materialize.toast('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                Materialize.toast('En 10 segundos el sistema reintentará automáticamente.', 10000,'toast-error');
                setTimeout(function(){ confirmarPedido(); }, 10000);    
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                if (respuesta['error'] === undefined){
                    productos = new Array();
                    promociones = new Array();
                    precio = 0;
                    listarConfirmados(respuesta['data']);
                    Materialize.toast('Pedidos y/o promociones confirmadas.', 2000,'toast-ok');
                }else{
                    var error = respuesta['error'];
                    vaciarCarrito();
                    listarCarrito();
                    Materialize.toast('Error: ' + error, 10000,'toast-error');
                }
            }
        });
    }
}
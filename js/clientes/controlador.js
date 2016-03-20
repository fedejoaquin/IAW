var cliente = {
    
productos : [],
promociones : [],
datosComentario : [],
total : 0,

vaciar_carrito : function (){
    if (cliente.productos.length===0 && cliente.promociones.length===0){
        auxiliar.mensaje('No hay nada en el carrito.', 2500,'toast-error');
    }else{
        cliente.productos = new Array();
        cliente.promociones = new Array();
        cliente.total = 0;
        cliente_vista.listar_carrito();
        auxiliar.mensaje('Se vació correctamente el carrito.', 2500,'toast-ok');
    }
    
}, //FIN VACIAR CARRITO

enviar_comentario : function (){
    var posicion =  cliente.datosComentario.id;
    var tipo = cliente.datosComentario.tipo;
    var comentario = $('#inputComentario').val();
    
    if (comentario.lenght === 0){
        comentario = 'Sin comentarios.';
    }
    
    if (tipo === 'promocion'){
        cliente.promociones[posicion]['comentarios'] = comentario;
    }else{
        cliente.productos[posicion]['comentarios'] = comentario;
    }
    cliente_vista.listar_carrito();
    auxiliar.mensaje('Comentario adherido.', 2500,'toast-ok');
    
}, //FIN ENVIAR_COMENTARIO

confirmar_pedido : function (){
    if (cliente.productos.length===0 && cliente.promociones.length===0){
        auxiliar.mensaje('No hay nada en el carrito.', 2500,'toast-error');
    }else{
        auxiliar.espera.lanzar();
        $.ajax({
            data:  {'productosPedidos': cliente.productos, 'promocionesPedidas': cliente.promociones},
            url:   '/IAW-PF/clientes/alta_pedido',
            type:  'post',
            error: function(response){
                auxiliar.espera.detener();
                auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                auxiliar.mensaje('En 10 segundos el sistema reintentará automáticamente.', 10000,'toast-error');
                setTimeout(function(){ confirmarPedido(); }, 10000);    
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                auxiliar.espera.detener();
                if (respuesta['error'] === undefined){
                    cliente.productos = new Array();
                    cliente.promociones = new Array();
                    cliente.total = 0;
                    cliente_vista.listar_confirmados(respuesta['data']);
                    auxiliar.mensaje('Pedidos y/o promociones confirmadas.', 2500,'toast-ok');
                }else{
                    auxiliar.mensaje(respuesta['error'], 5000,'toast-error');
                }
            }
        });
    }
    
}, //FIN CONFIRMAR PEDIDO

control_ajax : function(){
    $.ajax({
        data:  {},
        url:   '/IAW-PF/clientes/estado_mesa',
        type:  'post',
        success: function (response){
            var respuesta = JSON.parse(response);
            if (respuesta['error'] === undefined){
                cliente_vista.listar_confirmados(respuesta['data']);
            }
        }
    });
    setTimeout("cliente.control_ajax()",10000);
    
}, //FIN CONTROL AJAX

producto : {
    agregar : function( id, producto, precio, id_lp ){
        var tupla = {'id':id,'producto':producto,'precio':precio, 'id_lp': id_lp, 'comentarios':'Sin comentarios.'}; 
        cliente.productos.push(tupla);
        cliente.total += precio;
        auxiliar.mensaje(producto + ' agregado.', 2000,'toast-ok');
    },
    
    quitar : function( posicion ){
        var tupla = cliente.productos[posicion];
        cliente.productos.splice(posicion,1);
        cliente.total -= tupla['precio'];
        cliente_vista.listar_carrito();
        auxiliar.mensaje(tupla['producto'] + ' eliminado correctamente.', 2000,'toast-error');
    },
    
    comentar : function (posicion){
        cliente.datosComentario.id = posicion;
        cliente.datosComentario.tipo = 'producto';
        cliente_vista.comentar(cliente.productos[posicion]['comentarios']);
    }

}, //FIN PRODUCTO

promocion : {
    agregar : function( id, nombre, precio ){
        var tupla = {'id':id,'nombre': nombre, 'precio':precio, 'comentarios':'Sin comentarios.'}; 
        cliente.promociones.push(tupla);
        cliente.total += precio;
        auxiliar.mensaje('Promoción agregada.', 2000,'toast-ok');
    },
    
    quitar : function ( posicion ){
        var tupla = cliente.promociones[posicion];
        cliente.promociones.splice(posicion,1);
        cliente.total -= tupla['precio'];
        cliente_vista.listar_carrito();
        auxiliar.mensaje('Promoción eliminada correctamente.', 2000,'toast-error');
    },
    
    comentar : function(posicion){
        cliente.datosComentario.id = posicion;
        cliente.datosComentario.tipo = 'promocion';
        cliente_vista.comentar(cliente.promociones[posicion]['comentarios']);
    }
    
}//FIN PROMOCION

}//FIN CLIENTES

$( document ).ready(function(){
    cliente.control_ajax();
});

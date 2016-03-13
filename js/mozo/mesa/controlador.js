$( document ).ready(function(){
    mozo_mesa.control_ajax();
});
var mozo_mesa = {

productos : [],
promociones : [],
datosComentario : [],
total : 0,



vaciar_carrito : function (){
    if (mozo_mesa.productos.length===0 && mozo_mesa.promociones.length===0){
        Materialize.toast('No hay nada en el carrito.', 2000,'toast-error');
    }else{
       mozo_mesa.productos = new Array();
       mozo_mesa.promociones = new Array();
       mozo_mesa.precio = 0;
       mozo_mesa_vista.listar_carrito();
       mozo_mesa_vista.mensaje('Se vació correctamente el carrito.', 2000,'toast-ok');
    }
},

enviarComentario : function (){
    var posicion =  mozo_mesa.datosComentario.id;
    var tipo = mozo_mesa.datosComentario.tipo;
    var comentario = $('#inputComentario').val();
    
    if (tipo === 'promocion'){
        mozo_mesa.promociones[posicion]['comentarios'] = comentario;
    }else{
        mozo_mesa.productos[posicion]['comentarios'] = comentario;
    }
    mozo_mesa_vista.listar_carrito();
    mozo_mesa_vista.mensaje('Comentario adherido.', 2000,'toast-ok');
},

confirmar_pedido : function (){
    if (mozo_mesa.productos.length===0 && mozo_mesa.promociones.length===0){
        mozo_mesa_vista.mensaje('No hay nada en el carrito.', 2000,'toast-error');
    }else{
        id_mesa = $('#id_mesa').val();
        $.ajax({
            data:  {'productosPedidos': mozo_mesa.productos, 'promocionesPedidas':mozo_mesa.promociones,'id_mesa':id_mesa},
            url:   '/IAW-PF/mozo/altaPedidoMozo',
            type:  'post',
            error: function(response){
                mozo_mesa_vista.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                mozo_mesa_vista.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                mozo_mesa_vista.mensaje('En 10 segundos el sistema reintentará automáticamente.', 10000,'toast-error');
                setTimeout(function(){ confirmar_pedido(); }, 10000);  
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                if (respuesta['error'] === undefined){
                    mozo_mesa.productos = new Array();
                    mozo_mesa.promociones = new Array();
                    mozo_mesa.precio = 0;
                    mozo_mesa_vista.listar_confirmados(respuesta['data']);
                    mozo_mesa_vista.mensaje('Pedidos y/o promociones confirmadas.', 2000,'toast-ok');
                }else{
                    var error = respuesta['error'];
                    mozo_mesa.vaciar_carrito();
                    mozo_mesa_vista.listar_carrito();
                    mozo_mesa_vista.mensaje('Error: ' + error, 10000,'toast-error');
                }
            }
        });
    }
},



vincular_cliente : function (){
    codigo = $('#inputCodigo').val();
    id_mesa = $('#id_mesa').val();
    if (codigo.length !== 6){
        mozo_mesa_vista.mensaje("Error: El codigo ingresado contiene longitud incorrecta.",2000,"toast-error");
        
    }else{
        $.ajax({
            data:  {'codigoCliente': codigo,'id_mesa':id_mesa},
            url:   '/IAW-PF/mozo/vincularCliente',
            type:  'post',
            error: function(response){
                mozo_mesa_vista.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                mozo_mesa_vista.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                mozo_mesa_vista.mensaje('En 5 segundos el sistema reintentará automáticamente.', 10000,'toast-error');
                setTimeout("mozo_mesa.validarCliente()", 5000);    
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                if (respuesta['error'] === undefined){
                    $('#inputCodigo').val('');
                    mozo_mesa_vista.mensaje("Cliente vinculado.",2000,"toast-error");
                }else{
                    var error = respuesta['error'];
                     mozo_mesa_vista.mensaje("Error: "+error,2000,"toast-error");
                }
            }
        });
    }
},
producto : {
    agregar : function( id, producto, precio, id_lp ){
        var tupla = {'id':id,'producto':producto,'precio':precio, 'id_lp': id_lp, 'comentarios':'Sin comentarios.'}; 
        mozo_mesa.productos.push(tupla);
        mozo_mesa.total += precio;
        mozo_mesa_vista.mensaje(producto + ' agregado.', 2000,'toast-ok');
        mozo_mesa_vista.listar_carrito();
    },
    
    quitar : function( posicion ){
        var tupla = mozo_mesa.productos[posicion];
        mozo_mesa.productos.splice(posicion,1);
        mozo_mesa.total -= tupla['precio'];
        mozo_mesa_vista.listar_carrito();
        mozo_mesa_vista.mensaje(tupla['producto'] + ' eliminado correctamente.', 2000,'toast-error');
    },
    
    comentar : function (posicion){
        mozo_mesa.datosComentario.id = posicion;
        mozo_mesa.datosComentario.tipo = 'producto';
        mozo_mesa_vista.comentar(mozo_mesa.productos[posicion]['comentarios']);
    }

}, //FIN PRODUCTO

promocion : {
    agregar : function( id, nombre, precio ){
        var tupla = {'id':id,'nombre': nombre, 'precio':precio, 'comentarios':'Sin comentarios.'}; 
        mozo_mesa.promociones.push(tupla);
        mozo_mesa.total += precio;
        mozo_mesa_vista.mensaje('Promoción agregada.', 2000,'toast-ok');
    },
    
    quitar : function ( posicion ){
        var tupla = mozo_mesa.promociones[posicion];
        mozo_mesa.promociones.splice(posicion,1);
        mozo_mesa.total -= tupla['precio'];
        mozo_mesa_vista.listar_carrito();
        mozo_mesa_vista.mensaje('Promoción eliminada correctamente.', 2000,'toast-error');
    },
    
    comentar : function(posicion){
        mozo_mesa.datosComentario.id = posicion;
        mozo_mesa.datosComentario.tipo = 'promocion';
        mozo_mesa_vista.comentar(mozo_mesa.promociones[posicion]['comentarios']);
    }
    
},

    control_ajax : function(){
        id_mesa = $('#id_mesa').val();
        $.ajax({
            data:  {'id_mesa':id_mesa},
            url:   '/IAW-PF/mozo/estado_mesa',
            type:  'post',
            error: function(response){
              mozo_mesa_vista.mensaje("Error: ",3000,"toast-error");  
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                if (respuesta['error'] === undefined){
                    mozo_mesa_vista.listar_confirmados(respuesta['data']);
                }
            }
        });
        setTimeout("mozo_mesa.control_ajax()",8000);
    }
};


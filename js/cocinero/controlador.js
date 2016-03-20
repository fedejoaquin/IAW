var cocinero = {

checkPedidos : function (){
    $.ajax({
        data:  {},
        url:   '/IAW-PF/cocinero/pedidos_activos',
        type:  'post',
        error: function(response){
            auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
            auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
            auxiliar.mensaje('No se puede chequear los pedidos en este momento.', 5000,'toast-error');
        },
        success: function (response){
            var respuesta = JSON.parse(response);
            if (respuesta['error'] === undefined){
                datos = respuesta['data'];
                cocinero_vista.set_pendientes(datos['productosPendientes'].length + datos['promocionesPendientes'].length);
                cocinero_vista.productos.listarPendientes(datos['productosPendientes']);
                cocinero_vista.productos.listarProcesados(datos['productosProcesados']);
                cocinero_vista.promociones.listarPendientes(datos['promocionesPendientes']);
                cocinero_vista.promociones.listarProcesadas(datos['promocionesProcesadas']);
            }else{
                auxiliar.mensaje('El servidor respondió la solicitud y notificó error.', 5000,'toast-error');
            }  
        }
    });
    setTimeout('cocinero.checkPedidos()', 30000); 
    
}, //FIN CHECK PEDIDOS

productos : {
    ver : function(id){
        auxiliar.espera.lanzar();
        $.ajax({
            data:  {'id':id },
            url:   '/IAW-PF/cocinero/info_pedido_producto',
            type:  'post',
            error: function(response){
                auxiliar.espera.detener();
                auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                auxiliar.mensaje('No se puede visualizar el pedido en este momento.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                auxiliar.espera.detener();
                if (respuesta['error'] === undefined){
                    datos = respuesta['data'];
                    cocinero_vista.productos.ver(datos);
                }else{
                    auxiliar.mensaje(respuesta['error'], 5000,'toast-error');
                }  
            }
        });
    },
    
    procesar : function(id){
        auxiliar.espera.lanzar();
        $.ajax({
            data:  {'id' : id },
            url:   'http://localhost/IAW-PF/cocinero/procesar_producto',
            type:  'post',
            error: function(response){
                auxiliar.espera.detener();
                auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                auxiliar.mensaje('No se puede procesar el producto en este momento.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                auxiliar.espera.detener();
                if (respuesta['error'] === undefined){
                    cocinero_vista.productos.procesar(id);
                    auxiliar.mensaje('Producto procesado exitosamente.', 2500, 'toast-ok');
                }else{
                    auxiliar.mensaje(respuesta['error'], 5000,'toast-error');
                }
            }
        });
    },
    
    finalizar : function(id){
        auxiliar.espera.lanzar();
        $.ajax({
            data:  {'id' : id },
            url:   'http://localhost/IAW-PF/cocinero/finalizar_producto',
            type:  'post',
            error: function(response){
                auxiliar.espera.detener();
                auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                auxiliar.mensaje('No se puede finalizar el producto en este momento.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                auxiliar.espera.detener();
                if (respuesta['error'] === undefined){
                    cocinero_vista.productos.finalizar(id);
                    auxiliar.mensaje('Producto finalizado exitosamente.', 2500, 'toast-ok');
                }else{
                    auxiliar.mensaje(respuesta['error'], 5000,'toast-error');
                }
            }
        });
    }
    
}, //FIN PRODUCTOS

promociones : {
    ver : function(id){
        auxiliar.espera.lanzar();
        $.ajax({
            data:  {'id':id },
            url:   '/IAW-PF/cocinero/info_pedido_promocion',
            type:  'post',
            error: function(response){
                auxiliar.espera.detener();
                auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                auxiliar.mensaje('No se puede visualizar el pedido en este momento.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                auxiliar.espera.detener();
                if (respuesta['error'] === undefined){
                    datos = respuesta['data'];
                    cocinero_vista.promociones.ver(datos);
                }else{
                    auxiliar.mensaje(respuesta['error'], 5000,'toast-error');
                }  
            }
        });
    },
    
    procesar : function(id){
        auxiliar.espera.lanzar();
        $.ajax({
            data:  {'id' : id },
            url:   'http://localhost/IAW-PF/cocinero/procesar_promocion',
            type:  'post',
            error: function(response){
                auxiliar.espera.detener();
                auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                auxiliar.mensaje('No se puede procesar la promoción en este momento.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                auxiliar.espera.detener();
                if (respuesta['error'] === undefined){
                    cocinero_vista.promociones.procesar(id);
                    auxiliar.mensaje('Promoción procesada exitosamente.', 2500, 'toast-ok');
                }else{
                    auxiliar.mensaje(respuesta['error'], 5000,'toast-error');
                }
            }
        });
    },
    
    finalizar : function(id){
        auxiliar.espera.lanzar();
        $.ajax({
            data:  {'id' : id },
            url:   'http://localhost/IAW-PF/cocinero/finalizar_promocion',
            type:  'post',
            error: function(response){
                auxiliar.espera.detener();
                auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                auxiliar.mensaje('No se puede finalizar la promoción en este momento.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                auxiliar.espera.detener();
                if (respuesta['error'] === undefined){
                    cocinero_vista.promociones.finalizar(id);
                    auxiliar.mensaje('Promoción finalizada exitosamente.', 2500, 'toast-ok');
                }else{
                    auxiliar.mensaje(respuesta['error'], 5000,'toast-error');
                }
            }
        });
    }
    
}, //FIN PROMOCIONES

} //FIN COCINERO

$( document ).ready(function(){
    cocinero.checkPedidos();
});
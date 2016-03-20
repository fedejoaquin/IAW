var mozo = {
    
productos : [],
promociones : [],
datosComentario : [],
total : 0,

carrito : {
    
    pre_confirmar : function(){
        if (mozo.productos.length===0 && mozo.promociones.length===0){
            auxiliar.mensaje('No hay nada en el carrito.', 2500,'toast-error');
        }else{
            auxiliar.espera.lanzar();
            $.ajax({
                data:  {},
                url:   '/IAW-PF/mozo/mesas_asociadas',
                type:  'post',
                error: function(response){
                    auxiliar.espera.detener();
                    auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                    auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                    auxiliar.mensaje('La confirmación del pedido no se realizó correctamente.', 5000,'toast-error');
                },
                success: function (response){
                    var respuesta = JSON.parse(response);
                    auxiliar.espera.detener();
                    if (respuesta['error'] === undefined){
                        mozo_vista.carrito.pre_confirmar(respuesta['data']);
                    }else{
                        auxiliar.mensaje(respuesta['error'], 5000, 'toast-error');
                    }
                }
            });
        }
    },
    
    post_confirmar : function(){
        var id_mesa = $('#selectMesa').val();
        
        if (id_mesa === '-1'){
            auxiliar.mensaje('Debe seleccionar una mesa para confirmar el pedido.', 2500,'toast-error');
        }else{
            auxiliar.espera.lanzar();
            $.ajax({
                data:  {'id_mesa': id_mesa, 'productosPedidos': mozo.productos, 'promocionesPedidas': mozo.promociones},
                url:   '/IAW-PF/mozo/alta_pedido',
                type:  'post',
                error: function(response){
                    auxiliar.espera.detener();
                    auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                    auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                    auxiliar.mensaje('No se puede realizar la confirmación en este momento.', 5000,'toast-error');
                },
                success: function (response){
                    var respuesta = JSON.parse(response);
                    auxiliar.espera.detener();
                    if (respuesta['error'] === undefined){
                        mozo.productos = [];
                        mozo.promociones = [];
                        mozo.total = 0;
                        mozo_vista.carrito.post_confirmar();
                        auxiliar.mensaje('Pedidos y/o promociones confirmadas.', 2500,'toast-ok');
                    }else{
                        auxiliar.mensaje(respuesta['error'], 5000,'toast-error');
                    }
                }
            });
        }
    },
    
    vaciar : function(){
        if (mozo.productos.length===0 && mozo.promociones.length===0){
            auxiliar.mensaje('No hay nada en el carrito.', 2500,'toast-error');
        }else{
            mozo.productos = new Array();
            mozo.promociones = new Array();
            mozo.total = 0;
            mozo_vista.carrito.listar();
            auxiliar.mensaje('Se vació correctamente el carrito.', 2500,'toast-ok');
        }
    },
    
    listar : function(){
        mozo_vista.carrito.listar();
    },
    
    productos : {
        
        agregar : function(id, producto, precio, id_lp ){
            var tupla = {'id':id,'producto':producto,'precio':precio, 'id_lp': id_lp, 'comentarios':'Sin comentarios.'}; 
            mozo.productos.push(tupla);
            mozo.total += precio;
            auxiliar.mensaje(producto + ' agregado.', 2500,'toast-ok');
        },
        
        quitar : function(posicion){
            var tupla = mozo.productos[posicion];
            mozo.productos.splice(posicion,1);
            mozo.total -= tupla['precio'];
            mozo_vista.carrito.listar();
            auxiliar.mensaje(tupla['producto'] + ' eliminado correctamente.', 2500,'toast-error');  
        },
        
        comentar : function (posicion){
            mozo.datosComentario.id = posicion;
            mozo.datosComentario.tipo = 'producto';
            mozo_vista.comentar(mozo.productos[posicion]['comentarios']);
        }
        
    }, // FIN PRODUCTOS
    
    promociones : {
        agregar : function(id, nombre, precio){
            var tupla = {'id':id,'nombre': nombre, 'precio':precio, 'comentarios':'Sin comentarios.'}; 
            mozo.promociones.push(tupla);
            mozo.total += precio;
            auxiliar.mensaje('Promoción agregada.', 2500,'toast-ok');
        },
        
        quitar : function(posicion){
            var tupla = mozo.promociones[posicion];
            mozo.promociones.splice(posicion,1);
            mozo.total -= tupla['precio'];
            mozo_vista.carrito.listar();
            auxiliar.mensaje('Promoción eliminada correctamente.', 2500,'toast-error');  
        },
        
        comentar : function (posicion){
            mozo.datosComentario.id = posicion;
            mozo.datosComentario.tipo = 'promocion';
            mozo_vista.comentar(mozo.promociones[posicion]['comentarios']);
        }
    } // FIN PROMOCIONES
    
}, //FIN CARRITO

enviar_comentario : function(){
    var posicion =  mozo.datosComentario.id;
    var tipo = mozo.datosComentario.tipo;
    var comentario = $('#inputComentario').val();
    
    if (comentario.lenght === 0){
        comentario = 'Sin comentarios.';
    }
    
    if (tipo === 'promocion'){
        mozo.promociones[posicion]['comentarios'] = comentario;
    }else{
        mozo.productos[posicion]['comentarios'] = comentario;
    }
    mozo_vista.enviar_comentario();
    mozo_vista.carrito.listar();
    auxiliar.mensaje('Comentario adherido.', 2500,'toast-ok');
    
},//FIN ENVIAR_COMENTARIO

notificaciones : {
    
    check : function(){
        $.ajax({
            data:  {},
            url:   '/IAW-PF/mozo/mis_notificaciones',
            type:  'post',
            success: function (response){
                var respuesta = JSON.parse(response);
                mozo_vista.notificaciones.listar(respuesta['data']);
            }
        });
    },
    
    marcar_visto : function(id){
        auxiliar.espera.lanzar();
        $.ajax({
            data:  {'id': id },
            url:   '/IAW-PF/mozo/eliminar_notificacion',
            type:  'post',
            error: function(response){
                auxiliar.espera.detener();
                auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                auxiliar.mensaje('La notificación no puede eliminarse en este momento.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                auxiliar.espera.detener();
                if (respuesta['error'] === undefined){
                    mozo_vista.notificaciones.marcar_visto(id);
                    auxiliar.mensaje('Notificación eliminada exitosamente.', 2500, 'toast-ok');
                }else{
                    auxiliar.mensaje(respuesta['error'], 5000,'toast-error');
                }
            }
        });
    }

}, //FIN NOTIFICACIONES

vincular : {
    
    preAlta : function(id){
        mozo_vista.vincular.preAlta(id);
    },

    postAlta: function (){
        id_mesa = $('#inputMesaVinculacion').val();
        codigo = $('#inputVinculacion').val();
        
        if (codigo.length !== 6){
            auxiliar.mensaje("El código ingresado es incorrecto.",2500,"toast-error");
        }else{
            auxiliar.espera.lanzar();
            $.ajax({
                data:  {'id_mesa' : id_mesa, 'id_cliente' : codigo },
                url:   '/IAW-PF/mozo/vincular_cliente',
                type:  'post',
                error: function(response){
                    auxiliar.espera.detener();
                    auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                    auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                    auxiliar.mensaje('La vinculación del cliente no se puede realizar en este momento.', 5000,'toast-error'); 
                },
                success: function (response){
                    var respuesta = JSON.parse(response);
                    auxiliar.espera.detener();
                    if (respuesta['error'] === undefined){
                        mozo_vista.vincular.postAlta();
                        auxiliar.mensaje("Cliente vinculado exitosamente.",2500,"toast-ok");
                    }else{
                        auxiliar.mensaje(respuesta['error'],5000,"toast-error");
                    }
                }
            });
        }
    }
    
}, //FIN VINCULAR

mesa : {
    
    check : function(){
        $.ajax({
            data:  {},
            url:   '/IAW-PF/mozo/mesas_asociadas',
            type:  'post',
            success: function (response){
                var respuesta = JSON.parse(response);
                mozo_vista.mesa.listar(respuesta['data']);
            }
        });
    },
    
    ver : function(id){
        auxiliar.espera.lanzar();
        $.ajax({
            data:  {'id_mesa' : id },
            url:   '/IAW-PF/mozo/estado_mesa',
            type:  'post',
            error : function (response){
                auxiliar.espera.detener();
                auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                auxiliar.mensaje('La información de la mesa no se puede visualizar en este momento.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                auxiliar.espera.detener();
                if (respuesta['error'] === undefined){
                    mozo_vista.mesa.ver(respuesta['data']);
                }else{
                    auxiliar.mensaje(respuesta['error'], 5000, 'toast-error');
                }
            }
        });
        
    },
    
    cierre_parcial : function(id){
        auxiliar.espera.lanzar();
        $.ajax({
            data:  {'id_mesa' : id },
            url:   '/IAW-PF/mozo/cierre_parcial',
            type:  'post',
            error : function (response){
                auxiliar.espera.detener();
                auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                auxiliar.mensaje('El cierre parcial no se puede realizar en este momento.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                auxiliar.espera.detener();
                if (respuesta['error'] === undefined){
                    mozo_vista.mesa.cierre_parcial(id);
                    auxiliar.mensaje("Cierre parcial exitoso.",2500, 'toast-ok');
                }else{
                    auxiliar.mensaje(respuesta['error'], 5000, 'toast-error');
                }
            }
        });
        
    },
    
    cierre_total : function(id){
        auxiliar.espera.lanzar();
        $.ajax({
            data:  {'id_mesa' : id },
            url:   '/IAW-PF/mozo/cierre_total',
            type:  'post',
            error : function (response){
                auxiliar.espera.detener();
                auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                auxiliar.mensaje('El cierre total no se puede realizar en este momento.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                auxiliar.espera.detener();
                if (respuesta['error'] === undefined){
                    mozo_vista.mesa.cierre_total(id);
                    auxiliar.mensaje("Cierre total exitoso. Se tramita la cuenta.",2500, 'toast-ok');
                }else{
                    auxiliar.mensaje(respuesta['error'], 5000, 'toast-error');
                }
            }
        });
        
    },
    
}, //FIN MESA

checkDatosDinamicos : function(){
    mozo.notificaciones.check();
    mozo.mesa.check();
    setTimeout("mozo.checkDatosDinamicos()", 30000);
},

}//FIN MOZO

$( document ).ready(function(){
    mozo.checkDatosDinamicos();
});
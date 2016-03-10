var promociones = {

eliminar : function(id){
   $.ajax({
        data:  {'id_promocion': id },
        url:   '/IAW-PF/promociones/eliminar',
        type:  'post',
        error: function(response){
            promociones_vista.mensaje('Se produjo un error en la conexión.', 2500,'toast-error');
            promociones_vista.mensaje('El servidor no está respondiendo nuestra solicitud.', 2500,'toast-error');
            promociones_vista.mensaje('La promoción no puede ser eliminada en este momento.', 2500,'toast-error');
        },
        success: function (response){
            var respuesta = JSON.parse(response);
            if (respuesta['error'] === undefined){
                promociones_vista.eliminar(id);
                promociones_vista.mensaje('La promoción fue eliminada exitosamente.', 2500,'toast-ok'); 
            }else{
                promociones_vista.mensaje(respuesta['error'], 2500,'toast-error');
            }
        }
    });
},

cambiarDatos : function(){
    var id = $('#idPromocion').val();
    var precio_nuevo = $('#precioPromocion').val();
    var nombre_nuevo = $('#nombrePromocion').val();
    
    if ( isNaN(precio_nuevo) || precio_nuevo.length===0 ){
        promociones_vista.mensaje('El precio ingresado es incorrecto. No coloque "$".', 2500, 'toast-error');
    }else{
        if (nombre_nuevo.length <= 5 ){
            promociones_vista.mensaje('El nombre ingresado debe contener al menos 5 caracteres.', 2500, 'toast-error');
        }else{
             $.ajax({
                data:  {'id': id, 'nombre': nombre_nuevo, 'precio': precio_nuevo},
                url:   '/IAW-PF/promociones/cambiar_datos',
                type:  'post',
                error: function(response){
                    promociones_vista.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                    promociones_vista.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                    promociones_vista.mensaje('Los datos no pueden ser editados en este momento.', 5000,'toast-error');
                },
                success: function (response){
                    var respuesta = JSON.parse(response);
                    if (respuesta['error'] === undefined){
                        promociones_vista.mensaje('Los datos fueron modificados exitosamente.', 2500,'toast-ok'); 
                    }else{
                        promociones_vista.mensaje(respuesta['error'], 2500,'toast-error');
                    }
                }
            });
       }
    } 
},

producto : {
    preAlta : function(){
        promociones_vista.producto.reset_modal();
        promociones_vista.producto.abrir_modal();
    },
    
    postAlta : function(){
        var id_producto = $('#selectAltaProducto').val();
        var id_promocion = $('#idPromocion').val();

        if (id_producto !== '-1'){
            $.ajax({
                    data:  {'id_promocion': id_promocion, 'id_producto': id_producto },
                    url:   '/IAW-PF/promociones/alta_producto',
                    type:  'post',
                    error: function(response){
                        promociones_vista.mensaje('Se produjo un error en la conexión.', 2500,'toast-error');
                        promociones_vista.mensaje('El servidor no está respondiendo nuestra solicitud.', 2500,'toast-error');
                        promociones_vista.mensaje('No se puede modificar la promoción en este momento.', 2500,'toast-error');
                    },
                    success: function (response){
                        var respuesta = JSON.parse(response);
                        if (respuesta['error'] === undefined){
                            promociones_vista.producto.alta(respuesta['data']);
                            promociones_vista.mensaje('Promoción modificada exitosamente.', 2500,'toast-ok');
                        }else{
                            promociones_vista.mensaje(respuesta['error'], 2500,'toast-error');
                        }
                    }

            });
        }else{
            promociones_vista.mensaje('Debe seleccionar un producto.', 2500,'toast-error');   
        }
    },
    
    autocompletar : function (){
        var texto = $('#inputBusqueda').val();
        if (texto.length > 2){
            $.ajax({
                data:  { 'texto' : texto },
                url:   '/IAW-PF/promociones/autocompletar',
                type:  'post',
                error: function(response){
                    menu_vista.mensaje('Se produjo un error en la conexión.', 2500,'toast-error');
                    menu_vista.mensaje('El servidor no está respondiendo nuestra solicitud.', 2500,'toast-error');
                    menu_vista.mensaje('No se puede realizar la búsqueda en este momento.', 2500,'toast-error');
                },
                success: function (response){
                    var respuesta = JSON.parse(response);
                    if (respuesta['error'] === undefined ){
                        promociones_vista.producto.autocompletar(respuesta['data']);
                    }
                }

            });
        }
    },
    eliminar : function(id){
        $.ajax({
                data:  {'id': id },
                url:   '/IAW-PF/promociones/eliminar_producto',
                type:  'post',
                error: function(response){
                    promociones_vista.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                    promociones_vista.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                    promociones_vista.mensaje('El producto no puede ser eliminado en este momento.', 5000,'toast-error');
                },
                success: function (response){
                    var respuesta = JSON.parse(response);
                    if (respuesta['error'] === undefined){
                        promociones_vista.producto.eliminar(id);
                        promociones_vista.mensaje('Producto eliminado exitosamente.', 2500,'toast-ok'); 
                    }else{
                        promociones_vista.mensaje('Se produjo un error al intentar eliminar el producto.', 2500,'toast-error');
                    }
                }
        });
    }
    
},//FIN PRODUCTO

promocion : {
    
    preAlta : function(){
        promociones_vista.promocion.reset_modal();
        promociones_vista.promocion.abrir_modal();
    },
    
    postAlta : function(){
        var nombre_promocion = $('#nombrePromocion').val();
        var precio_promocion = $('#precioPromocion').val();

        if ( isNaN(precio_promocion) || precio_promocion.length===0 ){
            promociones_vista.mensaje('El precio ingresado es incorrecto. No coloque "$".', 2500, 'toast-error');
        }else{
            if (nombre_promocion.length <= 10 ){
                promociones_vista.mensaje('El nombre ingresado debe contener al menos 10 caracteres.', 2500, 'toast-error');
            }else{
                $.ajax({
                        data:  {'nombre_promocion': nombre_promocion, 'precio_promocion': precio_promocion },
                        url:   '/IAW-PF/promociones/alta',
                        type:  'post',
                        error: function(response){
                            promociones_vista.mensaje('Se produjo un error en la conexión.', 2500,'toast-error');
                            promociones_vista.mensaje('El servidor no está respondiendo nuestra solicitud.', 2500,'toast-error');
                            promociones_vista.mensaje('No se puede dar de alta la promoción en este momento.', 2500,'toast-error');
                        },
                        success: function (response){
                            var respuesta = JSON.parse(response);
                            if (respuesta['error'] === undefined){
                                promociones_vista.promocion.alta(respuesta['data']);
                                promociones_vista.mensaje('Promoción creada exitosamente.', 2500,'toast-ok');
                            }else{
                                promociones_vista.mensaje(respuesta['error'], 2500,'toast-error');
                            }
                        }

                });
            } 
        }
    }
    
} //FIN PROMOCION

}//FIN MENU
var listaprecios = {

preAlta : function(){
    listaprecios_vista.preAlta();
    
}, //FIN PREALTA

postAlta : function(){
    nombre = $('#nombreLista').val();
    
    if (nombre.length < 5 ){
       auxiliar.mensaje('El nombre ingresado debe contener al menos 5 caracteres.',2500,'toast-error');
    }else{
        auxiliar.espera.lanzar();
        $.ajax({
            data:  {'nombre': nombre },
            url:   '/IAW-PF/preciolistas/alta',
            type:  'post',
            error: function(response){
                auxiliar.espera.detener();
                auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                auxiliar.mensaje('La lista de precio no puede ser creada en este momento.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                auxiliar.espera.detener();
                if (respuesta['error'] === undefined){
                    listaprecios_vista.postAlta(respuesta['data']);
                    auxiliar.mensaje('La lista de precio fue creada exitosamente.', 2500,'toast-ok'); 
                }else{
                    auxiliar.mensaje(respuesta['error'], 5000,'toast-error');
                }
            }
        });
    }
    
},//FIN POSTALTA

eliminar : function(id){
    auxiliar.espera.lanzar();
    $.ajax({
        data:  {'id_menu': id },
        url:   '/IAW-PF/menu/eliminar',
        type:  'post',
        error: function(response){
            auxiliar.espera.detener();
            auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
            auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
            auxiliar.mensaje('El menú no puede ser eliminado en este momento.', 5000,'toast-error');
        },
        success: function (response){
            var respuesta = JSON.parse(response);
            auxiliar.espera.detener();
            if (respuesta['error'] === undefined){
                menu_vista.eliminar(id);
                auxiliar.mensaje('El menú fue eliminado exitosamente.', 2500,'toast-ok'); 
            }else{
                auxiliar.mensaje(respuesta['error'], 5000,'toast-error');
            }
        }
    });
    
},// FIN ELIMINAR

cambiarNombre : function(){
    var id = $('#idMenu').val();
    var nombre_nuevo = $('#nombreMenu').val();
    
    if (nombre_nuevo.length <= 5 ){
        auxiliar.mensaje('El nombre ingresado debe contener al menos 5 caracteres.', 2500, 'toast-error');
    }else{
        auxiliar.espera.lanzar();
        $.ajax({
            data:  {'id': id, 'nombre': nombre_nuevo},
            url:   '/IAW-PF/menu/cambiar_nombre',
            type:  'post',
            error: function(response){
                auxiliar.espera.detener();
                auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                auxiliar.mensaje('El nombre no puede ser editado en este momento.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                auxiliar.espera.detener();
                if (respuesta['error'] === undefined){
                    auxiliar.mensaje('El nombre fue modificado exitosamente.', 2500,'toast-ok'); 
                }else{
                    auxiliar.mensaje(respuesta['error'], 5000,'toast-error');
                }
            }
        });
    }
    
},// FIN CAMBIAR NOMBRE

producto : {
    preAlta : function(){
        menu_vista.producto.reset_modal();
        menu_vista.producto.abrir_modal();
    },
    
    seleccionaAlta : function (){
        var id_producto = $('#selectAltaProducto').val();
        if (id_producto !== '-1'){
            auxiliar.espera.lanzar();
            $.ajax({
                data:  {'id': id_producto },
                url:   '/IAW-PF/menu/info_producto',
                type:  'post',
                error: function(response){
                    auxiliar.espera.detener();
                    auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                    auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                    auxiliar.mensaje('No se puede obtener info del producto en este momento.', 5000,'toast-error');
                },
                success: function (response){
                    var respuesta = JSON.parse(response);
                    auxiliar.espera.detener();
                    if (respuesta['error'] === undefined){
                        menu_vista.producto.autocompletar_info(respuesta['data']);
                    }else{
                        auxiliar.mensaje(respuesta['error'], 5000,'toast-error');
                    }
                }
            });
        }
    },
    
    postAlta : function(){
        var id_producto = $('#selectAltaProducto').val();
        var id_seccion = $('#selectAltaSeccion').val();
        var id_listaprecio = $('#selectAltaListaPrecio').val();
        var id_menu = $('#idMenu').val();

        if (id_producto !== '-1'){
            if (id_seccion !== '-1'){
                if (id_listaprecio !== '-1'){
                    auxiliar.espera.lanzar();
                    $.ajax({
                        data:  {'id_menu': id_menu, 'id_producto': id_producto, 'id_seccion': id_seccion, 'id_lista_precio': id_listaprecio },
                        url:   '/IAW-PF/menu/alta_producto',
                        type:  'post',
                        error: function(response){
                            auxiliar.espera.detener();
                            auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                            auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                            auxiliar.mensaje('No se puede modificar el menú en este momento.', 5000,'toast-error');
                        },
                        success: function (response){
                            var respuesta = JSON.parse(response);
                            auxiliar.espera.detener();
                            if (respuesta['error'] === undefined){
                                menu_vista.producto.alta(respuesta['data']);
                                auxiliar.mensaje('Menú modificado exitosamente.', 2500,'toast-ok');
                            }else{
                                auxiliar.mensaje(respuesta['error'], 5000,'toast-error');
                            }
                        }
                    });
                }else{
                    auxiliar.mensaje('Debe seleccionar una lista de precio.', 2500,'toast-error');
                }
            }else{
                auxiliar.mensaje('Debe seleccionar una sección.', 2500,'toast-error');
            }
        }else{
            auxiliar.mensaje('Debe seleccionar un producto.', 2500,'toast-error');   
        }
    },
    
    autocompletar : function (){
        var texto = $('#inputBusqueda').val();
        if (texto.length > 2){
            $.ajax({
                data:  { 'texto' : texto },
                url:   '/IAW-PF/menu/autocompletar',
                type:  'post',
                error: function(response){
                    auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                    auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                    auxiliar.mensaje('No se puede realizar la búsqueda en este momento.', 5000,'toast-error');
                },
                success: function (response){
                    var respuesta = JSON.parse(response);
                    if (respuesta['error'] === undefined ){
                        menu_vista.producto.autocompletar(respuesta['data']);
                    }
                }

            });
        }
    },
    
    eliminar : function(id){
        auxiliar.espera.lanzar();
        $.ajax({
            data:  {'id_producto_infocarta': id },
            url:   '/IAW-PF/menu/eliminar_producto',
            type:  'post',
            error: function(response){
                auxiliar.espera.detener();
                auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                auxiliar.mensaje('El producto no puede ser editado en este momento.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                auxiliar.espera.detener();
                if (respuesta['error'] === undefined){
                    menu_vista.producto.eliminar(id);
                    auxiliar.mensaje('Producto eliminado exitosamente.', 2500,'toast-ok'); 
                }else{
                    auxiliar.mensaje('Se produjo un error al intentar eliminar el producto.', 5000,'toast-error');
                }
            }
        });
    },
    
    info : function(id_lista, id_producto){
        auxiliar.espera.lanzar();
        $.ajax({
            data:  {'id_lista': id_lista, 'id_producto': id_producto },
            url:   '/IAW-PF/listaprecios/info_producto',
            type:  'post',
            error: function(response){
                auxiliar.espera.detener();
                auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                auxiliar.mensaje('No se puede obtener información del producto en este momento.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                auxiliar.espera.detener();
                if (respuesta['error'] === undefined){
                    listaprecios_vista.producto.info(respuesta['data']); 
                }else{
                    auxiliar.mensaje(respuesta['error'], 5000,'toast-error');
                }
            }
        });
    }  
    
},//FIN PRODUCTO

}//FIN MENU
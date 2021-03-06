var menu = {

preAlta : function(){
    auxiliar.espera.lanzar();
    $.ajax({
        data:  {},
        url:   '/IAW-PF/menu/info_restricciones',
        type:  'post',
        error: function(response){
            auxiliar.espera.detener();
            auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
            auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
            auxiliar.mensaje('El menú no puede ser creado en este momento.', 5000,'toast-error');
        },
        success: function (response){
            var datos = JSON.parse(response);
            auxiliar.espera.detener();
            menu_vista.preAlta(datos);
        }
    });
    
}, //FIN PREALTA

postAlta : function(){
    nombre = $('#nombreMenu').val();
    id_hora = $('#selectHora').val();
    id_dia = $('#selectDia').val();
    
    if (nombre.length < 5 ){
       auxiliar.mensaje('El nombre ingresado debe contener al menos 5 caracteres.',2500,'toast-error');
    }else{
        if (id_dia == -1){
           auxiliar.mensaje('Debe seleccionar una restricción de día.',2500,'toast-error');
        }else{
            if (id_hora == -1){
                auxiliar.mensaje('Debe seleccionar una restricción de hora.',2500,'toast-error');
            }else{
                auxiliar.espera.lanzar();
                $.ajax({
                    data:  {'nombre': nombre, 'restriccion_dia' : id_dia, 'restriccion_hora' : id_hora },
                    url:   '/IAW-PF/menu/alta',
                    type:  'post',
                    error: function(response){
                        auxiliar.espera.detener();
                        auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                        auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                        auxiliar.mensaje('El menú no puede ser creado en este momento.', 5000,'toast-error');
                    },
                    success: function (response){
                        var respuesta = JSON.parse(response);
                        auxiliar.espera.detener();
                        if (respuesta['error'] === undefined){
                            menu_vista.postAlta(respuesta['data']);
                            auxiliar.mensaje('El menú fue creado exitosamente.', 2500,'toast-ok'); 
                        }else{
                            auxiliar.mensaje(respuesta['error'], 5000,'toast-error');
                        }
                    }
                });
            }
        }
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

cambiarDias : function(){
    var id_menu = $('#idMenu').val();
    var id_dias = $('#selectDias').val();
    auxiliar.espera.lanzar();
    $.ajax({
        data:  {'id': id_menu, 'id_dias': id_dias},
        url:   '/IAW-PF/menu/cambiar_dias',
        type:  'post',
        error: function(response){
            auxiliar.espera.detener();
            auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
            auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
            auxiliar.mensaje('La restricción no puede ser editada en este momento.', 5000,'toast-error');
        },
        success: function (response){
            var respuesta = JSON.parse(response);
            auxiliar.espera.detener();
            if (respuesta['error'] === undefined){
                auxiliar.mensaje('Restricción de día modificada exitosamente.', 2500,'toast-ok'); 
            }else{
                auxiliar.mensaje('Se produjo un error al intentar modificar la restricción.', 5000,'toast-error');
            }
        }
    });
    
},// FIN CAMBIAR DIAS

cambiarHoras : function (){
    var id_menu = $('#idMenu').val();
    var id_horas = $('#selectHoras').val();
    auxiliar.espera.lanzar();
    $.ajax({
        data:  {'id': id_menu, 'id_horas': id_horas},
        url:   '/IAW-PF/menu/cambiar_horas',
        type:  'post',
        error: function(response){
            auxiliar.espera.detener();
            auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
            auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
            auxiliar.mensaje('Restricción de hora no puede ser editada en este momento.', 5000,'toast-error');
        },
        success: function (response){
            var respuesta = JSON.parse(response);
            auxiliar.espera.detener();
            if (respuesta['error'] === undefined){
                auxiliar.mensaje('Restricción de hora modificada exitosamente.', 2500,'toast-ok'); 
            }else{
                auxiliar.mensaje('Se produjo un error al intentar modificar la restricción.', 5000,'toast-error');
            }
        }
    });
    
},// FIN CAMBIAR HORAS

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
    preEditar : function(id_producto_infocarta, id_producto){
        auxiliar.espera.lanzar();
        $.ajax({
            data:  {'id': id_producto },
            url:   '/IAW-PF/menu/info_producto',
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
                    menu_vista.producto.preEditar(id_producto_infocarta, respuesta['data']);
                }else{
                    auxiliar.mensaje('Se produjo un error al intentar modificar el producto.', 5000,'toast-error');
                }
            }
        });
    },

    postEditar : function(id_producto_infocarta){
        var id_seccion = $('#selectSeccion').val();
        var id_lista_precio = $('#selectListaPrecio').val();

        if (id_seccion !== '-1' || id_lista_precio !== '-1' ){
            auxiliar.espera.lanzar();
            $.ajax({
                data:  {'id': id_producto_infocarta, 'id_seccion': id_seccion, 'id_lista_precio': id_lista_precio },
                url:   '/IAW-PF/menu/cambiar_info_lista',
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
                        menu_vista.producto.postEditar(id_producto_infocarta, id_seccion, id_lista_precio);
                        auxiliar.mensaje('Producto editado exitosamente.', 2500,'toast-ok');     
                    }else{
                        auxiliar.mensaje('Se produjo un error al intentar modificar el producto.', 5000,'toast-error');
                    }
                }
            });
        }else{
            auxiliar.mensaje('No ha seleccionado ningún cambio en el producto.',2500,'toast-error');
        }
    }  
    
},//FIN PRODUCTO

promocion : {
    preAlta : function(){
        auxiliar.espera.lanzar();
        $.ajax({
            data:  {},
            url:   '/IAW-PF/menu/listar_promociones',
            type:  'post',
            error: function(response){
                auxiliar.espera.detener();
                auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                auxiliar.mensaje('No se pueden obtener las promociones en este momento.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                auxiliar.espera.detener();
                if (respuesta['error'] === undefined){
                    menu_vista.promocion.preAlta(respuesta['data']);
                }else{
                    auxiliar.mensaje('Se produjo un error al obtener información de las promociones.', 5000,'toast-error');
                }
            }
        });
    },

    seleccionaAlta : function(){
        var id_promocion = $('#selectAltaPromocion').val();
        if (id_promocion !== '-1'){
            auxiliar.espera.lanzar();
            $.ajax({
                data:  {'id_promocion': id_promocion },
                url:   '/IAW-PF/menu/info_promocion',
                type:  'post',
                error: function(response){
                    auxiliar.espera.detener();
                    auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                    auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                    auxiliar.mensaje('No se puede obtener info de la promoción en este momento.', 5000,'toast-error');
                },
                success: function (response){
                    var respuesta = JSON.parse(response);
                    auxiliar.espera.detener();
                    if (respuesta['error'] === undefined){
                        menu_vista.promocion.seleccionaAlta(respuesta['data']);
                    }else{
                        auxiliar.mensaje('Se produjo un error al obtener información de la promoción.', 5000,'toast-error');
                    }
                }
            });
        }
    },

    postAlta : function (){
        var id_menu = $('#idMenu').val();
        var id_promocion = $('#selectAltaPromocion').val();

        if (id_promocion !== '-1'){
            auxiliar.espera.lanzar();
            $.ajax({
                data:  {'id_menu':id_menu, 'id_promocion': id_promocion },
                url:   '/IAW-PF/menu/alta_promocion',
                type:  'post',
                error: function(response){
                    auxiliar.espera.detener();
                    auxiliar.mensaje('Se produjo un error en la conexión.', 2500,'toast-error');
                    auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 2500,'toast-error');
                    auxiliar.mensaje('No se puede agregar la promoción al menú en este momento.', 2500,'toast-error');
                },
                success: function (response){
                    var respuesta = JSON.parse(response);
                    auxiliar.espera.detener();
                    if (respuesta['error'] === undefined){
                        menu_vista.promocion.alta(respuesta['data']);
                        auxiliar.mensaje('Menú modificado exitosamente.', 2500,'toast-ok');
                    }else{
                        auxiliar.mensaje(respuesta['error'], 5000,'toast-error');
                    }
                }
            });
        }else{
            auxiliar.mensaje('Debe seleccionar un producto.', 2500,'toast-error');   
        }
    },

    eliminar : function(id){
        var id_menu = $('#idMenu').val();
        auxiliar.espera.lanzar();
        $.ajax({
            data:  {'id_menu': id_menu, 'id_promocion': id },
            url:   '/IAW-PF/menu/eliminar_promocion',
            type:  'post',
            error: function(response){
                auxiliar.espera.detener();
                auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                auxiliar.mensaje('La promoción no puede ser eliminada en este momento.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                auxiliar.espera.detener();
                if (respuesta['error'] === undefined){
                    menu_vista.promocion.eliminar(id);
                    auxiliar.mensaje('Promoción eliminada exitosamente.', 2500,'toast-ok'); 
                }else{
                    auxiliar.mensaje('Se produjo un error al intentar eliminar la promoción.', 5000,'toast-error');
                }
            }
        });
    },

}, //FIN PROMOCION

}//FIN MENU
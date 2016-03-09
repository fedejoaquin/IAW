
function cambiarNombre(){
    var id = $('#idMenu').val();
    var nombre_nuevo = $('#nombreMenu').val();
    $.ajax({
            data:  {'id': id, 'nombre': nombre_nuevo},
            url:   '/IAW-PF/menu/cambiar_nombre',
            type:  'post',
            error: function(response){
                Materialize.toast('Se produjo un error en la conexión.', 5000,'toast-error');
                Materialize.toast('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                Materialize.toast('El nombre no puede ser editado en este momento.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                if (respuesta['error'] === undefined){
                    Materialize.toast('El nombre fue modificado exitosamente.', 2500,'toast-ok'); 
                }else{
                    Materialize.toast(respuesta['error'], 2500,'toast-error');
                }
            }
    });
}

function cambiarDias(){
    var id_menu = $('#idMenu').val();
    var id_dias = $('#selectDias').val();
    $.ajax({
            data:  {'id': id_menu, 'id_dias': id_dias},
            url:   '/IAW-PF/menu/cambiar_dias',
            type:  'post',
            error: function(response){
                Materialize.toast('Se produjo un error en la conexión.', 5000,'toast-error');
                Materialize.toast('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                Materialize.toast('La restricción no puede ser editada en este momento.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                if (respuesta['error'] === undefined){
                    Materialize.toast('Restricción de día modificada exitosamente.', 2500,'toast-ok'); 
                }else{
                    Materialize.toast('Se produjo un error al intentar modificar la restricción.', 2500,'toast-error');
                }
            }
    });
}

function cambiarHoras(){
    var id_menu = $('#idMenu').val();
    var id_horas = $('#selectHoras').val();
    $.ajax({
            data:  {'id': id_menu, 'id_horas': id_horas},
            url:   '/IAW-PF/menu/cambiar_horas',
            type:  'post',
            error: function(response){
                Materialize.toast('Se produjo un error en la conexión.', 5000,'toast-error');
                Materialize.toast('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                Materialize.toast('Restricción de hora no puede ser editada en este momento.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                if (respuesta['error'] === undefined){
                    Materialize.toast('Restricción de hora modificada exitosamente.', 2500,'toast-ok'); 
                }else{
                    Materialize.toast('Se produjo un error al intentar modificar la restricción.', 2500,'toast-error');
                }
            }
    });
}

function preAltaProducto(){
    reset_modal_alta();
    $('#altaProducto').openModal();
}

function preAltaPromocion(){
    $.ajax({
            data:  {},
            url:   '/IAW-PF/menu/promociones',
            type:  'post',
            error: function(response){
                Materialize.toast('Se produjo un error en la conexión.', 2500,'toast-error');
                Materialize.toast('El servidor no está respondiendo nuestra solicitud.', 2500,'toast-error');
                Materialize.toast('No se pueden obtener las promociones en este momento.', 2500,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                if (respuesta['error'] === undefined){
                    listar_promociones(respuesta['data']);
                }else{
                    Materialize.toast('Se produjo un error al obtener información de las promociones.', 2500,'toast-error');
                }
            }
    });
}

function seleccionaAltaProducto(){
    var id_producto = $('#selectAltaProducto').val();
    if (id_producto !== '-1'){
        $.ajax({
                data:  {'id': id_producto },
                url:   '/IAW-PF/menu/info_producto',
                type:  'post',
                error: function(response){
                    Materialize.toast('Se produjo un error en la conexión.', 2500,'toast-error');
                    Materialize.toast('El servidor no está respondiendo nuestra solicitud.', 2500,'toast-error');
                    Materialize.toast('No se puede obtener info del producto en este momento.', 2500,'toast-error');
                },
                success: function (response){
                    var respuesta = JSON.parse(response);
                    if (respuesta['error'] === undefined){
                        autocompletar_info_producto(respuesta['data']);
                    }else{
                        Materialize.toast('Se produjo un error al obtener información del producto.', 2500,'toast-error');
                    }
                }
        });
    }
}

function postAltaProducto(){
    var id_producto = $('#selectAltaProducto').val();
    var id_seccion = $('#selectAltaSeccion').val();
    var id_listaprecio = $('#selectAltaListaPrecio').val();
    var id_menu = $('#idMenu').val();
    
    if (id_producto !== '-1'){
        if (id_seccion !== '-1'){
            if (id_listaprecio !== '-1'){
                $.ajax({
                        data:  {'id_menu': id_menu, 'id_producto': id_producto, 'id_seccion': id_seccion, 'id_lista_precio': id_listaprecio },
                        url:   '/IAW-PF/menu/alta_producto',
                        type:  'post',
                        error: function(response){
                            Materialize.toast('Se produjo un error en la conexión.', 2500,'toast-error');
                            Materialize.toast('El servidor no está respondiendo nuestra solicitud.', 2500,'toast-error');
                            Materialize.toast('No se puede modificar el menú en este momento.', 2500,'toast-error');
                        },
                        success: function (response){
                            var respuesta = JSON.parse(response);
                            if (respuesta['error'] === undefined){
                                agregar_nuevo_producto(respuesta['data']);
                                Materialize.toast('Menú modificado exitosamente.', 2500,'toast-ok');
                            }else{
                                Materialize.toast(respuesta['error'], 2500,'toast-error');
                            }
                        }
                        
                });
            }else{
                Materialize.toast('Debe seleccionar una lista de precio.', 2500,'toast-error');
            }
        }else{
            Materialize.toast('Debe seleccionar una sección.', 2500,'toast-error');
        }
    }else{
        Materialize.toast('Debe seleccionar un producto.', 2500,'toast-error');   
    }
}

function autocompletar(){
    var texto = $('#inputBusqueda').val();
    if (texto.length > 3){
        $.ajax({
            data:  { 'texto' : texto },
            url:   '/IAW-PF/menu/autocompletar',
            type:  'post',
            error: function(response){
                Materialize.toast('Se produjo un error en la conexión.', 2500,'toast-error');
                Materialize.toast('El servidor no está respondiendo nuestra solicitud.', 2500,'toast-error');
                Materialize.toast('No se puede realizar la búsqueda en este momento.', 2500,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                if (respuesta['error'] === undefined ){
                    autocompletar_productos(respuesta['data']);
                }
            }
            
        });
    }
}

function eliminarProducto(id){
    $.ajax({
            data:  {'id_producto_infocarta': id },
            url:   '/IAW-PF/menu/eliminar_producto',
            type:  'post',
            error: function(response){
                Materialize.toast('Se produjo un error en la conexión.', 5000,'toast-error');
                Materialize.toast('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                Materialize.toast('El producto no puede ser editado en este momento.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                if (respuesta['error'] === undefined){
                    $('#fila'+id).remove();
                    Materialize.toast('Producto eliminado exitosamente.', 2500,'toast-ok'); 
                }else{
                    Materialize.toast('Se produjo un error al intentar eliminar el producto.', 2500,'toast-error');
                }
            }
    });
}

function preEditarProducto(id_producto_infocarta, id_producto){
    $.ajax({
            data:  {'id': id_producto },
            url:   '/IAW-PF/menu/info_producto',
            type:  'post',
            error: function(response){
                Materialize.toast('Se produjo un error en la conexión.', 5000,'toast-error');
                Materialize.toast('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                Materialize.toast('El producto no puede ser editado en este momento.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                if (respuesta['error'] === undefined){
                    rellenar_tabla_producto(id_producto_infocarta, respuesta['data']);
                }else{
                    Materialize.toast('Se produjo un error al intentar modificar el producto.', 2500,'toast-error');
                }
            }
    });
}

function postEditarProducto(id_producto_infocarta){
    var id_seccion = $('#selectSeccion').val();
    var id_lista_precio = $('#selectListaPrecio').val();
    
    if (id_seccion !== '-1' || id_lista_precio !== '-1' ){
        $.ajax({
                data:  {'id': id_producto_infocarta, 'id_seccion': id_seccion, 'id_lista_precio': id_lista_precio },
                url:   '/IAW-PF/menu/cambiar_info_lista',
                type:  'post',
                error: function(response){
                    Materialize.toast('Se produjo un error en la conexión.', 5000,'toast-error');
                    Materialize.toast('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                    Materialize.toast('El producto no puede ser editado en este momento.', 5000,'toast-error');
                },
                success: function (response){
                    var respuesta = JSON.parse(response);
                    if (respuesta['error'] === undefined){
                        actualizar_post_modificacion(id_producto_infocarta, id_seccion, id_lista_precio);
                        Materialize.toast('Producto editado exitosamente.', 2500,'toast-ok');     
                    }else{
                        Materialize.toast('Se produjo un error al intentar modificar el producto.', 2500,'toast-error');
                    }
                }
        });
    }else{
        $('#tablaEditarProducto').empty();
        $('#editarProducto').closeModal();
    }
}
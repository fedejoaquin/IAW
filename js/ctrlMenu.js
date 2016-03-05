
function cambiarNombre(){
    var id = $('#idMenu').val();
    var nombre_nuevo = $('#nombreMenu').val();
    $.ajax({
            data:  {'id': id, 'nombre': nombre_nuevo},
            url:   'http://localhost/IAW-PF/ajax/menu_cambiar_nombre',
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
            url:   'http://localhost/IAW-PF/ajax/menu_cambiar_dias',
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
            url:   'http://localhost/IAW-PF/ajax/menu_cambiar_horas',
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

function eliminarProducto(id){
    $.ajax({
            data:  {'id_producto_infocarta': id },
            url:   'http://localhost/IAW-PF/ajax/menu_eliminar_producto',
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
            url:   'http://localhost/IAW-PF/ajax/menu_info_producto',
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
    
    if (id_seccion !== -1 || id_lista_precio !== -1 ){
        $.ajax({
                data:  {'id': id_producto_infocarta, 'id_seccion': id_seccion, 'id_lista_precio': id_lista_precio },
                url:   'http://localhost/IAW-PF/ajax/menu_cambiar_info_lista',
                type:  'post',
                error: function(response){
                    Materialize.toast('Se produjo un error en la conexión.', 5000,'toast-error');
                    Materialize.toast('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                    Materialize.toast('El producto no puede ser editado en este momento.', 5000,'toast-error');
                },
                success: function (response){
                    var respuesta = JSON.parse(response);
                    if (respuesta['error'] === undefined){
                        $('#tablaEditarProducto').empty();
                        $('#editarProducto').closeModal();
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

function actualizar_post_modificacion(){
    
}

function rellenar_tabla_producto(id_producto_infocarta, datos){
    $('#tablaEditarProducto').empty();
    
    $('#btnConfirmarEdicion').attr("onClick", "postEditarProducto("+id_producto_infocarta+")");
    
    row_clonada = $('#fila'+id_producto_infocarta).clone();
    $(row_clonada).find("td:last").remove();
    $('#tablaEditarProducto').append(row_clonada);
    
    var secciones = datos['secciones'];
    var listaPrecio = datos['listaPrecios'];
    
    option = $("<option></option>");
    $(option).text('Sin cambios');
    $(option).attr("class", "selected");
    $(option).attr("value", "-1");
    
    $('#selectSeccion').empty();
    $('#selectSeccion').append(option);
    
    option_1 = $("<option></option>");
    $(option_1).text('Sin cambios');
    $(option_1).attr("class", "selected");
    $(option_1).attr("value", "-1");
    
    $('#selectListaPrecio').empty();
    $('#selectListaPrecio').append(option_1);
          
    for(i=0; i<secciones.length; i++){
       var tupla = secciones[i];
        
        option = $("<option></option>");
        $(option).text(tupla['nombre']);
        $(option).attr("value", tupla['id']);
        
        $('#selectSeccion').append(option); 
    }
    
    for(i=0; i<listaPrecio.length; i++){
       var tupla = listaPrecio[i];
        
        option = $("<option></option>");
        $(option).text(tupla['nombre_lista_precio'] + " - $" + tupla['precio_producto']);
        $(option).attr("value", tupla['id_lista_precio']);
        
        $('#selectListaPrecio').append(option); 
    }
    
    //Reinicio los selects para una correcta visualización
    $('#selectSeccion').material_select();
    $('#selectListaPrecio').material_select();
    
    $('#editarProducto').openModal();
}
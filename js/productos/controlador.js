var productos = {

eliminar : function(id){
   $.ajax({
        data:  {'id_producto': id },
        url:   '/IAW-PF/productos/eliminar',
        type:  'post',
        error: function(response){
            productos_vista.mensaje('Se produjo un error en la conexión.', 2500,'toast-error');
            productos_vista.mensaje('El servidor no está respondiendo nuestra solicitud.', 2500,'toast-error');
            productos_vista.mensaje('El producto no puede ser eliminado en este momento.', 2500,'toast-error');
        },
        success: function (response){
            var respuesta = JSON.parse(response);
            if (respuesta['error'] === undefined){
                productos_vista.eliminar(id);
                productos_vista.mensaje('El producto fue eliminado exitosamente.', 2500,'toast-ok'); 
            }else{
                productos_vista.mensaje(respuesta['error'], 2500,'toast-error');
            }
        }
    });
},

editar : function(id){
    productos_vista.preEditar(id);
},

cambiarNombre : function(id){
   var nombre_nuevo = $('#nombreNuevoProducto').val();
    
   if (nombre_nuevo.length < 5 ){
        productos_vista.mensaje('El nombre ingresado debe contener al menos 5 caracteres.', 2500, 'toast-error');
    }else{
         $.ajax({
            data:  {'id': id, 'nombre': nombre_nuevo },
            url:   '/IAW-PF/productos/editar',
            type:  'post',
            error: function(response){
                productos_vista.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                productos_vista.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                productos_vista.mensaje('El nombre no puede ser editado en este momento.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                if (respuesta['error'] === undefined){
                    productos_vista.postEditar(id, nombre_nuevo);
                    productos_vista.mensaje('El nombre fue modificado exitosamente.', 2500,'toast-ok'); 
                }else{
                    productos_vista.mensaje(respuesta['error'], 2500,'toast-error');
                }
            }
        });
    } 
},

producto : {
    preAlta : function(){
        productos_vista.producto.reset_modal();
        productos_vista.producto.abrir_modal();
    },
    
    postAlta : function(){
        var nombre = $('#nombreProducto').val();
        var file_imagen = $('#inputFile').val();

        if (nombre.length < 5){
            productos_vista.mensaje('El nombre ingresado debe contener al menos 5 caracteres.', 2500, 'toast-error');
        }else{
            $.ajax({
                    data:  {'nombre': nombre },
                    url:   '/IAW-PF/productos/alta',
                    type:  'post',
                    error: function(response){
                        productos_vista.mensaje('Se produjo un error en la conexión.', 2500,'toast-error');
                        productos_vista.mensaje('El servidor no está respondiendo nuestra solicitud.', 2500,'toast-error');
                        productos_vista.mensaje('No se puede dar de alta el producto en este momento.', 2500,'toast-error');
                    },
                    success: function (response){
                        var respuesta = JSON.parse(response);
                        if (respuesta['error'] === undefined){
                            productos_vista.producto.alta(respuesta['data']);
                            productos_vista.mensaje('Producto creado exitosamente.', 2500,'toast-ok');
                        }else{
                            productos_vista.mensaje(respuesta['error'], 2500,'toast-error');
                        }
                    }

            });
        }
    }
    
}//FIN PRODUCTO

}//FIN PRODUCTOS
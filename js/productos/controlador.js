var productos = {

eliminar : function(id){
    auxiliar.espera.lanzar();
    $.ajax({
        data:  {'id_producto': id },
        url:   '/IAW-PF/productos/eliminar',
        type:  'post',
        error: function(response){
            auxiliar.espera.detener();
            auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
            auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
            auxiliar.mensaje('El producto no puede ser eliminado en este momento.', 5000,'toast-error');
        },
        success: function (response){
            var respuesta = JSON.parse(response);
            auxiliar.espera.detener();
            if (respuesta['error'] === undefined){
                productos_vista.eliminar(id);
                auxiliar.mensaje('El producto fue eliminado exitosamente.', 2500,'toast-ok'); 
            }else{
                auxiliar.mensaje(respuesta['error'], 5000,'toast-error');
            }
        }
    });
    
}//FIN ELIMINAR

}//FIN PRODUCTOS
var competencia = {

filtro_dia: -1,
filtro_mes: -1,
filtro_anio: -1,
filtro_cerveza : "todas",

//consumo_producto(nombre, dia, mes, anio)
//consumo_total(dia,mes,anio)
//productos()
//info_producto(nombre)

cargar_podio : function(){
    auxiliar.espera.lanzar();
    if (competencia.filtro_cerveza == "todas"){
        $.ajax({
            data:  JSON.stringify({dia: competencia.filtro_dia, mes: competencia.filtro_mes, anio: competencia.filtro_anio}),
            url:   'http://localhost:8888/consumo_total',
            type:  'post',
            dataType: "json",
            crossDomain:true,
            error: function(response){
                auxiliar.espera.detener();
                auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                auxiliar.mensaje('El podio no puede ser actualizado.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                auxiliar.espera.detener();
                if (respuesta['error'] === undefined){
                    competencia_vista.cargar_podio(respuesta);
                }else{
                    auxiliar.mensaje(respuesta['error'], 5000,'toast-error');
                }
            }
        });
    }else{
        $.ajax({
            data:  JSON.stringify({nombre:competencia.filtro_cerveza, dia: competencia.filtro_dia, mes: competencia.filtro_mes, anio: competencia.filtro_anio}),
            url:   'http://localhost:8888/consumo_producto',
            type:  'post',
            dataType: "json",
            crossDomain:true,
            error: function(response){
                auxiliar.espera.detener();
                auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                auxiliar.mensaje('El podio no puede ser actualizado.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                auxiliar.espera.detener();
                if (respuesta['error'] === undefined){
                    competencia_vista.cargar_podio(respuesta);
                }else{
                    auxiliar.mensaje(respuesta['error'], 5000,'toast-error');
                }
            }
        });
    }
    setTimeout("competencia.cargar_podio()",100000);
    
}, //FIN CARGAR_PODIO

cervezas : {
    listar : function(){
        $.ajax({
            data:  JSON.stringify({}),
            url:   'http://localhost:8888/productos',
            type:  'post',
            dataType: "json",
            crossDomain:true,
            error: function(response){
                auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                auxiliar.mensaje('Las cervezas del concurso no pueden ser listadas.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                if (respuesta['error'] === undefined){
                    competencia_vista.cervezas.listar(respuesta);
                }else{
                    auxiliar.mensaje(respuesta['error'], 5000,'toast-error');
                }
            }
        });
    },
    
    ver : function(nombre_id){
        auxiliar.espera.lanzar();
        $.ajax({
            data:  JSON.stringify({nombre: nombre_id }),
            url:   'http://localhost:8888/info_producto',
            type:  'post',
            dataType: "json",
            crossDomain:true,
            error: function(response){
                auxiliar.espera.detener();
                auxiliar.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                auxiliar.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                auxiliar.mensaje('La cerveza no puede ser visualizada.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                auxiliar.espera.detener();
                if (respuesta['error'] === undefined){
                    competencia_vista.cervezas.ver(respuesta);
                }else{
                    auxiliar.mensaje(respuesta['error'], 5000,'toast-error');
                }
            }
        });
    }

} //FIN CERVEZA

}//FIN COMPETENCIA

$( document ).ready(function(){
    competencia.cervezas.listar();
    competencia.cargar_podio();
});

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
                auxiliar.espera.detener();
                if (response['error'] === undefined){
                    competencia_vista.cargar_podio(response);
                }else{
                    auxiliar.mensaje(response['error'], 5000,'toast-error');
                }
            }
        });
    }else{
        $.ajax({
            data:  JSON.stringify({nombre_producto:competencia.filtro_cerveza, dia: competencia.filtro_dia, mes: competencia.filtro_mes, anio: competencia.filtro_anio}),
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
                auxiliar.espera.detener();
                if (response['error'] === undefined){
                    competencia_vista.cargar_podio(response);
                }else{
                    auxiliar.mensaje(response['error'], 5000,'toast-error');
                }
            }
        });
    }
    setTimeout("competencia.cargar_podio()",100000);
    
}, //FIN CARGAR_PODIO

cervezas : {
    listar : function(){
        $.ajax({
            data:  {},
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
                if (response['error'] === undefined){
                    competencia_vista.cervezas.listar(response);
                }else{
                    auxiliar.mensaje(respuesta['error'], 5000,'toast-error');
                }
            }
        });
    },
    
    ver : function(id){
        competencia_vista.cervezas.ver(id);
    }

}, //FIN CERVEZA


filtro : {
    cerveza : function(nombre){
        competencia.filtro_cerveza = nombre;
        competencia.cargar_podio();
    },
    fecha : function(){
        competencia.filtro_dia = 31 - ('31' - $('#selectDia').val());
        competencia.filtro_mes = 12 - ('12' - $('#selectMes').val());
        competencia.filtro_anio = 2016 - ('2016' - $('#selectAnio').val());
        competencia.cargar_podio();
    }
}

}//FIN COMPETENCIA

$( document ).ready(function(){
    competencia.cervezas.listar();
    competencia.cargar_podio();
});

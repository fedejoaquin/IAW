var notificaciones = new Array();

$( document ).ready(function(){
    checkNotificaciones();
});


function checkNotificaciones(){
    id_mozo = $('#inputNotificaciones').val();
    
    $.ajax({
        data:  {'id_mozo':id_mozo},
        url:   'http://localhost/IAW-PF/ajax_1/pedir_notificaciones',
        type:  'get',
        success: function (response){
            var respuesta = JSON.parse(response);
            if (respuesta['error'] === undefined){
                notificaciones = respuesta['notificaciones'];
                listarNotificaciones();
            }
        }
    });
    setTimeout("checkNotificaciones()",10000);
    
}

function listarNotificaciones(){
    $('#tablaNotificaciones').empty();
    defaultComent = 'Sin comentarios.';
    
    for(var i=0; i<notificaciones.length;i++){
        row = $("<tr></tr>");
        numNot = $("<td>"+(i+1)+"</td>");
        mesa = $("<td> Nº:"+notificaciones[i]['numero']+"</td>");
        producto = $("<td>"+notificaciones[i]['producto']+"</td>");
        visto = $("<td><button class='btn waves-effect waves-light'><i class='material-icons right'>clear_all</i></button></td>");
        visto.attr('onclick',"vistoNotificacion("+i+")");
        comment = notificaciones[i]['comentarios'];
        comentarios = $("<td></td>");
        if(defaultComent.localeCompare(comment) !== 0)
        {
            comentarios = $("<td>"+notificaciones[i]['comentarios']+"</td>");
        }
        $(row).append(numNot);
        $(row).append(mesa);
        $(row).append(producto);
        $(row).append(comentarios);
        $(row).append(visto);

       $('#tablaNotificaciones').append(row);
    }
}

function vistoNotificacion(posicion){
    var tupla = notificaciones[posicion];
    $.ajax({
            data:  {'not_id': tupla['not_id']},
            url:   'http://localhost/IAW-PF/ajax_1/eliminar_notificacion',
            type:  'post',
            error: function(response){
                Materialize.toast('Se produjo un error en la conexión.', 5000,'toast-error');
                Materialize.toast('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                Materialize.toast('En 5 segundos el sistema reintentará automáticamente.', 10000,'toast-error');
                setTimeout(function(){ validarCliente(); }, 5000);    
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                if (respuesta['error'] === undefined){
//                    $('#notificacion'+posicion).hide('slow');
                    notificaciones.splice(posicion,1);
                    listarNotificaciones();
                }else{
                    var error = respuesta['error'];
                    Materialize.toast(error, 3000,'toast-error');
                }
            }
        });
        
}
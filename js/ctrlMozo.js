var notificaciones = new Array();

$( document ).ready(function(){
    checkNotificaciones();
});


function vincularCliente(){
    codigo = $('#inputCodigo').val();
    id_mesa = $('#id_mesa').val();
    if (codigo.length !== 6){
        Materialize.toast('Datos de codigo no validos, faltan o sobran caracteres.', 2000,'toast-error');
    }else{
        $.ajax({
            data:  {'codigoCliente': codigo,'id_mesa':id_mesa},
            url:   'http://localhost/IAW-PF/ajax_1/vincularCliente',
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
                    $('#inputCodigo').val('');
                    Materialize.toast('Cliente vinculado correctamente.', 2000,'toast-ok');
                }else{
                    var error = respuesta['error'];
                    Materialize.toast('Error en vinculacion: ' + error, 10000,'toast-error');
                }
            }
        });
    }
}

function checkNotificaciones(){
    id_mozo = $('#inputNotificaciones').val();
    
    $.ajax({
        data:  {'id_mozo':id_mozo},
        url:   'http://localhost/IAW-PF/ajax_1/pedir_notificaciones',
        type:  'get',
        error:function(response){
            Materialize.toast("Error", 2000,'toast-ok');
        },
        
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
    for(var i=0; i<notificaciones.length;i++){
        row = $("<tr></tr>");
        numNot = $("<td>"+(i+1)+"</td>");
        mesa = $("<td> Nº:"+notificaciones[i]['numero']+"</td>");
        producto = $("<td>"+notificaciones[i]['producto']+"</td>");
        visto = $("<td><button><i class='material-icons right'>clear_all</i></button></td>");
        visto.attr('onclick',"vistoNotificacion("+i+")");
         
        row.attr('id','notificacion'+i);
        
        $(row).append(numNot);
        $(row).append(mesa);
        $(row).append(producto);
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
                    Materialize.toast(error, 10000,'toast-error');
                }
            }
        });
        
}
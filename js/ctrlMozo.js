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
    $id_mozo = $('#tablaNotificaciones').val();
    $.ajax({
        data:  {'id_mozo':$id_mozo},
        url:   'http://localhost/IAW-PF/ajax_1/pedir_notificaciones',
        type:  'get',
        success: function (response){
            var respuesta = JSON.parse(response);
            if (respuesta['error'] === undefined){
                listarNotificaciones(respuesta['data']);
            }
        }
    });
    setTimeout("checkNotificaciones()",10000);
    
}

function listarNotificaciones(notificaciones){
    
}
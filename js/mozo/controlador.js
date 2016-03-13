var mozo = {
notificaciones : [],

 checkNotificaciones : function(){
    var id_mozo = $('#inputNotificaciones').val();
    $.ajax({
        data:  {'id_mozo':id_mozo},
        url:   '/IAW-PF/mozo/pedir_notificaciones',
        type:  'get',
        success: function (response){
                mozo.notificaciones = respuesta['notificaciones'];
                mozo_vista.listarNotificaciones();
        }
    });
    setTimeout("mozo.checkNotificaciones()",3000);
    
},



vistoNotificacion : function (posicion){
    var tupla = mozo.notificaciones[posicion];
    $.ajax({
            data:  {'not_id': tupla['not_id']},
            url:   '/IAW-PF/mozo/eliminar_notificacion',
            type:  'post',
            error: function(response){
                mozo_vista.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                mozo_vista.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                mozo_vista.mensaje('En 5 segundos el sistema reintentará automáticamente.', 10000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                if (respuesta['error'] === undefined){
                    mozo.notificaciones.splice(posicion,1);
                    mozo_vista.listarNotificaciones();
                }else{
                    var error = respuesta['error'];
                    mozo_vista.mensaje(error, 3000,'toast-error');
                }
            }
        });
        
    }
};

$( document ).ready(function(){
    mozo.checkNotificaciones();
});
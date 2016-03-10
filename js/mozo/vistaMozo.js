var mozo_vista = {
listarNotificaciones : function (){
        $('#tablaNotificaciones').empty();
        defaultComent = 'Sin comentarios.';
        cantidad = mozo.notificaciones.length;
        if(cantidad > 0){
            $('#tabNotificaciones').html(cantidad+" Notificaciones Nuevas");
        }
        else{
            $('#tabNotificaciones').html("No hay notificaciones");
        }
        for(var i=0; i<cantidad;i++){
            row = $("<tr></tr>");
            numNot = $("<td>"+(i+1)+"</td>");
            mesa = $("<td> Nº:"+mozo.notificaciones[i]['numero']+"</td>");
            producto = $("<td>"+mozo.notificaciones[i]['producto']+"</td>");
            visto = $("<td><button class='btn waves-effect waves-light'><i class='material-icons right'>clear_all</i></button></td>");
            visto.attr('onclick',"mozo.vistoNotificacion("+i+")");
            comment = mozo.notificaciones[i]['comentarios'];
            comentarios = $("<td></td>");
            if(defaultComent.localeCompare(comment) !== 0)
            {
                comentarios = $("<td>"+mozo.notificaciones[i]['comentarios']+"</td>");
            }
            $(row).append(numNot);
            $(row).append(mesa);
            $(row).append(producto);
            $(row).append(comentarios);
            $(row).append(visto);

           $('#tablaNotificaciones').append(row);
        }
    },
   
    mensaje : function(mensaje, tiempo, clase){
        Materialize.toast(mensaje, tiempo ,clase);
    }
};


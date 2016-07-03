var competencia_vista = {


cargar_podio : function(data){
    auxiliar.mensaje("Llego mensaje cargar_podio", 5000, 'toast-ok');
    
}, //FIN CARGAR PODIO

cervezas : {
    listar : function(data){
        $("#tblCervezas").empty();
        
        $.each(data, function(key, value){
            row = $("<tr></tr>");
            td = $("<td>"+value.nombre_producto+"</td>");
            
            td_2 = $("<td></td>");
            
            icon_i = $("<i></i>");
            $(icon_i).attr("class", "material-icons");
            $(icon_i).text("info");

            link_i = $("<a></a>");
            $(link_i).attr("class", "boton btn-base-mini waves-effect transparent");
            $(link_i).attr("onclick", "competencia.cervezas.ver("+value.nombre_producto+")");
            
            $(link_i).append(icon_i);
            $(td_2).append(link_i);
            
            $(row).append(td);
            $(row).append(td_2);
            
            $("#tblCerveza").append(row);
        });
    
    },
    
    ver : function(data){
        $('#modalVerCerveza').openModal();
    }
}

} //FIN CLIENTE_VISTA









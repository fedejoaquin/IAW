var competencia_vista = {

info_producto : [],

cargar_podio : function(data){
    $("#tblPosiciones").empty();
    
    //Ordenamos en forma descendente el arreglo data.
    competencia_vista.ordenar(data, 'consumo', false);
    
    //Primer puesto podio
    if (data.length >= 1){
        $("#puestoUno").empty();
        img = $("<img/>");
        $(img).attr("src", "http://localhost/IAW-PF/img/"+data[0]['nombre_competidor']+".png");
        $(img).attr("class", "podio_img");
        $("#puestoUno").append(img);
        
        //Segundo puesto podio
        if (data.length >= 2){
            $("#puestoDos").empty();
            img = $("<img/>");
            $(img).attr("src", "http://localhost/IAW-PF/img/"+data[1]['nombre_competidor']+".png");
            $(img).attr("class", "podio_img");
            $("#puestoDos").append(img);
            
            //Tercer puesto podio
            if (data.length >=3){
                $("#puestoTres").empty();
                img = $("<img/>");
                $(img).attr("src", "http://localhost/IAW-PF/img/"+data[2]['nombre_competidor']+".png");
                $(img).attr("class", "podio_img");
                $("#puestoTres").append(img);

                if(data.length>3){
                    //Completamos la tabla de restantes posiciones
                    for(i=4; i<=data.length; i++){
                        row = $("<tr></tr>");
                        td = $("<td>"+i+"</td>");
                        td_2 = $("<td></td>");
                        
                        img = $("<img/>");
                        $(img).attr("src", "http://localhost/IAW-PF/img/"+data[i-1]['nombre_competidor']+".png");
                        $(img).attr("class", "podio_img");
                        
                        $(td_2).append(img);
                                                
                        $(row).append(td);
                        $(row).append(td_2);
                        
                        $("#tblPosiciones").append(row);
                    }
                }
            }else{
                //Hay solo dos para podio
                $("#puestoTres").empty();
                img = $("<img/>");
                $(img).attr("src", "http://localhost/IAW-PF/img/Bohemia.Vacante.png");
                $(img).attr("class", "podio_img");
                $("#puestoTres").append(img);
            }
        }else{
            //Hay un solo para podio.
            $("#puestoDos").empty();
            img = $("<img/>");
            $(img).attr("src", "http://localhost/IAW-PF/img/Bohemia.Vacante.png");
            $(img).attr("class", "podio_img");
            $("#puestoDos").append(img);
            
            $("#puestoTres").empty();
            img = $("<img/>");
            $(img).attr("src", "http://localhost/IAW-PF/img/Bohemia.Vacante.png");
            $(img).attr("class", "podio_img");
            $("#puestoTres").append(img);
        }
    }else{
        //Sin elementos para podio.
        $("#puestoUno").empty();
        img = $("<img/>");
        $(img).attr("src", "http://localhost/IAW-PF/img/Bohemia.Vacante.png");
        $(img).attr("class", "podio_img");
        $("#puestoUno").append(img);
        
        $("#puestoDos").empty();
        img = $("<img/>");
        $(img).attr("src", "http://localhost/IAW-PF/img/Bohemia.Vacante.png");
        $(img).attr("class", "podio_img");
        $("#puestoDos").append(img);

        $("#puestoTres").empty();
        img = $("<img/>");
        $(img).attr("src", "http://localhost/IAW-PF/img/Bohemia.Vacante.png");
        $(img).attr("class", "podio_img");
        $("#puestoTres").append(img);
        
    }
}, //FIN CARGAR PODIO

cervezas : {
    listar : function(data){
        $("#tblCervezas").empty();
        posicion = 0;
        
        row = $("<tr></tr>");
        td = $("<td>Todas</td>");

        td_2 = $("<td></td>");
        td_3 = $("<td></td>");

        icon_i = $("<i></i>");
        $(icon_i).attr("class", "material-icons");
        $(icon_i).text("info");

        icon_a = $("<i></i>");
        $(icon_a).attr("class", "material-icons");
        $(icon_a).text("done_all");
        
        link_i = $("<a></a>");
        $(link_i).attr("class", "boton btn-base-mini waves-effect transparent");

        link_a = $("<a></a>");
        $(link_a).attr("class", "boton btn-base-mini waves-effect transparent");
        $(link_a).attr("onclick", "competencia.filtro.cerveza('todas')");

        $(link_i).append(icon_i);
        $(td_2).append(link_i);

        $(link_a).append(icon_a);
        $(td_3).append(link_a);

        $(row).append(td);
        $(row).append(td_2);
        $(row).append(td_3);

        $("#tblCervezas").append(row);
        
        $.each(data, function(key, value){
            
            var tupla = {'nombre': value.nombre_producto, 'caracteristicas':value.caracteristicas, 'graduacion':value.graduacion, 'ibu': value.ibu, 'amargor': value.amargor, 'dg': value.dg}; 
            competencia_vista.info_producto[posicion]=tupla;
            
            row = $("<tr></tr>");
            td = $("<td>"+value.nombre_producto+"</td>");
            
            td_2 = $("<td></td>");
            td_3 = $("<td></td>");
            
            icon_i = $("<i></i>");
            $(icon_i).attr("class", "material-icons");
            $(icon_i).text("info");
            
            icon_a = $("<i></i>");
            $(icon_a).attr("class", "material-icons");
            $(icon_a).text("done_all");

            link_i = $("<a></a>");
            $(link_i).attr("class", "boton btn-base-mini waves-effect transparent");
            $(link_i).attr("onclick", "competencia.cervezas.ver("+posicion+")");
            
            link_a = $("<a></a>");
            $(link_a).attr("class", "boton btn-base-mini waves-effect transparent");
            $(link_a).attr("onclick", "competencia.filtro.cerveza('"+value.nombre_producto+"')");
            
            $(link_i).append(icon_i);
            $(td_2).append(link_i);
            
            $(link_a).append(icon_a);
            $(td_3).append(link_a);
            
            $(row).append(td);
            $(row).append(td_2);
            $(row).append(td_3);
            
            $("#tblCervezas").append(row);
            posicion++;
        });
    
    },
    
    ver : function(id){
        //var tupla = {'nombre': value.nombre_producto, 
        //'caracteristicas':value.caracteristicas, 'graduacion':value.graduacion, 
        //'ibu': value.ibu, 'amargor': value.amargor, 'dg': value.dg}; 
            
        var tupla = competencia_vista.info_producto[id];
        
        $('#lblVerCerveza').text("..: Visualizando cerveza "+ tupla['nombre'] +" :..");
        $('#tblVerCerveza').empty();
        
        row = $("<tr></tr>");
        td = $("<td>"+tupla['caracteristicas']+"</td>");
        td_2 = $("<td>"+tupla['graduacion']+"%</td>");
        td_3 = $("<td>"+tupla['ibu']+"</td>");
        td_4 = $("<td>"+tupla['amargor']+"</td>");
        td_5 = $("<td>"+tupla['dg']+"</td>");
        
        $(row).append(td);
        $(row).append(td_2);
        $(row).append(td_3);
        $(row).append(td_4);
        $(row).append(td_5);
        $("#tblVerCerveza").append(row);
        
        $('#modalVerCerveza').openModal();
    }
}, // FIN CERVEZAS

ordenar : function(data, campo, ascendente) {
    return data.sort(function(a, b) {
        var actual = a[campo]; var siguiente = b[campo];
        if (ascendente) { return ((actual < siguiente) ? -1 : ((actual > siguiente) ? 1 : 0)); }
        else { return ((actual > siguiente) ? -1 : ((actual < siguiente) ? 1 : 0)); }
    });
} //FIN ORDENAR

} //FIN CLIENTE_VISTA
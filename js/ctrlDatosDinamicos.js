function listarCarrito(){
    $('#tablaCarrito').empty();
    
    for(var i=0; i<productos.length;i++){
        row = $("<tr></tr>");
        
        colImagen = $("<td></td>");
        colProducto = $("<td>"+productos[i]['producto']+"</td>");
        colPrecio = $("<td> $"+productos[i]['precio']+"</td>");
        colComentarios = $("<td>"+productos[i]['comentarios']+ "</td>");
        colAcciones = $("<td></td>");
        
        img = $("<img/>");
        $(img).attr("src", "http://localhost/IAW-PF/img/comidas/"+productos[i]['id']+".png");
        
        icon_d = $("<i></i>");
        $(icon_d).attr("class", "material-icons");
        $(icon_d).text("delete");
        
        icon_c = $("<i></i>");
        $(icon_c).attr("class", "material-icons");
        $(icon_c).text("comment");
        
        link_d = $("<a></a>");
        $(link_d).attr("class", "btn waves-effects");
        $(link_d).attr("onclick", "quitarProducto("+i+")");
               
        link_c = $("<a></a>");
        $(link_c).attr("class", "btn waves-effects");
        $(link_c).attr("onclick", "comentarProducto("+i+")");
        
        $(colImagen).append(img);
        $(link_d).append(icon_d);
        $(link_c).append(icon_c);
        $(colAcciones).append(link_c);
        $(colAcciones).append(link_d);
        $(row).append(colImagen);
        $(row).append(colProducto);
        $(row).append(colPrecio);
        $(row).append(colComentarios);
        $(row).append(colAcciones);
        
        $('#tablaCarrito').append(row);
    }
    
    for(var i=0; i<promociones.length;i++){
        row = $("<tr></tr>");
        
        colImagen = $("<td></td>");
        colNombre = $("<td>"+promociones[i]['nombre']+"</td>");
        colPrecio = $("<td> $"+promociones[i]['precio']+"</td>");
        colComentarios = $("<td>"+promociones[i]['comentarios']+ "</td>");
        colAcciones = $("<td></td>");
        
        img = $("<img/>");
        $(img).attr("src", "http://localhost/IAW-PF/img/comidas/promo.png");
        
        icon_d = $("<i></i>");
        $(icon_d).attr("class", "material-icons");
        $(icon_d).text("delete");
        
        icon_c = $("<i></i>");
        $(icon_c).attr("class", "material-icons");
        $(icon_c).text("comment");
        
        link_d = $("<a></a>");
        $(link_d).attr("class", "btn waves-effects");
        $(link_d).attr("onclick", "quitarPromocion("+i+")");
        
        link_c = $("<a></a>");
        $(link_c).attr("class", "btn waves-effects ");
        $(link_c).attr("onclick", "comentarPromocion("+i+")");
        
        $(colImagen).append(img);
        $(link_d).append(icon_d);
        $(link_c).append(icon_c);
        $(colAcciones).append(link_c);
        $(colAcciones).append(link_d);
        $(row).append(colImagen);
        $(row).append(colNombre);
        $(row).append(colPrecio);
        $(row).append(colComentarios);
        $(row).append(colAcciones);
        
        $('#tablaCarrito').append(row);
    }  
}

function listarConfirmados(respuesta){
    listarCarrito();
    var productos = respuesta['data'];
        
}
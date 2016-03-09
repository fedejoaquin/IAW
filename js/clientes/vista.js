var cliente_vista = {

mensaje : function(mensaje, tiempo, clase){
    Materialize.toast(mensaje, tiempo ,clase);
},

calcular_estado : function (fecha_p, fecha_s){
    var salida;
    if (fecha_s !== null){
        salida = 'Para entregar';
    }else{
        if (fecha_p !== null){
            salida = 'En cocina...';
        }else{
            salida = 'Procesando...';
        }
    }
    return salida;
},

listar_carrito : function (){
    $('#tablaCarrito').empty();
    
    for(var i=0; i<cliente.productos.length;i++){
        row = $("<tr></tr>");
        
        colImagen = $("<td></td>");
        colProducto = $("<td>"+cliente.productos[i]['producto']+"</td>");
        colPrecio = $("<td> $"+cliente.productos[i]['precio']+"</td>");
        colComentarios = $("<td>"+cliente.productos[i]['comentarios']+ "</td>");
        colAcciones = $("<td></td>");
        
        img = $("<img/>");
        $(img).attr("src", "http://localhost/IAW-PF/img/comidas/"+cliente.productos[i]['id']+".png");
        
        icon_d = $("<i></i>");
        $(icon_d).attr("class", "material-icons");
        $(icon_d).text("delete");
        
        icon_c = $("<i></i>");
        $(icon_c).attr("class", "material-icons");
        $(icon_c).text("comment");
        
        link_d = $("<a></a>");
        $(link_d).attr("class", "btn waves-effects");
        $(link_d).attr("onclick", "cliente.producto.quitar("+i+")");
               
        link_c = $("<a></a>");
        $(link_c).attr("class", "btn waves-effects");
        $(link_c).attr("onclick", "cliente.producto.comentar("+i+")");
        
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
    
    for(var i=0; i<cliente.promociones.length;i++){
        row = $("<tr></tr>");
        
        colImagen = $("<td></td>");
        colNombre = $("<td>"+cliente.promociones[i]['nombre']+"</td>");
        colPrecio = $("<td> $"+cliente.promociones[i]['precio']+"</td>");
        colComentarios = $("<td>"+cliente.promociones[i]['comentarios']+ "</td>");
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
        $(link_d).attr("onclick", "cliente.promocion.quitar("+i+")");
        
        link_c = $("<a></a>");
        $(link_c).attr("class", "btn waves-effects ");
        $(link_c).attr("onclick", "cliente.promocion.comentar("+i+")");
        
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
},

listar_confirmados : function(data){
    cliente_vista.listar_carrito();
    
    var productos = data['productos'];
    var promociones = data['promociones'];
        
    $('#tablaConfirmados').empty();
       
    for(var i=0; i<productos.length;i++){
        row = $("<tr></tr>");

        colProducto = $("<td>"+productos[i]['nombre_producto']+"</td>");
        colPrecio = $("<td> $"+productos[i]['precio']+"</td>");
       
        var pedidor = productos[i]['id_pedidor'] + " | " + productos[i]['nombre_pedidor'];
        colPedidor = $("<td>"+pedidor+"</td>");
        
        var estado = cliente_vista.calcular_estado(productos[i]['fecha_p'], productos[i]['fecha_s']);
        colEstado = $("<td>"+estado+"</td>");
        colEstado.attr('id', 'col_'+i);

        $(row).append(colPedidor);
        $(row).append(colProducto);
        $(row).append(colPrecio);
        $(row).append(colEstado);

       $('#tablaConfirmados').append(row);
    }
    
    for(var i=0; i<promociones.length;i++){
        row = $("<tr></tr>");

        colPromocion = $("<td>"+promociones[i]['nombre_promocion']+"</td>");
        colPrecio = $("<td> $"+promociones[i]['precio']+"</td>");
       
        var pedidor = promociones[i]['id_pedidor'] + " | " + promociones[i]['nombre_pedidor'];
        colPedidor = $("<td>"+pedidor+"</td>");
        
        var estado = cliente_vista.calcular_estado(promociones[i]['fecha_p'], promociones[i]['fecha_s']);
        colEstado = $("<td>"+estado+"</td>");
        colEstado.attr('id', 'col_'+i);
           
        $(row).append(colPedidor);
        $(row).append(colPromocion);
        $(row).append(colPrecio);
        $(row).append(colEstado);

       $('#tablaConfirmados').append(row);
    }
},

comentar : function(comentario){
    $('#inputComentario').val(comentario);
    $('#modalComentarios').openModal();
}

} //FIN CLIENTE_VISTA









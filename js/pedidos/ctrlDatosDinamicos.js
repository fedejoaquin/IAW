$( document ).ready(function(){
    controlAjax();
});

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

function calcularEstado(fecha_p, fecha_s){
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
}

function listarConfirmados(data){
    listarCarrito();
    var productos = data['productos'];
    var promociones = data['promociones'];
        
    $('#tablaConfirmados').empty();
       
    for(var i=0; i<productos.length;i++){
        row = $("<tr></tr>");

        colProducto = $("<td>"+productos[i]['nombre_producto']+"</td>");
        colPrecio = $("<td> $"+productos[i]['precio']+"</td>");
       
        var pedidor = productos[i]['id_pedidor'] + " | " + productos[i]['nombre_pedidor'];
        colPedidor = $("<td>"+pedidor+"</td>");
        
        var estado = calcularEstado(productos[i]['fecha_p'], productos[i]['fecha_s']);
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
        
        var estado = calcularEstado(productos[i]['fecha_p'], productos[i]['fecha_s']);
        colEstado = $("<td>"+estado+"</td>");
        colEstado.attr('id', 'col_'+i);
           
        $(row).append(colPedidor);
        $(row).append(colPromocion);
        $(row).append(colPrecio);
        $(row).append(colEstado);

       $('#tablaConfirmados').append(row);
    }
}

function controlAjax(){
    $.ajax({
        data:  {},
        url:   '/IAW-PF/menu/estado_mesa',
        type:  'get',
        success: function (response){
            var respuesta = JSON.parse(response);
            if (respuesta['error'] === undefined){
                listarConfirmados(respuesta['data']);
            }
        }
    });
    setTimeout("controlAjax()",10000);
}
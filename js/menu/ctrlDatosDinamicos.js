function actualizar_post_modificacion(id_fila, cambios_seccion, cambios_lista){
    var lblSeccionNueva = $("#selectSeccion option:selected").text();
    var lblListaPrecio = $("#selectListaPrecio option:selected").text();
    
    if (cambios_seccion !== '-1'){
        $('#fila'+ id_fila).find('td:eq(1)').text(lblSeccionNueva); 
    }
    
    if (cambios_lista !== '-1'){
        var split = lblListaPrecio.split("-");
        var lblListaNueva = split[0];
        var lblPrecioNuevo = split[1];
        $('#fila'+ id_fila).find('td:eq(3)').text(lblListaNueva);
        $('#fila'+ id_fila).find('td:eq(4)').text(lblPrecioNuevo);
    }
    $('#tablaEditarProducto').empty();
    $('#editarProducto').closeModal();
}

function rellenar_tabla_producto(id_producto_infocarta, datos){
    $('#tablaEditarProducto').empty();
    
    $('#btnConfirmarEdicion').attr("onClick", "postEditarProducto("+id_producto_infocarta+")");
    
    row_clonada = $('#fila'+id_producto_infocarta).clone();
    $(row_clonada).find("td:last").remove();
    $('#tablaEditarProducto').append(row_clonada);
    
    var secciones = datos['secciones'];
    var listaPrecio = datos['listaPrecios'];
    
    option = $("<option></option>");
    $(option).text('Sin cambios');
    $(option).attr("class", "selected");
    $(option).attr("value", "-1");
    
    $('#selectSeccion').empty();
    $('#selectSeccion').append(option);
    
    option_1 = $("<option></option>");
    $(option_1).text('Sin cambios');
    $(option_1).attr("class", "selected");
    $(option_1).attr("value", "-1");
    
    $('#selectListaPrecio').empty();
    $('#selectListaPrecio').append(option_1);
          
    for(i=0; i<secciones.length; i++){
       var tupla = secciones[i];
        
        option = $("<option></option>");
        $(option).text(tupla['nombre']);
        $(option).attr("value", tupla['id']);
        
        $('#selectSeccion').append(option); 
    }
    
    for(i=0; i<listaPrecio.length; i++){
       var tupla = listaPrecio[i];
        
        option = $("<option></option>");
        $(option).text(tupla['nombre_lista_precio'] + " - $" + tupla['precio_producto']);
        $(option).attr("value", tupla['id_lista_precio']);
        
        $('#selectListaPrecio').append(option); 
    }
    
    //Reinicio los selects para una correcta visualización
    $('#selectSeccion').material_select();
    $('#selectListaPrecio').material_select();
    $('#editarProducto').openModal();
}

function autocompletar_productos(datos){
    var cantidad = datos['cantidad'];
    var productos = datos['productos'];
    
    $('#lblBusqueda').text(cantidad + ' resultado/s disponible/s.');
    
    option = $("<option></option>");
    $(option).text('Sin cambios');
    $(option).attr("class", "selected");
    $(option).attr("value", "-1");
    
    $('#selectAltaProducto').empty();
    $('#selectAltaProducto').append(option);

    for(i=0; i<productos.length; i++){
        option_1 = $("<option></option>");
        $(option_1).text(productos[i]['nombre']);
        $(option_1).attr("value", productos[i]['id']);
        
        $('#selectAltaProducto').append(option_1); 
    }
    
    $('#selectAltaProducto').material_select();
}
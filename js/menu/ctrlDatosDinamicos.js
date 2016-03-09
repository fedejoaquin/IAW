
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

function agregar_nuevo_producto(datos){
    var id_producto = datos['id_producto'];
    var nombre_producto = $('#selectAltaProducto option:selected').text();
    var nombre_seccion = $('#selectAltaSeccion option:selected').text();
    var split = $('#selectAltaListaPrecio option:selected').text().split("-");
    var nombre_lp = split[0];
    var precio = split[1];
    
    var tr = $("<tr></tr>");
    $(tr).attr('id', 'fila'+datos['id']);
    
    var td = $('<td></td>');
    $(td).text(id_producto);
    $(tr).append(td);
    
    td = $('<td></td>');
    $(td).text(nombre_seccion);
    $(tr).append(td);
    
    td = $('<td></td>');
    $(td).text(nombre_producto);
    $(tr).append(td);
   
    td = $('<td></td>');
    $(td).text(nombre_lp);
    $(tr).append(td);
    
    td = $('<td></td>');
    $(td).text(precio);
    $(tr).append(td);
    
    var i_edit = $('<i></i>');
    $(i_edit).attr('class','material-icons');
    $(i_edit).text('edit');
    
    var i_delete = $('<i></i>');
    $(i_delete).attr('class','material-icons');
    $(i_delete).text('delete');

    /** 
    <a class="btn waves-effect waves-green" onClick="preEditarProducto(id_info_lista)">
        <i class="material-icons">edit</i>
    </a> 
    **/    
    var a = $('<a></a>');
    $(a).attr('class', 'btn waves-effect waves-green');
    $(a).attr('onClick', 'preEditarProducto('+datos['id']+','+id_producto+')');
    $(a).append(i_edit);
      
    /**
    <a class='dropdown-button btn' data-activates='dropID'><i class="material-icons">delete</i></a>
    **/     
    var a_1 = $('<a></a>');
    $(a_1).attr('class', 'dropdown-button btn');
    $(a_1).attr('data-activates', 'drop'+id_producto);
    $(a_1).append(i_delete);
    
    var ul = $('<ul></ul>');
    $(ul).attr('id', 'drop'+id_producto);
    $(ul).attr('class', 'dropdown-content' );
    
    var li = $('<li></li>');
    $(li).text('¿Confirma?');
    
    var li_2 = $('<li></li>');
    $(li_2).attr('class','divider');
    
    var a_3 = $('<a></a>');
    $(a_3).text('Sí');
    $(a_3).attr('onClick','eliminarProducto('+datos['id']+')');
    
    var li_3 = $('<li></li>');
    $(li_3).append(a_3);
    
    var a_4 = $('<a></a>');
    $(a_4).text('No');
    
    var li_4 = $('<li></li>');
    $(li_4).append(a_4);
    
    $(ul).append(li);
    $(ul).append(li_2);
    $(ul).append(li_3);
    $(ul).append(li_4);
    
    td = $('<td></td>');
    $(td).append(a);
    $(td).append(a_1);
    $(td).append(ul);
    $(tr).append(td);
    
    $('.dropdown-button').dropdown({
        inDuration: 300,
        outDuration: 225,
        constrain_width: false, // Does not change width of dropdown to that of the activator
        hover: false, // Activate on hover
        gutter: 0, // Spacing from edge
        belowOrigin: false, // Displays dropdown below the button
        alignment: 'left' // Displays dropdown with edge aligned to the left of button
    });
    
    $('#tablaProductos').append(tr);
    $('#altaProducto').closeModal();
}

function listar_promociones(datos){
    var promociones = datos['promociones'];
    
    if (promociones.lenght>0){
        
        for(i=0; i<promociones.length; i++){
            
            td = $('<td></td>');
            $(td).text(promociones[i]['id']);
            
            td_1 = $('<td></td>');
            
        
        }
    
        $('#altaPromocion').openModal();
        
    }else{
        Materialize.toast('No hay promociones disponibles.',2500,'toast-error');
    }
}

function resetear_select( nombre ){
    option = $("<option></option>");
    $(option).text('Sin cambios');
    $(option).attr("selected");
    $(option).attr("value", "-1");
    
    $('#'+nombre).empty();
    $('#'+nombre).append(option);
}

function reset_modal_alta(){
    $('#lblBusqueda').text('Sin resultados...');
    $('#inputBusqueda').val('');
    resetear_select('selectAltaProducto');
    resetear_select('selectAltaSeccion');
    resetear_select('selectAltaListaPrecio');
    $('#selectAltaProducto').material_select();
    $('#selectAltaSeccion').material_select();
    $('#selectAltaListaPrecio').material_select();
}

function autocompletar_productos(datos){
    var cantidad = datos['cantidad'];
    var productos = datos['productos'];
    
    $('#lblBusqueda').text(cantidad + ' resultado/s disponible/s.');
    
    resetear_select('selectAltaProducto');
    
    for(i=0; i<productos.length; i++){
        option_1 = $("<option></option>");
        $(option_1).text(productos[i]['nombre']);
        $(option_1).attr("value", productos[i]['id']);
        
        $('#selectAltaProducto').append(option_1); 
    }
    
    $('#selectAltaProducto').material_select();
}

function autocompletar_info_producto(datos){
    var secciones = datos['secciones'];
    var listaPrecio = datos['listaPrecios'];
    
    resetear_select('selectAltaSeccion');
    resetear_select('selectAltaListaPrecio');
    
    for(i=0; i<secciones.length; i++){
        var tupla = secciones[i];
        
        option = $("<option></option>");
        $(option).text(tupla['nombre']);
        $(option).attr("value", tupla['id']);
        
        $('#selectAltaSeccion').append(option); 
    }
    
    for(i=0; i<listaPrecio.length; i++){
       var tupla = listaPrecio[i];
        
        option = $("<option></option>");
        $(option).text(tupla['nombre_lista_precio'] + " - $" + tupla['precio_producto']);
        $(option).attr("value", tupla['id_lista_precio']);
        
        $('#selectAltaListaPrecio').append(option); 
    }
    
    $('#selectAltaSeccion').removeAttr('disabled');
    $('#selectAltaListaPrecio').removeAttr('disabled');
    
    //Reinicio los selects para una correcta visualización
    $('#selectAltaSeccion').material_select();
    $('#selectAltaListaPrecio').material_select();
}
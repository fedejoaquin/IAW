var menu_vista = {

preAlta : function(datos){
    rest_dia = datos['restricciones_dia'];
    rest_hora = datos['restricciones_hora'];
    
    menu_vista.resetear_select('selectHora');
    menu_vista.resetear_select('selectDia');
    
    for(i=0; i<rest_dia.length; i++){
        option_1 = $("<option></option>");
        $(option_1).text(rest_dia[i]['nombre_restriccion']);
        $(option_1).attr("value", rest_dia[i]['id']);

        $('#selectDia').append(option_1); 
    }
    
    for(i=0; i<rest_hora.length; i++){
        option_1 = $("<option></option>");
        $(option_1).text(rest_hora[i]['nombre_restriccion']);
        $(option_1).attr("value", rest_hora[i]['id']);

        $('#selectHora').append(option_1); 
    }

    $('#nombreMenu').val('');
    $('#selectDia').material_select();
    $('#selectHora').material_select();
    $('#altaMenu').openModal();
},

postAlta : function(datos){
    var id_menu = datos['id'];
    var nombre = datos['nombre'];
    var creador = datos['creador'];
    
    tr = $("<tr></tr>");
    $(tr).attr('id', 'fm'+id_menu);

    td = $('<td></td>');
    $(td).text(id_menu);
    $(tr).append(td);
    
    td = $('<td></td>');
    $(td).text(nombre);
    $(tr).append(td);

    td = $('<td></td>');
    $(td).text(creador);
    $(tr).append(td);
    
    i_info = $('<i></i>');
    $(i_info).attr('class','material-icons');
    $(i_info).text('info');

    i_edit = $('<i></i>');
    $(i_edit).attr('class','material-icons');
    $(i_edit).text('edit');

    i_delete = $('<i></i>');
    $(i_delete).attr('class','material-icons');
    $(i_delete).text('delete');

    /** 
    <a class="btn waves-effect waves-green" href="IAW-PF/menu/ver/$id">
        <i class="material-icons">edit</i>
    </a> 
    **/    
    a = $('<a></a>');
    $(a).attr('class', 'boton btn-base-mini waves-effect transparent');
    $(a).attr('href', '/IAW-PF/menu/ver/'+id_menu);
    $(a).append(i_info);
    
    /** 
    <a class="btn waves-effect waves-green" href="IAW-PF/menu/editar/$id">
        <i class="material-icons">edit</i>
    </a> 
    **/ 
    a_1 = $('<a></a>');
    $(a_1).attr('class', 'boton btn-base-mini waves-effect transparent');
    $(a_1).attr('href', '/IAW-PF/menu/editar/'+id_menu);
    $(a_1).append(i_edit);

    /**
    <a class='dropdown-button btn' data-activates='dropID'><i class="material-icons">delete</i></a>
    **/     
    a_2 = $('<a></a>');
    $(a_2).attr('class', 'boton btn-base-mini waves-effect transparent dropdown-button');
    $(a_2).attr('data-activates', 'dm'+id_menu);
    $(a_2).append(i_delete);

    ul = $('<ul></ul>');
    $(ul).attr('id', 'dm'+id_menu);
    $(ul).attr('class', 'dropdown-content' );

    li = $('<li></li>');
    $(li).text('¿Confirma?');

    li_2 = $('<li></li>');
    $(li_2).attr('class','divider');

    a_3 = $('<a></a>');
    $(a_3).text('Sí');
    $(a_3).attr('onClick','menu.eliminar('+id_menu+')');

    li_3 = $('<li></li>');
    $(li_3).append(a_3);

    a_4 = $('<a></a>');
    $(a_4).text('No');

    li_4 = $('<li></li>');
    $(li_4).append(a_4);

    $(ul).append(li);
    $(ul).append(li_2);
    $(ul).append(li_3);
    $(ul).append(li_4);

    td = $('<td></td>');
    $(td).append(a);
    $(tr).append(td);
    
    td = $('<td></td>');
    $(td).append(a_1);
    $(tr).append(td);
    
    td = $('<td></td>');
    $(td).append(a_2);
    $(td).append(ul);
    $(tr).append(td);

    $('#tablaMenues').append(tr);
    $('#altaMenu').closeModal();
    
    auxiliar.reset_dropdown();
},

eliminar : function(id){
    $('#fm'+id).remove();
},

resetear_select : function ( nombre ){
    option = $("<option></option>");
    $(option).text('Sin cambios');
    $(option).attr("selected");
    $(option).attr("value", "-1");
    
    $('#'+nombre).empty();
    $('#'+nombre).append(option);
},

producto : {
    abrir_modal : function(){
        $('#altaProducto').openModal();
    },
    
    cerrar_modal : function(){
        $('#altaProducto').closeModal();
    },
    
    reset_modal : function() {
        $('#lblBusqueda').text('Sin resultados...');
        $('#inputBusqueda').val('');
        menu_vista.resetear_select('selectAltaProducto');
        menu_vista.resetear_select('selectAltaSeccion');
        menu_vista.resetear_select('selectAltaListaPrecio');
        $('#selectAltaProducto').material_select();
        $('#selectAltaSeccion').material_select();
        $('#selectAltaListaPrecio').material_select();
    },
    
    autocompletar : function (datos){
        var cantidad = datos['cantidad'];
        var productos = datos['productos'];

        $('#lblBusqueda').text(cantidad + ' resultado/s disponible/s.');

        menu_vista.resetear_select('selectAltaProducto');

        for(i=0; i<productos.length; i++){
            option_1 = $("<option></option>");
            $(option_1).text(productos[i]['nombre']);
            $(option_1).attr("value", productos[i]['id']);

            $('#selectAltaProducto').append(option_1); 
        }

        $('#selectAltaProducto').material_select();
    },
    
    autocompletar_info : function(datos){
        var secciones = datos['secciones'];
        var listaPrecio = datos['listaPrecios'];

        menu_vista.resetear_select('selectAltaSeccion');
        menu_vista.resetear_select('selectAltaListaPrecio');

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
    },
    
    alta : function (datos){
        var id_producto = datos['id_producto'];
        var nombre_producto = $('#selectAltaProducto option:selected').text();
        var nombre_seccion = $('#selectAltaSeccion option:selected').text();
        var split = $('#selectAltaListaPrecio option:selected').text().split("-");
        var nombre_lp = split[0];
        var precio = split[1];

        var tr = $("<tr></tr>");
        $(tr).attr('id', 'fprod'+datos['id']);

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
        <a class="btn waves-effect waves-green" onClick="menu.producto.preEditar(id_info_lista)">
            <i class="material-icons">edit</i>
        </a> 
        **/    
        var a = $('<a></a>');
        $(a).attr('class', 'boton btn-base-mini waves-effect transparent');
        $(a).attr('onClick', 'menu.producto.preEditar('+datos['id']+','+id_producto+')');
        $(a).append(i_edit);

        /**
        <a class='dropdown-button btn' data-activates='dropID'><i class="material-icons">delete</i></a>
        **/     
        var a_1 = $('<a></a>');
        $(a_1).attr('class', 'boton btn-base-mini waves-effect transparent dropdown-button');
        $(a_1).attr('data-activates', 'dprod'+id_producto);
        $(a_1).append(i_delete);

        var ul = $('<ul></ul>');
        $(ul).attr('id', 'dprod'+id_producto);
        $(ul).attr('class', 'dropdown-content' );

        var li = $('<li></li>');
        $(li).text('¿Confirma?');

        var li_2 = $('<li></li>');
        $(li_2).attr('class','divider');

        var a_3 = $('<a></a>');
        $(a_3).text('Sí');
        $(a_3).attr('onClick','menu.producto.eliminar('+datos['id']+')');

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
        $(tr).append(td);
        
        td = $('<td></td>');
        $(td).append(a_1);
        $(td).append(ul);
        $(tr).append(td);

        $('#tablaProductos').append(tr);
        
        menu_vista.producto.cerrar_modal();
        auxiliar.reset_dropdown();
    },
    
    eliminar : function(id){
        $('#fprod'+id).remove();
    },
    
    preEditar : function(id_producto_infocarta, datos){
        $('#tablaEditarProducto').empty();

        $('#btnConfirmarEdicion').attr("onClick", "menu.producto.postEditar("+id_producto_infocarta+")");

        row_clonada = $('#fprod'+id_producto_infocarta).clone();
        $(row_clonada).find("td:last").remove();
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
    },
    
    postEditar : function(id_fila, cambios_seccion, cambios_lista){
        var lblSeccionNueva = $("#selectSeccion option:selected").text();
        var lblListaPrecio = $("#selectListaPrecio option:selected").text();

        if (cambios_seccion !== '-1'){
            $('#fprod'+ id_fila).find('td:eq(1)').text(lblSeccionNueva); 
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
}, //FIN PRODUCTO

promocion : {
    alta : function (datos){
        var id_promocion = datos['id'];
        var nombre_promocion = datos['nombre'];
        var precio = datos['precio'];

        tr = $("<tr></tr>");
        $(tr).attr('id', 'fprom'+id_promocion);

        td = $('<td></td>');
        $(td).text(id_promocion);
        $(tr).append(td);

        td = $('<td></td>');
        $(td).text(nombre_promocion);
        $(tr).append(td);

        td = $('<td></td>');
        $(td).text('$'+precio);
        $(tr).append(td);

        i_info = $('<i></i>');
        $(i_info).attr('class','material-icons');
        $(i_info).text('info');

        a = $('<a></a>');
        $(a).attr('class', 'boton btn-base-mini waves-effect transparent');
        $(a).attr('href', '/IAW-PF/promociones/ver/'+id_promocion);
        $(a).append(i_info);

        i_delete = $('<i></i>');
        $(i_delete).attr('class','material-icons');
        $(i_delete).text('delete');

        a_1 = $('<a></a>');
        $(a_1).attr('class', 'boton btn-base-mini waves-effect transparent dropdown-button');
        $(a_1).attr('data-activates', 'dprom'+id_promocion);
        $(a_1).append(i_delete);

        ul = $('<ul></ul>');
        $(ul).attr('id', 'dprom'+id_promocion);
        $(ul).attr('class', 'dropdown-content' );

        li = $('<li></li>');
        $(li).text('¿Confirma?');

        li_2 = $('<li></li>');
        $(li_2).attr('class','divider');

        a_2 = $('<a></a>');
        $(a_2).text('Sí');
        $(a_2).attr('onClick','menu.promocion.eliminar('+id_promocion+')');

        li_3 = $('<li></li>');
        $(li_3).append(a_2);

        a_3 = $('<a></a>');
        $(a_3).text('No');

        li_4 = $('<li></li>');
        $(li_4).append(a_3);

        $(ul).append(li);
        $(ul).append(li_2);
        $(ul).append(li_3);
        $(ul).append(li_4);

        td = $('<td></td>');
        $(td).append(a);
        $(tr).append(td);
        
        td = $('<td></td>');
        $(td).append(a_1);
        $(td).append(ul);
        $(tr).append(td);

        $('#tablaPromocion').append(tr);
        $('#altaPromocion').closeModal();

        auxiliar.reset_dropdown();
    },
    
    eliminar : function(id){
        $('#fprom'+id).remove();
    },

    preAlta : function (datos){
        var promociones = datos['promociones'];

        $('#selectAltaPromocion').empty();

        option = $("<option></option>");
        $(option).text('Sin cambios');
        $(option).attr("class", "selected");
        $(option).attr("value", "-1");    

        $('#selectAltaPromocion').append(option);

        for(i=0; i<promociones.length; i++){

            text = promociones[i]['nombre'] + " || Valor $" + promociones[i]['precio'];

            option = $("<option></option>");
            $(option).text(text);
            $(option).attr("value", promociones[i]['id']); 

            $('#selectAltaPromocion').append(option);
        }

        $('#selectAltaPromocion').material_select();
        $('#altaPromocion').openModal();
    },

    seleccionaAlta : function (datos){
        var productos = datos['promocion'];

        $('#tablaAltaPromocion').empty();

        for(i=0; i<productos.length; i++){
            td = $('<td></td>');
            $(td).text(productos[i]['id_producto']);

            td_1 = $('<td></td>');
            $(td_1).text(productos[i]['nombre_producto']);

            tr = $("<tr></tr>");
            $(tr).append(td);
            $(tr).append(td_1);

            $('#tablaAltaPromocion').append(tr);
        }
    }
    
} //FIN PROMOCION   


} //FIN MENU_VISTA

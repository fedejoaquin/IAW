var promociones_vista = {
    
eliminar : function(id){
    $('#fp'+id).remove();
    
}, // FIN ELIMINAR

resetear_select : function ( nombre ){
    option = $("<option></option>");
    $(option).text('Sin cambios');
    $(option).attr("selected");
    $(option).attr("value", "-1");
    
    $('#'+nombre).empty();
    $('#'+nombre).append(option);
}, // FIN RESETEAR SELECT

reset_dropdown : function (){
    $('.dropdown-button').dropdown({
        inDuration: 300,
        outDuration: 225,
        constrain_width: false, // Does not change width of dropdown to that of the activator
        hover: false, // Activate on hover
        gutter: 0, // Spacing from edge
        belowOrigin: false, // Displays dropdown below the button
        alignment: 'left' // Displays dropdown with edge aligned to the left of button
    });
}, // FIN RESET DROPDOWN

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
        promociones_vista.resetear_select('selectAltaProducto');
        $('#selectAltaProducto').material_select();
    },
    
    autocompletar : function (datos){
        var cantidad = datos['cantidad'];
        var productos = datos['productos'];

        $('#lblBusqueda').text(cantidad + ' resultado/s disponible/s.');

        promociones_vista.resetear_select('selectAltaProducto');

        for(i=0; i<productos.length; i++){
            option_1 = $("<option></option>");
            $(option_1).text(productos[i]['nombre']);
            $(option_1).attr("value", productos[i]['id']);

            $('#selectAltaProducto').append(option_1); 
        }

        $('#selectAltaProducto').material_select();
    },
    
    alta : function (datos){
        var id_producto = datos['id_producto'];
        var nombre_producto = $('#selectAltaProducto option:selected').text();

        var tr = $("<tr></tr>");
        $(tr).attr('id', 'fprod'+datos['id']);

        var td = $('<td></td>');
        $(td).text(id_producto);
        $(tr).append(td);

        td = $('<td></td>');
        $(td).text(nombre_producto);
        $(tr).append(td);

        var i_delete = $('<i></i>');
        $(i_delete).attr('class','material-icons');
        $(i_delete).text('delete');

        /**
        <a class='dropdown-button btn' data-activates='dropID'><i class="material-icons">delete</i></a>
        **/     
        var a_1 = $('<a></a>');
        $(a_1).attr('class', 'dropdown-button btn');
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
        $(a_3).attr('onClick','promociones.producto.eliminar('+datos['id']+')');

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
        $(td).append(a_1);
        $(td).append(ul);
        $(tr).append(td);

        $('#tablaProductos').append(tr);
        
        promociones_vista.producto.cerrar_modal();
        promociones_vista.reset_dropdown();
    },
    
    eliminar : function(id){
        $('#fprod'+id).remove();
    }
    
}, //FIN PRODUCTO

promocion : {
    abrir_modal : function(){
        $('#altaPromocion').openModal();
    },
    
    cerrar_modal : function(){
        $('#altaPromocion').closeModal();
    },
    
    reset_modal : function() {
        $('#nombrePromocion').val('');
        $('#precioPromocion').val('');
    }, 
    
    alta : function(datos){
        var id_promocion = datos['id'];
        var nombre_promocion = datos['nombre'];
        var precio_promocion = datos['precio'];

        tr = $("<tr></tr>");
        $(tr).attr('id', 'fprom'+id_promocion);
        
        td = $('<td></td>');
        $(td).text(id_promocion);
        $(tr).append(td);

        td = $('<td></td>');
        $(td).text(nombre_promocion);
        $(tr).append(td);

        td = $('<td></td>');
        $(td).text('$'+precio_promocion);
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
        <a class="btn waves-effect waves-green" href="/IAW-PF/promociones/ver/".$id; ?>"><i class="material-icons">info</i></a>
        */     
        a = $('<a></a>');
        $(a).attr('class', 'btn waves-effect waves-green');
        $(a).attr('href', '/IAW-PF/promociones/ver/'+id_promocion);
        $(a).append(i_info);
        
        /**
        <a class="btn waves-effect waves-green" href="/IAW-PF/promociones/editar/".$id; ?>"><i class="material-icons">edit</i></a>
        */     
        a_1 = $('<a></a>');
        $(a_1).attr('class', 'btn waves-effect waves-green');
        $(a_1).attr('href', '/IAW-PF/promociones/editar/'+id_promocion);
        $(a_1).append(i_edit);
        
        /**
        <a class='dropdown-button btn' data-activates='dropID'><i class="material-icons">delete</i></a>
        **/     
        a_2 = $('<a></a>');
        $(a_2).attr('class', 'dropdown-button btn');
        $(a_2).attr('data-activates', 'dprom'+id_promocion);
        $(a_2).append(i_delete);

        ul = $('<ul></ul>');
        $(ul).attr('id', 'dprom'+id_promocion);
        $(ul).attr('class', 'dropdown-content' );

        li = $('<li></li>');
        $(li).text('¿Confirma?');

        li_2 = $('<li></li>');
        $(li_2).attr('class','divider');

        a_3 = $('<a></a>');
        $(a_3).text('Sí');
        $(a_3).attr('onClick','promociones.promocion.eliminar('+id_promocion+')');

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
        $(td).append(a_1);
        $(td).append(a_2);
        $(td).append(ul);
        $(tr).append(td);

        $('#tablaPromociones').append(tr);
        
        promociones_vista.promocion.cerrar_modal();
        promociones_vista.reset_dropdown();  
    }
} //FIN PROMOCION

} //FIN MENU_VISTA

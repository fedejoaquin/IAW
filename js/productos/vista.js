var productos_vista = {
    
eliminar : function(id){
    $('#fp'+id).remove();
},
    
mensaje : function(mensaje, tiempo, clase){
    Materialize.toast(mensaje, tiempo ,clase);
},

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
},

producto : {
    abrir_modal : function(){
        $('#altaProducto').openModal();
    },
    
    cerrar_modal : function(){
        $('#altaProducto').closeModal();
    },
    
    reset_modal : function() {
        $('#nombreProducto').val('');
        $('#inputFile').val('');
    },
    
    alta : function (datos){
        var id_producto = datos['id'];
        var nombre_producto = datos['nombre'];

        tr = $("<tr></tr>");
        $(tr).attr('id', 'fp'+id_producto);

        td = $('<td></td>');
        $(td).text(id_producto);
        $(tr).append(td);

        td = $('<td></td>');
        $(td).text('IMAGEN');
        $(tr).append(td);
        
        td = $('<td></td>');
        $(td).text(nombre_producto);
        $(tr).append(td);

        i_delete = $('<i></i>');
        $(i_delete).attr('class','material-icons');
        $(i_delete).text('delete');
        
        i_edit = $('<i></i>');
        $(i_edit).attr('class','material-icons');
        $(i_edit).text('edit');
        
        /**
        <a class="btn waves-effect waves-green" onClick="productos.producto.preEditar($id); ?>"><i class="material-icons">edit</i></a>
        */     
        a = $('<a></a>');
        $(a).attr('class', 'btn waves-effect waves-green');
        $(a).attr('onClick', 'productos.producto.preEditar('+id_producto+')');
        $(a).append(i_edit);

        /**
        <a class='dropdown-button btn' data-activates='dropID'><i class="material-icons">delete</i></a>
        **/     
        a_1 = $('<a></a>');
        $(a_1).attr('class', 'dropdown-button btn');
        $(a_1).attr('data-activates', 'dprod'+id_producto);
        $(a_1).append(i_delete);

        ul = $('<ul></ul>');
        $(ul).attr('id', 'dprod'+id_producto);
        $(ul).attr('class', 'dropdown-content' );

        li = $('<li></li>');
        $(li).text('¿Confirma?');

        li_2 = $('<li></li>');
        $(li_2).attr('class','divider');

        a_3 = $('<a></a>');
        $(a_3).text('Sí');
        $(a_3).attr('onClick','productos.eliminar('+id_producto+')');

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
        $(td).append(ul);
        $(tr).append(td);

        $('#tablaProductos').append(tr);
        
        productos_vista.producto.cerrar_modal();
        productos_vista.reset_dropdown();
    },
    
    eliminar : function(id){
        $('#fprod'+id).remove();
    }
    
} //FIN PRODUCTO

} //FIN MENU_VISTA

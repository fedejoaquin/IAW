var listaprecios_vista = {

preAlta : function(){
    $('#altaListaPrecios').openModal();
},

postAlta : function(datos){
    
},

producto : {
    info : function(datos){
        var info_producto = datos['info_producto'];
        
        $('#tblInfoProducto').empty();
        
        if (info_producto.length === 0 ){
            auxiliar.mensaje("El producto no está asociado a ninguna carta, con esta lista.", 5000, 'toast-info');
        }else{
            for(i=0; i<info_producto.length; i++){
                
                tr = $("<tr></tr>");
                
                td = $('<td></td>');
                $(td).text(info_producto[i]['nombre_carta']);
                $(tr).append(td);

                td = $('<td></td>');
                $(td).text(info_producto[i]['nombre_seccion']);
                $(tr).append(td);
                
                $('#tblInfoProducto').append(tr);
            }
            $('#infoProducto').openModal();
        }
    }
    
}, //FIN PRODUCTO

} //FIN MENU_VISTA

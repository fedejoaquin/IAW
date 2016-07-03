var mozo_vista = {

comentar : function(comentario){
    $('#inputComentario').val(comentario);
    $('#modalComentarios').openModal();
    
}, //FIN COMENTAR

carrito : {
    
    pre_confirmar : function(datos){
        var mesas = datos['mesas'];
        
        $('#selectMesa').empty();
        option = $("<option></option>");
        $(option).text("Seleccione");
        $(option).attr("value", "-1");
        $(option).attr("attr", "selected");
        $('#selectMesa').append(option);
        
        for(i=0; i<mesas.length; i++){
            option = $("<option></option>");
            $(option).text(mesas[i]['numero']);
            $(option).attr("value", mesas[i]['id']);
            $('#selectMesa').append(option); 
        }
        
        $('#selectMesa').material_select();
        $('#modalConfirmacion').openModal();
    },
    
    post_confirmar : function(){
        $('#modalConfirmacion').closeModal();
        mozo_vista.carrito.listar();
    },
    
    listar : function(){
        $('#lblTotal').val("$" + mozo.total + ".-");
        $('#tblCarritoProductos').empty();
        $('#tblCarritoPromociones').empty();
        
        for(var i=0; i<mozo.productos.length;i++){
            row = $("<tr></tr>");

            colImagen = $("<td></td>");
            colProducto = $("<td>"+mozo.productos[i]['producto']+"</td>");
            colPrecio = $("<td> $"+mozo.productos[i]['precio']+"</td>");
            colComentarios = $("<td>"+mozo.productos[i]['comentarios']+ "</td>");
            colComentar = $("<td></td>");
            colEliminar = $("<td></td>");

            img = $("<img/>");
            $(img).attr("src", "http://localhost/IAW-PF/img/comidas/"+mozo.productos[i]['id']+".png");

            icon_d = $("<i></i>");
            $(icon_d).attr("class", "material-icons");
            $(icon_d).text("delete");

            icon_c = $("<i></i>");
            $(icon_c).attr("class", "material-icons");
            $(icon_c).text("comment");

            link_d = $("<a></a>");
            $(link_d).attr("class", "boton btn-base-mini waves-effect transparent");
            $(link_d).attr("onclick", "mozo.carrito.productos.quitar("+i+")");

            link_c = $("<a></a>");
            $(link_c).attr("class", "boton btn-base-mini waves-effect transparent"); 
            $(link_c).attr("onclick", "mozo.carrito.productos.comentar("+i+")");

            $(colImagen).append(img);
            $(link_d).append(icon_d);
            $(link_c).append(icon_c);
            $(colComentar).append(link_c);
            $(colEliminar).append(link_d);
            $(row).append(colImagen);
            $(row).append(colProducto);
            $(row).append(colPrecio);
            $(row).append(colComentarios);
            $(row).append(colComentar);
            $(row).append(colEliminar);

            $('#tblCarritoProductos').append(row);
        }
    
        for(var i=0; i<mozo.promociones.length;i++){
            row = $("<tr></tr>");

            colImagen = $("<td></td>");
            colNombre = $("<td>"+mozo.promociones[i]['nombre']+"</td>");
            colPrecio = $("<td> $"+mozo.promociones[i]['precio']+"</td>");
            colComentarios = $("<td>"+mozo.promociones[i]['comentarios']+ "</td>");
            colComentar = $("<td></td>");
            colEliminar = $("<td></td>");

            img = $("<img/>");
            $(img).attr("src", "http://localhost/IAW-PF/img/comidas/promo.png");

            icon_d = $("<i></i>");
            $(icon_d).attr("class", "material-icons");
            $(icon_d).text("delete");

            icon_c = $("<i></i>");
            $(icon_c).attr("class", "material-icons");
            $(icon_c).text("comment");

            link_d = $("<a></a>");
            $(link_d).attr("class", "boton btn-base-mini waves-effect transparent");
            $(link_d).attr("onclick", "mozo.carrito.promociones.quitar("+i+")");

            link_c = $("<a></a>");
            $(link_c).attr("class", "boton btn-base-mini waves-effect transparent");
            $(link_c).attr("onclick", "mozo.carrito.promociones.comentar("+i+")");

            $(colImagen).append(img);
            $(link_d).append(icon_d);
            $(link_c).append(icon_c);
            $(colComentar).append(link_c);
            $(colEliminar).append(link_d);
            $(row).append(colImagen);
            $(row).append(colNombre);
            $(row).append(colPrecio);
            $(row).append(colComentarios);
            $(row).append(colComentar);
            $(row).append(colEliminar);

            $('#tblCarritoPromociones').append(row);
        }
    }
    
}, //FIN CARRITO

enviar_comentario : function(){
    $('#modalComentarios').closeModal();
    
}, // FIN ENVIAR COMENTARIO

notificaciones : {
    
    listar : function(datos){
        
        notificaciones = datos['notificaciones'];
        $('#lblNotificaciones').text(notificaciones.length);
        
        $('#tblNotificaciones').empty();
        
        for(i=0; i<notificaciones.length; i++){
            tr = $("<tr></tr>");
            $(tr).attr('id', "not"+notificaciones[i]['id']);
            
            td = $('<td></td>');
            $(td).text(notificaciones[i]['mensaje']);
            $(tr).append(td);
            
            i_visto = $('<i></i>');
            $(i_visto).attr('class','material-icons');
            $(i_visto).text('done_all');

            /** 
            <a class="btn waves-effect waves-green" onClick=mozo.notificaciones.marcar_visto(i)">
                <i class="material-icons">done_all</i>
            </a> 
            **/    
            a = $('<a></a>');
            $(a).attr('class', 'boton btn-base-mini waves-effects transparent');
            $(a).attr('onClick', 'mozo.notificaciones.marcar_visto('+notificaciones[i]['id']+')');
            $(a).append(i_visto);
            
            td = $('<td></td>');
            $(td).append(a);
            $(tr).append(td);
            
            $('#tblNotificaciones').append(tr);
        } 
    }, 
    
    marcar_visto : function(id){
        $('#not'+id).remove();
        cant = parseInt($('#lblNotificaciones').text()) - 1;
        $('#lblNotificaciones').text(cant);
    }
    
},//FIN NOTIFICACIONES

vincular : {
    
    preAlta : function(id){
        $('#inputMesaVinculacion').val(id);
        $('#modalVinculacion').openModal();
    },

    postAlta: function (){
        $('#modalVinculacion').closeModal();
    }
    
}, //FIN VINCULAR

mesa : {
    
    calcular_estado : function(fecha_p, fecha_s){
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
    
    cierre_parcial : function(id){
        $('#tdm'+id).text("Cierre parcial");
    }, 
    
    cierre_total : function(id){
        $('#tdm'+id).text("Cierre por cuenta");
    },
    
    listar : function(datos){
        
        mesas = datos['mesas'];
        
        $('#tblMesasActivas').empty();
        
        for(i=0; i<mesas.length; i++){
            tr = $("<tr></tr>");
            
            td = $('<td></td>');
            $(td).text(mesas[i]['id']);
            $(tr).append(td);
            
            td = $('<td></td>');
            $(td).text(mesas[i]['numero']);
            $(tr).append(td);
            
            td = $('<td></td>');
            $(td).attr('id', 'tdm'+mesas[i]['id']);
            $(td).text(mesas[i]['estado']);
            $(tr).append(td);
            
            i_vincular = $('<i></i>');
            $(i_vincular).attr('class','material-icons');
            $(i_vincular).text('fingerprint');
            
            i_info = $('<i></i>');
            $(i_info).attr('class','material-icons');
            $(i_info).text('info');
            
            i_operar = $('<i></i>');
            $(i_operar).attr('class','material-icons');
            $(i_operar).text('settings');
  
            a = $('<a></a>');
            $(a).attr('class', 'boton btn-base-mini waves-effect transparent');
            $(a).attr('onClick', 'mozo.vincular.preAlta('+mesas[i]['id']+')');
            $(a).append(i_vincular);
            
            a_1 = $('<a></a>');
            $(a_1).attr('class', 'boton btn-base-mini waves-effect transparent');
            $(a_1).attr('onClick', 'mozo.mesa.ver('+mesas[i]['id']+')');
            $(a_1).append(i_info);
            
            a_2 = $('<a></a>');
            $(a_2).attr('class', 'dropdown-button boton btn-base-mini waves-effect transparent');
            $(a_2).attr('data-activates', 'dm'+mesas[i]['id']);
            $(a_2).append(i_operar);

            ul = $('<ul></ul>');
            $(ul).attr('id', 'dm'+mesas[i]['id']);
            $(ul).attr('class', 'dropdown-content' );
            
            a_3 = $('<a></a>');
            $(a_3).text('Cierre parcial');
            $(a_3).attr('onClick','mozo.mesa.cierre_parcial('+mesas[i]['id']+')');
            
            a_4 = $('<a></a>');
            $(a_4).text('Cierre total');
            $(a_4).attr('onClick','mozo.mesa.cierre_total('+mesas[i]['id']+')');
            
            li = $('<li></li>');
            $(li).append(a_3);

            li_2 = $('<li></li>');
            $(li_2).append(a_4);
            
            $(ul).append(li);
            $(ul).append(li_2);

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
            
            $('#tblMesasActivas').append(tr);
        }
        
        auxiliar.reset_dropdown();
    },
    
    ver : function(data){
        
        var vinculados = data['vinculados'];
        var productos = data['productos'];
        var promociones = data['promociones'];
        var total_acumulado = 0;
        
        $('#selectVinculados').empty();
        $('#tblProductosConfirmados').empty();
        $('#tblPromocionesConfirmadas').empty();
        
        for (var i=0; i<vinculados.length; i++){
            o = $("<option></option>");
            $(o).text(vinculados[i]['id_pedidor'] + " | " + vinculados[i]['nombre'] );
            $('#selectVinculados').append(o); 
        }

        for(var i=0; i<productos.length;i++){
            total_acumulado += parseFloat(productos[i]['precio']);

            row = $("<tr></tr>");

            colProducto = $("<td>"+productos[i]['nombre_producto']+"</td>");
            colPrecio = $("<td> $"+productos[i]['precio']+"</td>");

            var pedidor = productos[i]['id_pedidor'] + " | " + productos[i]['nombre_pedidor'];
            colPedidor = $("<td>"+pedidor+"</td>");

            var estado = mozo_vista.mesa.calcular_estado(productos[i]['fecha_p'], productos[i]['fecha_s']);
            colEstado = $("<td>"+estado+"</td>");
            colEstado.attr('id', 'col_'+i);

            $(row).append(colPedidor);
            $(row).append(colProducto);
            $(row).append(colPrecio);
            $(row).append(colEstado);

           $('#tblProductosConfirmados').append(row);
        }

        for(var i=0; i<promociones.length;i++){
            total_acumulado += parseFloat(promociones[i]['precio']);

            row = $("<tr></tr>");

            colPromocion = $("<td>"+promociones[i]['nombre_promocion']+"</td>");
            colPrecio = $("<td> $"+promociones[i]['precio']+"</td>");

            var pedidor = promociones[i]['id_pedidor'] + " | " + promociones[i]['nombre_pedidor'];
            colPedidor = $("<td>"+pedidor+"</td>");

            var estado = mozo_vista.mesa.calcular_estado(promociones[i]['fecha_p'], promociones[i]['fecha_s']);
            colEstado = $("<td>"+estado+"</td>");
            colEstado.attr('id', 'col_'+i);

            $(row).append(colPedidor);
            $(row).append(colPromocion);
            $(row).append(colPrecio);
            $(row).append(colEstado);

           $('#tblPromocionesConfirmadas').append(row);
        }

        $('#lblTotalConfirmados').val("$"+total_acumulado+".-");
        $('#tabVerMesa').tabs();
        $('#selectVinculados').material_select();
        $('#modalVerMesa').openModal();
    },
    
}, //FIN MESA

}//FIN MOZO_VISTA


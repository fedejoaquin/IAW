var cocinero_vista = {

set_pendientes : function(cantidad){
    anteriores = $('#lblPendientes').text();
    $('#lblPendientes').text(cantidad);
    if (anteriores<cantidad){
        $('#audios_notificaciones')[0].play();
        auxiliar.mensaje('Hay nuevos pedidos pendientes.', 2500, 'toast-info');
    }
    
}, //FIN SET PENDIENTES

productos : {
    
    listarPendientes : function(datos){
        $('#tblProductosPendientes').empty();
        
        for(i=0; i<datos.length; i++){
            
            var row = datos[i];
            
            tr = $("<tr></tr>");
            $(tr).attr('id', 'f_prod_pen'+ row['id'] );

            td = $('<td></td>');
            $(td).text(row['id']);
            $(tr).append(td);

            td = $('<td></td>');
            $(td).text(row['fecha_e']);
            $(tr).append(td);
            
            td = $('<td></td>');
            $(td).text(row['nombre']);
            $(tr).append(td);
            
            td = $('<td></td>');
            $(td).text(row['comentarios']);
            $(tr).append(td);
            
            i_info = $('<i></i>');
            $(i_info).attr('class','material-icons');
            $(i_info).text('info');

            i_visto = $('<i></i>');
            $(i_visto).attr('class','material-icons');
            $(i_visto).text('done_all');

            /** 
            <a class="btn waves-effect waves-green" onClick=cocinero.productos.ver($id)">
                <i class="material-icons">info</i>
            </a> 
            **/    
            a = $('<a></a>');
            $(a).attr('class', 'boton btn-base-mini waves-effect transparent');
            $(a).attr('onClick', 'cocinero.productos.ver('+row['id']+')');
            $(a).append(i_info);

            /** 
            <a class="btn waves-effect waves-green" onClick=cocinero.productos.procesar($id)">
                <i class="material-icons">visto</i>
            </a> 
            **/ 
            a_1 = $('<a></a>');
            $(a_1).attr('class', 'boton btn-base-mini waves-effect transparent');
            $(a_1).attr('onClick', 'cocinero.productos.procesar('+row['id']+')');
            $(a_1).append(i_visto);

            td = $('<td></td>');
            $(td).append(a);
            $(tr).append(td);
            
            td = $('<td></td>');
            $(td).append(a_1);
            $(tr).append(td);
            
            $('#tblProductosPendientes').append(tr);
        }       
    },
    
    listarProcesados : function(datos){
        $('#tblProductosProcesados').empty();
                
        for(i=0; i<datos.length; i++){
            
            var row = datos[i];
            
            tr = $("<tr></tr>");
            $(tr).attr('id', 'f_prod_proc'+ row['id'] );

            td = $('<td></td>');
            $(td).text(row['id']);
            $(tr).append(td);

            td = $('<td></td>');
            $(td).text(row['fecha_p']);
            $(tr).append(td);
            
            td = $('<td></td>');
            $(td).text(row['nombre']);
            $(tr).append(td);
            
            td = $('<td></td>');
            $(td).text(row['comentarios']);
            $(tr).append(td);
            
            i_info = $('<i></i>');
            $(i_info).attr('class','material-icons');
            $(i_info).text('info');

            i_visto = $('<i></i>');
            $(i_visto).attr('class','material-icons');
            $(i_visto).text('done_all');

            /** 
            <a class="btn waves-effect waves-green" onClick=cocinero.productos.ver($id)">
                <i class="material-icons">info</i>
            </a> 
            **/    
            a = $('<a></a>');
            $(a).attr('class', 'boton btn-base-mini waves-effect transparent');
            $(a).attr('onClick', 'cocinero.productos.ver('+row['id']+')');
            $(a).append(i_info);

            /** 
            <a class="btn waves-effect waves-green" onClick=cocinero.productos.procesar($id)">
                <i class="material-icons">visto</i>
            </a> 
            **/ 
            a_1 = $('<a></a>');
            $(a_1).attr('class', 'boton btn-base-mini waves-effect transparent');
            $(a_1).attr('onClick', 'cocinero.productos.finalizar('+row['id']+')');
            $(a_1).append(i_visto);

            td = $('<td></td>');
            $(td).append(a);
            $(tr).append(td);
            
            td = $('<td></td>');
            $(td).append(a_1);
            $(tr).append(td);
            
            $('#tblProductosProcesados').append(tr);
        }
    },
    
    ver : function(datos){
        $('#tablaVerProducto').empty();
        
        $('#fecha_e').val(datos['fecha_e']);
        $('#fecha_p').val(datos['fecha_p']);
        $('#id_pedido').val(datos['id']);
        $('#id_mesa').val(datos['id_mesa']);
        $('#num_mesa').val(datos['numero_mesa']);
        $('#id_pedidor').val(datos['id_pedidor']);
        $('#nom_pedidor').val(datos['nombre_pedidor']);
        $('#nom_mozo').val(datos['nombre_mozo']);
        
        $('#modalVerProducto').openModal();
    },
    
    procesar : function(id){
        row = $('#f_prod_pen'+id).clone();
        $('#f_prod_pen'+id).remove();
        
        $(row).attr('id', 'f_prod_proc'+id);
        i_info = $('<i></i>');
        $(i_info).attr('class','material-icons');
        $(i_info).text('info');

        i_visto = $('<i></i>');
        $(i_visto).attr('class','material-icons');
        $(i_visto).text('done_all');

        /** 
        <a class="btn waves-effect waves-green" onClick=cocinero.productos.ver($id)">
            <i class="material-icons">info</i>
        </a> 
        **/    
        a = $('<a></a>');
        $(a).attr('class', 'boton btn-base-mini waves-effect transparent');
        $(a).attr('onClick', 'cocinero.productos.ver('+id+')');
        $(a).append(i_info);

        /** 
        <a class="btn waves-effect waves-green" onClick=cocinero.productos.procesar($id)">
            <i class="material-icons">visto</i>
        </a> 
        **/ 
        a_1 = $('<a></a>');
        $(a_1).attr('class', 'boton btn-base-mini waves-effect transparent');
        $(a_1).attr('onClick', 'cocinero.productos.finalizar('+id+')');
        $(a_1).append(i_visto);

        td = $('<td></td>');
        $(td).append(a);
        
        td_1 = $('<td></td>');
        $(td_1).append(a_1);
        
        $(row).find('td:last').remove();
        $(row).find('td:last').remove();
        
        $(row).append(td);
        $(row).append(td_1);
        
        $('#tblProductosProcesados').append(row);
    },
    
    finalizar : function(id){
        $('#f_prod_proc'+id).remove();
    }
}, //FIN PRODUCTOS

promociones : {
    
    listarPendientes : function(datos){
        $('#tblPromocionesPendientes').empty();
        
        for(i=0; i<datos.length; i++){
            
            var row = datos[i];
            
            tr = $("<tr></tr>");
            $(tr).attr('id', 'f_prom_pen'+ row['id'] );

            td = $('<td></td>');
            $(td).text(row['id']);
            $(tr).append(td);

            td = $('<td></td>');
            $(td).text(row['fecha_e']);
            $(tr).append(td);
            
            td = $('<td></td>');
            $(td).text(row['nombre']);
            $(tr).append(td);
            
            td = $('<td></td>');
            $(td).text(row['comentarios']);
            $(tr).append(td);
            
            i_info = $('<i></i>');
            $(i_info).attr('class','material-icons');
            $(i_info).text('info');

            i_visto = $('<i></i>');
            $(i_visto).attr('class','material-icons');
            $(i_visto).text('done_all');

            /** 
            <a class="btn waves-effect waves-green" onClick=cocinero.productos.ver($id)">
                <i class="material-icons">info</i>
            </a> 
            **/    
            a = $('<a></a>');
            $(a).attr('class', 'boton btn-base-mini waves-effect transparent');
            $(a).attr('onClick', 'cocinero.promociones.ver('+row['id']+')');
            $(a).append(i_info);

            /** 
            <a class="btn waves-effect waves-green" onClick=cocinero.productos.procesar($id)">
                <i class="material-icons">visto</i>
            </a> 
            **/ 
            a_1 = $('<a></a>');
            $(a_1).attr('class', 'boton btn-base-mini waves-effect transparent');
            $(a_1).attr('onClick', 'cocinero.promociones.procesar('+row['id']+')');
            $(a_1).append(i_visto);

            td = $('<td></td>');
            $(td).append(a);
            $(tr).append(td);
            
            td = $('<td></td>');
            $(td).append(a_1);
            $(tr).append(td);
            
            $('#tblPromocionesPendientes').append(tr);
        }
        
    },
    
    listarProcesadas : function(datos){
        $('#tblPromocionesProcesadas').empty();
                
        for(i=0; i<datos.length; i++){
            
            var row = datos[i];
            
            tr = $("<tr></tr>");
            $(tr).attr('id', 'f_prom_proc'+ row['id'] );

            td = $('<td></td>');
            $(td).text(row['id']);
            $(tr).append(td);

            td = $('<td></td>');
            $(td).text(row['fecha_p']);
            $(tr).append(td);
            
            td = $('<td></td>');
            $(td).text(row['nombre']);
            $(tr).append(td);
            
            td = $('<td></td>');
            $(td).text(row['comentarios']);
            $(tr).append(td);
            
            i_info = $('<i></i>');
            $(i_info).attr('class','material-icons');
            $(i_info).text('info');

            i_visto = $('<i></i>');
            $(i_visto).attr('class','material-icons');
            $(i_visto).text('done_all');

            /** 
            <a class="btn waves-effect waves-green" onClick=cocinero.productos.ver($id)">
                <i class="material-icons">info</i>
            </a> 
            **/    
            a = $('<a></a>');
            $(a).attr('class', 'boton btn-base-mini waves-effect transparent');
            $(a).attr('onClick', 'cocinero.promociones.ver('+row['id']+')');
            $(a).append(i_info);

            /** 
            <a class="btn waves-effect waves-green" onClick=cocinero.productos.procesar($id)">
                <i class="material-icons">visto</i>
            </a> 
            **/ 
            a_1 = $('<a></a>');
            $(a_1).attr('class', 'boton btn-base-mini waves-effect transparent');
            $(a_1).attr('onClick', 'cocinero.promociones.finalizar('+row['id']+')');
            $(a_1).append(i_visto);

            td = $('<td></td>');
            $(td).append(a);
            $(tr).append(td);
            
            td = $('<td></td>');
            $(td).append(a_1);
            $(tr).append(td);
            
            $('#tblPromocionesProcesadas').append(tr);
        }
    },
    
    ver : function(datos){
        $('#tablaVerProducto').empty();
        
        $('#fecha_e').val(datos['fecha_e']);
        $('#fecha_p').val(datos['fecha_p']);
        $('#id_pedido').val(datos['id']);
        $('#id_mesa').val(datos['id_mesa']);
        $('#num_mesa').val(datos['numero_mesa']);
        $('#id_pedidor').val(datos['id_pedidor']);
        $('#nom_pedidor').val(datos['nombre_pedidor']);
        $('#nom_mozo').val(datos['nombre_mozo']);
        
        $('#modalVerProducto').openModal();
    },
    
    procesar : function(id){
        row = $('#f_prom_pen'+id).clone();
        $('#f_prom_pen'+id).remove();
        
        $(row).attr('id', 'f_prom_proc'+id);
        i_info = $('<i></i>');
        $(i_info).attr('class','material-icons');
        $(i_info).text('info');

        i_visto = $('<i></i>');
        $(i_visto).attr('class','material-icons');
        $(i_visto).text('done_all');

        /** 
        <a class="btn waves-effect waves-green" onClick=cocinero.productos.ver($id)">
            <i class="material-icons">info</i>
        </a> 
        **/    
        a = $('<a></a>');
        $(a).attr('class', 'boton btn-base-mini waves-effect transparent');
        $(a).attr('onClick', 'cocinero.promociones.ver('+id+')');
        $(a).append(i_info);

        /** 
        <a class="btn waves-effect waves-green" onClick=cocinero.productos.procesar($id)">
            <i class="material-icons">visto</i>
        </a> 
        **/ 
        a_1 = $('<a></a>');
        $(a_1).attr('class', 'boton btn-base-mini waves-effect transparent');
        $(a_1).attr('onClick', 'cocinero.promociones.finalizar('+id+')');
        $(a_1).append(i_visto);

        td = $('<td></td>');
        $(td).append(a);
        
        td_1 = $('<td></td>');
        $(td_1).append(a_1);
        
        $(row).find('td:last').remove();
        $(row).find('td:last').remove();
        
        $(row).append(td);
        $(row).append(td_1);
        
        $('#tblPromocionesProcesadas').append(row);
    },
    
    finalizar : function(id){
       $('#f_prom_proc'+id).remove();
    }
} //FIN PROMOCIONES

} //FIN COCINERO VISTA
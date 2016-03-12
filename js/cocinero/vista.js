var cocinero_vista = {
 mensaje : function(mensaje, tiempo, clase){
    Materialize.toast(mensaje, tiempo ,clase);
},

 listarPedidosPromos : function(){
    cocinero_vista.listarProductos(cocinero.pedPend,"#pedPend","procesar");
    cocinero_vista.listarProductos(cocinero.promoPend,"#promoPend","procesar");
    var pendientes = cocinero.pedPend.length + cocinero.promoPend.length;
    $('#tabPendientes').html("Pendientes: "+pendientes );
   
    cocinero_vista.listarProductos(cocinero.pedProc,"#pedProc","terminar");
    cocinero_vista.listarProductos(cocinero.promoProc,"#promoProc","terminar");
    var procesados = cocinero.pedProc.length + cocinero.promoProc.length;
    $('#tabProcesados').html("Procesados: "+procesados);
},

listarProductos : function (elemento,tabla,funcion){
    $(tabla).empty();
    defaultComent = 'Sin comentarios.';
    
    cantElem = elemento.length;
    for(var i=0; i<cantElem;i++){
        row = $("<tr></tr>");
        numPend = $("<td>"+(i+1)+"</td>");
        producto = $("<td>"+elemento[i]['nombre']+"</td>");
        comment = elemento[i]['comentarios'];
        comentarios = $("<td></td>");
        if(defaultComent.localeCompare(comment) !== 0)
        {
            comentarios = $("<td>"+elemento[i]['comentarios']+"</td>");
        }
        procesarProducto = $("<td><button class='btn waves-effect waves-light'><i class='material-icons right'>clear_all</i></button></td>");
        procesarProducto.attr('onclick',"cocinero."+funcion+"("+i+",'"+tabla+"')");
         
        $(row).append(numPend);
        $(row).append(producto);
        $(row).append(comentarios);
        $(row).append(procesarProducto);
    
        $(tabla).append(row);
    }
    
}
};
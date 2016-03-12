$( document ).ready(function(){
    cocinero.checkPedidos();
});
var cocinero = {
pedProc : [],
promoProc : [],
pedPend : [],
promoPend : [],



checkPedidos : function (){
    $.ajax({
        data:  {},
        url:   '/IAW-PF/cocinero/pedidos_activos',
        type:  'post',
        error: function(response){
                cocinero_vista.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
            },
        success: function (response){
            var respuesta = JSON.parse(response);
            if (respuesta['error'] === undefined){
                cocinero.pedProc = respuesta['pedProc'];
                cocinero.promoProc = respuesta['promoProc'];
                cocinero.pedPend = respuesta['pedPend'];
                cocinero.promoPend = respuesta['promoPend'];
                cocinero_vista.listarPedidosPromos();
            }
            else
            {
                cocinero_vista.mensaje('Se produjo un error en la picholga.', 5000,'toast-error');
            }
            
        }
    });
    setTimeout("cocinero.checkPedidos()",20000);
    
},



/*
 * 
 * @param Array elemento, elementos a ser agregados.
 * @param String tabla, identificador de la tabla a la cual agregarlos.
 * @param String funcion a la cual llama luego de que se realiza la accion onclick.
 */



 procesar : function(posicion,tabla){
    var datos = new Array();
    if(tabla.localeCompare('#pedPend') === 0 ){
        datos = cocinero.pedPend;
        tablaAux = "pedidos";
        //cocinero_vista.mensaje("respuesta" +cocinero.pedPend[0], 5000,'toast-error');
        
    }
    else{
        datos = cocinero.promoPend;
        tablaAux = "promociones";
    }
    tupla = datos[posicion];
   $.ajax({
            data:  {'pedido_id': tupla['id'],'tabla':tablaAux},
            url:   'http://localhost/IAW-PF/cocinero/procesar_producto',
            type:  'post',
            error: function(response){
                cocinero_vista.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                cocinero_vista.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                cocinero_vista.mensaje('En 5 segundos el sistema reintentará automáticamente.', 10000,'toast-error');
                setTimeout("cocinero.procesar("+posicion+","+tabla+")",3000);   
            },
            success: function (response){
                    datos.splice(posicion,1);
                    cocinero_vista.listarPedidosPromos();
            }
        });
},

 terminar : function(posicion,tabla){
    // cocinero_vista.mensaje('Entre a procesar con Pos:'+posicion+" Tabla: "+tabla, 5000,'toast-ok');
    var datos = new Array();
  
    if(tabla.localeCompare('#pedProc') === 0){
        datos = cocinero.pedProc;
        tabla = "pedidos";
    }
    else{
        datos = cocinero.promoProc;
        tabla = "promociones";
    }
    tupla = datos[posicion];
    $.ajax({
            data:  {'tupla': tupla,'tabla':tabla},
            url:   '/IAW-PF/cocinero/terminar_producto',
            type:  'post',
            error: function(response){
                cocinero_vista.mensaje('Se produjo un error en la conexión.', 5000,'toast-error');
                cocinero_vista.mensaje('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                cocinero_vista.mensaje('En 5 segundos el sistema reintentará automáticamente.', 10000,'toast-error');
                setTimeout("cocinero.terminar("+posicion+","+tabla+")",3000);
            },
            success: function (response){
                    datos.splice(posicion,1);
                    cocinero_vista.listarPedidosPromos();
            }
        });
}
}
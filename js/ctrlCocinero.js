var pedProc = new Array();
var promoProc = new Array();
var pedPend = new Array();
var promoPend = new Array();

$( document ).ready(function(){
    checkPedidos();
});

function checkPedidos(){
    $.ajax({
        data:  {},
        url:   'http://localhost/IAW-PF/ajax_1/pedidos_activos',
        type:  'post',
        error: function(response){
                Materialize.toast('Se produjo un error en la conexión.', 5000,'toast-error');
            },
        success: function (response){
            var respuesta = JSON.parse(response);
            if (respuesta['error'] === undefined){
                pedProc = respuesta['pedProc'];
               // Materialize.toast('Elemento', 3000,'toast-ok');
                promoProc = respuesta['promoProc'];
                pedPend = respuesta['pedPend'];
                promoPend = respuesta['promoPend'];
                listarPedidosPromos();
            }
        }
    });
    setTimeout("checkPedidos()",3000);
    
}

function listarPedidosPromos(){
   // Materialize.toast(pedPend, 3000,'toast-ok');
    listarProductos(pedPend,"#pedPend","procesar");
    listarProductos(promoPend,"#promoPend","procesar");
    listarProductos(pedProc,"#pedProc","terminar");
    listarProductos(promoProc,"#promoProc","terminar");
}

/*
 * 
 * @param Array elemento, elementos a ser agregados.
 * @param String tabla, identificador de la tabla a la cual agregarlos.
 * @param String funcion a la cual llama luego de que se realiza la accion onclick.
 */

function listarProductos(elemento,tabla,funcion){
    $(tabla).empty();
    cantElem = elemento.length;
    $("#badge"+tabla).val(cantElem);
    for(var i=0; i<cantElem;i++){
        row = $("<tr></tr>");
        numPend = $("<td>"+(i+1)+"</td>");
        producto = $("<td>"+elemento[i]['nombre']+"</td>");
        procesarProducto = $("<td><button><i class='material-icons right'>clear_all</i></button></td>");
        procesarProducto.attr('onclick',funcion+"("+i+",'"+tabla+"')");
         
        $(row).append(numPend);
        $(row).append(producto);
        $(row).append(procesarProducto);
    
        $(tabla).append(row);
    }
    
}
/*
function listarProcesados(elemento,tabla){
    $(tabla).empty();
    for(var i=0; i<elemento.length;i++){
        row = $("<tr></tr>");
        numProc = $("<td>"+(i+1)+"</td>");
        producto = $("<td>"+elemento[i]['nombre']+"</td>");
        terminar = $("<td><button><i class='material-icons right'>clear_all</i></button></td>");
        terminar.attr('onclick',"terminar("+i+","+tabla+")");
        
        $(row).append(numProc);
        $(row).append(producto);
        $(row).append(terminar);

       $(tabla).append(row);
    }
}
*/


function procesar(posicion,tabla){
   // Materialize.toast('Entre a procesar con Pos:'+posicion+" Tabla: "+tabla, 5000,'toast-ok');
    var datos = array();
    var tabla = "";
    if(tabla === "#pedPend"){
        Materialize.toast("Pedido", 5000,'toast-ok');
        datos = pedPend;
        tabla = "pedidos";
    }
    else{
        Materialize.toast('Promo', 5000,'toast-ok');
        datos = promoPend;
        tabla = "promociones";
    }
    var tupla = datos[posicion];
    /*$.ajax({
            data:  {'pedido_id': tupla['id'],'tabla':tabla},
            url:   'http://localhost/IAW-PF/ajax_1/procesar_producto',
            type:  'post',
            error: function(response){
                Materialize.toast('Se produjo un error en la conexión.', 5000,'toast-error');
                Materialize.toast('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                Materialize.toast('En 5 segundos el sistema reintentará automáticamente.', 10000,'toast-error');
                setTimeout(function(){ validarCliente(); }, 5000);    
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                if (respuesta['error'] === undefined){
//                    $('#notificacion'+posicion).hide('slow');
                    datos.splice(posicion,1);
                    listarNotificaciones();
                }else{
                    var error = respuesta['error'];
                    Materialize.toast(error, 10000,'toast-error');
                }
            }
        });*/
}
function terminar(posicion,tabla){
    // Materialize.toast('Entre a procesar con Pos:'+posicion+" Tabla: "+tabla, 5000,'toast-ok');
    var datos = array();
    var tabla = "";
    if(tabla === "#pedProc"){
        Materialize.toast("Pedido", 5000,'toast-ok');
        datos = pedPend;
        tabla = "pedidos";
    }
    else{
        Materialize.toast('Promo', 5000,'toast-ok');
        datos = promoProc;
        tabla = "promociones";
    }
    var tupla = datos[posicion];
    /*$.ajax({
            data:  {'pedido_id': tupla['id'],'tabla':tabla},
            url:   'http://localhost/IAW-PF/ajax_1/terminar_producto',
            type:  'post',
            error: function(response){
                Materialize.toast('Se produjo un error en la conexión.', 5000,'toast-error');
                Materialize.toast('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                Materialize.toast('En 5 segundos el sistema reintentará automáticamente.', 10000,'toast-error');
                setTimeout(function(){ validarCliente(); }, 5000);    
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                if (respuesta['error'] === undefined){
//                    $('#notificacion'+posicion).hide('slow');
                    datos.splice(posicion,1);
                    listarNotificaciones();
                }else{
                    var error = respuesta['error'];
                    Materialize.toast(error, 10000,'toast-error');
                }
            }
        });*/
}
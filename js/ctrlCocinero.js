var pedProc = new Array();
var promoProc = new Array();
var pedPend = new Array();
var promoPend = new Array();

$( document ).ready(function(){
    checkPedidos();
});

function checkPedidos(){
    Materialize.toast('chequeo', 5000,'toast-error');
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
    defaultComent = 'Sin comentarios.';
    
    cantElem = elemento.length;
    for(var i=0; i<cantElem;i++){
        //Materialize.toast('Mesa: '+elemento[i]['id_mesa'], 5000,'toast-error');
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
        procesarProducto.attr('onclick',funcion+"("+i+",'"+tabla+"')");
         
        $(row).append(numPend);
        $(row).append(producto);
        $(row).append(comentarios);
        $(row).append(procesarProducto);
    
        $(tabla).append(row);
    }
    
}

function procesar(posicion,tabla){
    var datos = new Array();
    if(tabla.localeCompare('#pedPend') === 0 ){
        datos = pedPend;
        tabla = "pedidos";
    }
    else{
        datos = promoPend;
        tabla = "promociones";
    }
    var tupla = datos[posicion];
   $.ajax({
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
        });
}
function terminar(posicion,tabla){
    // Materialize.toast('Entre a procesar con Pos:'+posicion+" Tabla: "+tabla, 5000,'toast-ok');
    var datos = new Array();
  
    if(tabla.localeCompare('#pedProc') === 0){
        datos = pedProc;
        tabla = "pedidos";
    }
    else{
        datos = promoProc;
        tabla = "promociones";
    }
    tupla = datos[posicion];
    //Materialize.toast('Numero de mesa: '+tupla['id_mesa'], 5000,'toast-error');
    $.ajax({
            data:  {'tupla': tupla,'tabla':tabla},
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
        });
}
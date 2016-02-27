
var elementos = new Array();
var total = 0;

function agregarCarrito( id, producto, precio ){
    var tupla = {'id':id,'producto':producto,'precio':precio, 'comentarios':'Sin comentarios.'}; 
    elementos.push(tupla);
    total += precio;
    Materialize.toast(producto + ' agregado.', 2000,'toast-add');
}

function quitarCarrito( posicion ){
    var tupla = elementos[posicion];
    elementos.splice(posicion,1);
    total -= tupla['precio'];
    listarCarrito();
    Materialize.toast(tupla['producto'] + ' eliminado correctamente.', 2000,'toast-delete');
}

function agregarComentario(posicion){
    $('#idComentario').attr('value',posicion);
    $('#inputComentario').attr('value',elementos[posicion]['comentarios']);
    $('#modalComentarios').openModal();
}

function enviarComentario(){
    var posicion =  $('#idComentario').val();
    var comentario = $('#inputComentario').val();
    elementos[posicion]['comentarios'] = comentario;
    listarCarrito();
    Materialize.toast('Comentario adherido.', 2000,'toast-add');
}

function listarCarrito(){
    $('#tablaCarrito').empty();
    
    for(var i=0; i<elementos.length;i++){
        row = $("<tr></tr>");
        
        colImagen = $("<td></td>");
        colProducto = $("<td>"+elementos[i]['producto']+"</td>");
        colPrecio = $("<td> $"+elementos[i]['precio']+"</td>");
        colComentarios = $("<td>"+elementos[i]['comentarios']+ "</td>");
        colAcciones = $("<td></td>");
        
        img = $("<img/>");
        $(img).attr("src", "http://localhost/IAW-PF/img/comidas/"+elementos[i]['id']+".png");
        
        link = $("<a></a>").text("ELIM ");
        $(link).attr("onclick", "quitarCarrito("+i+")");
        
        link_2 = $("<a></a>").text("COM ");
        $(link_2).attr("onclick", "agregarComentario("+i+")");
        
        $(colImagen).append(img);
        $(colAcciones).append(link_2);
        $(colAcciones).append(link);
        $(row).append(colImagen);
        $(row).append(colProducto);
        $(row).append(colPrecio);
        $(row).append(colComentarios);
        $(row).append(colAcciones);
        
        $('#tablaCarrito').append(row);
    }
}
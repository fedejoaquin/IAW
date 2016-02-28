
var productos = new Array();
var promociones = new Array();
var datosComentario = new Array();
var total = 0;

function agregarProducto( id, producto, precio ){
    var tupla = {'id':id,'producto':producto,'precio':precio, 'comentarios':'Sin comentarios.'}; 
    productos.push(tupla);
    total += precio;
    Materialize.toast(producto + ' agregado.', 2000,'toast-ok');
}

function agregarPromocion( id, nombre, precio ){
    var tupla = {'id':id,'nombre': nombre, 'precio':precio, 'comentarios':'Sin comentarios.'}; 
    promociones.push(tupla);
    total += precio;
    Materialize.toast('Promoción agregada.', 2000,'toast-ok');
}

function quitarProducto( posicion ){
    var tupla = productos[posicion];
    productos.splice(posicion,1);
    total -= tupla['precio'];
    listarCarrito();
    Materialize.toast(tupla['producto'] + ' eliminado correctamente.', 2000,'toast-error');
}

function quitarPromocion( posicion ){
    var tupla = promociones[posicion];
    promociones.splice(posicion,1);
    total -= tupla['precio'];
    listarCarrito();
    Materialize.toast('Promoción eliminada correctamente.', 2000,'toast-error');
}

function comentarProducto(posicion){
    datosComentario.id = posicion;
    datosComentario.tipo = 'producto';
    $('#inputComentario').attr('value',productos[posicion]['comentarios']);
    $('#modalComentarios').openModal();
}

function comentarPromocion(posicion){
    datosComentario.id = posicion;
    datosComentario.tipo = 'promocion';
    $('#inputComentario').attr('value',promociones[posicion]['comentarios']);
    $('#modalComentarios').openModal();
}

function enviarComentario(){
    var posicion =  datosComentario.id;
    var tipo = datosComentario.tipo;
    var comentario = $('#inputComentario').val();
    
    if (tipo === 'promocion'){
        promociones[posicion]['comentarios'] = comentario;
    }else{
        productos[posicion]['comentarios'] = comentario;
    }
    listarCarrito();
    Materialize.toast('Comentario adherido.', 2000,'toast-ok');
}

function listarCarrito(){
    $('#tablaCarrito').empty();
    
    for(var i=0; i<productos.length;i++){
        row = $("<tr></tr>");
        
        colImagen = $("<td></td>");
        colProducto = $("<td>"+productos[i]['producto']+"</td>");
        colPrecio = $("<td> $"+productos[i]['precio']+"</td>");
        colComentarios = $("<td>"+productos[i]['comentarios']+ "</td>");
        colAcciones = $("<td></td>");
        
        img = $("<img/>");
        $(img).attr("src", "http://localhost/IAW-PF/img/comidas/"+productos[i]['id']+".png");
        
        icon_d = $("<i></i>");
        $(icon_d).attr("class", "material-icons");
        $(icon_d).text("delete");
        
        icon_c = $("<i></i>");
        $(icon_c).attr("class", "material-icons");
        $(icon_c).text("comment");
        
        link_d = $("<a></a>");
        $(link_d).attr("class", "btn waves-effects");
        $(link_d).attr("onclick", "quitarProducto("+i+")");
               
        link_c = $("<a></a>");
        $(link_c).attr("class", "btn waves-effects");
        $(link_c).attr("onclick", "comentarProducto("+i+")");
        
        $(colImagen).append(img);
        $(link_d).append(icon_d);
        $(link_c).append(icon_c);
        $(colAcciones).append(link_c);
        $(colAcciones).append(link_d);
        $(row).append(colImagen);
        $(row).append(colProducto);
        $(row).append(colPrecio);
        $(row).append(colComentarios);
        $(row).append(colAcciones);
        
        $('#tablaCarrito').append(row);
    }
    
    for(var i=0; i<promociones.length;i++){
        row = $("<tr></tr>");
        
        colImagen = $("<td></td>");
        colNombre = $("<td>"+promociones[i]['nombre']+"</td>");
        colPrecio = $("<td> $"+promociones[i]['precio']+"</td>");
        colComentarios = $("<td>"+promociones[i]['comentarios']+ "</td>");
        colAcciones = $("<td></td>");
        
        img = $("<img/>");
        $(img).attr("src", "http://localhost/IAW-PF/img/comidas/promo.png");
        
        icon_d = $("<i></i>");
        $(icon_d).attr("class", "material-icons");
        $(icon_d).text("delete");
        
        icon_c = $("<i></i>");
        $(icon_c).attr("class", "material-icons");
        $(icon_c).text("comment");
        
        link_d = $("<a></a>");
        $(link_d).attr("class", "btn waves-effects");
        $(link_d).attr("onclick", "quitarPromocion("+i+")");
        
        link_c = $("<a></a>");
        $(link_c).attr("class", "btn waves-effects ");
        $(link_c).attr("onclick", "comentarPromocion("+i+")");
        
        $(colImagen).append(img);
        $(link_d).append(icon_d);
        $(link_c).append(icon_c);
        $(colAcciones).append(link_c);
        $(colAcciones).append(link_d);
        $(row).append(colImagen);
        $(row).append(colNombre);
        $(row).append(colPrecio);
        $(row).append(colComentarios);
        $(row).append(colAcciones);
        
        $('#tablaCarrito').append(row);
    }  
}

function vaciarCarrito(){
    if (productos.length===0 && promociones.length===0){
        Materialize.toast('No hay nada en el carrito.', 2000,'toast-error');
    }else{
        productos = new Array();
        promociones = new Array();
        precio = 0;
        listarCarrito();
        Materialize.toast('Se vació correctamente el carrito.', 2000,'toast-ok');
    }
}

function confirmarPedido(){
    if (productos.length===0 && promociones.length===0){
        Materialize.toast('No hay nada en el carrito.', 2000,'toast-error');
    }else{
        alert('Comunicación ajax con base de datos.');
        productos = new Array();
        promociones = new Array();
        precio = 0;
        listarCarrito();
        Materialize.toast('Pedidos y/o promociones confirmadas.', 2000,'toast-ok');
    }
}
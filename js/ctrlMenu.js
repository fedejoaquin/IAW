
function cambiarNombre(){
    var nombre_nuevo = $('#nombreMenu').val();
    alert('cambiar nombre: '+nombre_nuevo);
}

function cambiarDias(){
    $('#lblSelectDias').text('Cambio con éxito');
    alert('cambiar dias');
}

function cambiarHoras(){
    alert('cambiar horas');
}

function preEditarProducto(id){
    $.ajax({
            data:  {'id': id },
            url:   'http://localhost/IAW-PF/ajax/infoProductoEditable',
            type:  'post',
            error: function(response){
                Materialize.toast('Se produjo un error en la conexión.', 5000,'toast-error');
                Materialize.toast('El servidor no está respondiendo nuestra solicitud.', 5000,'toast-error');
                Materialize.toast('El producto no puede ser editado en este momento.', 5000,'toast-error');
            },
            success: function (response){
                var respuesta = JSON.parse(response);
                if (respuesta['error'] === undefined){
                    completarTablaEditar(respuesta);
                }else{
                    Materialize.toast('El producto seleccionado es incorrecto.', 2500,'toast-error');
                }
            }
        });
    
}

function postEditarProducto(){
    alert('postEditarProducto');
}

function completarTablaEditar(respuesta){
    $('#tablaEditarProducto').empty();
    alert('completarTablaEditar');
}
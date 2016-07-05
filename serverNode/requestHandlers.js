var db = require("./modelDB");

function datos_competidores(response){
    db.datos_competidores(function(salida)
    {
        response.setHeader("Content-Type", "text/json");
        response.setHeader("Access-Control-Allow-Origin", "*");
        response.end(JSON.stringify(salida));
    });   
}
function agregar_competidor(response,dataPost) {
    db.checkLogin(function(logueado){
    response.setHeader("Content-Type", "text/json");
    response.setHeader("Access-Control-Allow-Origin", "*");
    if(logueado === "log"){
        datos = JSON.parse(dataPost);
        db.agregar_competidor(datos,function(salida){
            //console.log("solicitud de agregar");
            if(salida === "Error"){
                var result = {
                        "error":"Usuario Existente"
                    };
                response.end(JSON.stringify(result));
            }
        });
    }
    else{
        //console.log("solicitud de agregar"); 
        var result = {
                        "error":"Usuario No Logueado"
                    };
        response.end(JSON.stringify(result));
    }
    });
}


function agregar_producto(response,dataPost) {
    db.checkLogin(function(logueado){
    response.setHeader("Content-Type", "text/json");
    response.setHeader("Access-Control-Allow-Origin", "*");
    if(logueado === "log"){
        datos = JSON.parse(dataPost);
        db.agregar_producto(datos,function(salida){
            //console.log("solicitud de agregar");
            if(salida === "Error"){
                var result = {
                        "error":"Producto Existente"
                    };
                response.end(JSON.stringify(result));
            }
        });
    }
    else{
        //console.log("solicitud de agregar"); 
        var result = {
                        "error":"Usuario No Logueado"
                    };
        response.end(JSON.stringify(result));
    }
    });

}
function modificar_competidor(response,dataPost) {
    db.checkLogin(function(logueado){
    response.setHeader("Content-Type", "text/json");
    response.setHeader("Access-Control-Allow-Origin", "*");
    if(logueado === "log"){
        datos = JSON.parse(dataPost);
        db.modificar_competidor(datos,function(salida){
            //console.log("solicitud de agregar");
            if(salida === "Error"){
                var result = {
                        "error":"Error modificacion competidor"
                    };
                response.end(JSON.stringify(result));
            }
        });
    }
    else{
        //console.log("solicitud de agregar"); 
        var result = {
                        "error":"Usuario No Logueado"
                    };
        response.end(JSON.stringify(result));
    }
    });

}

function modificar_producto(response,dataPost) {
    db.checkLogin(function(logueado){
    response.setHeader("Content-Type", "text/json");
    response.setHeader("Access-Control-Allow-Origin", "*");
    if(logueado === "log"){
        datos = JSON.parse(dataPost);
        db.modificar_producto(datos,function(salida){
            //console.log("solicitud de agregar");
            if(salida === "Error"){
                var result = {
                        "error":"Error modificacion producto"
                    };
                response.end(JSON.stringify(result));
            }
        });
    }
    else{
        //console.log("solicitud de agregar"); 
        var result = {
                        "error":"Usuario No Logueado"
                    };
        response.end(JSON.stringify(result));
    }
    });

}

function consumo_producto(response,dataPost){
   datos = JSON.parse(dataPost);
    var dia = datos.dia;
    var mes = datos.mes;
    var anio = datos.anio;
    response.setHeader("Content-Type", "text/json");
    response.setHeader("Access-Control-Allow-Origin", "*");
    if(anio === -1){
        //consultar por todo todo.
        db.consumo_producto(datos,function(datosConsumo){
            response.end(JSON.stringify(datosConsumo));
        });
    }
    else{
        if( mes === -1){
            //Consultar por todos los meses del anio.
            db.consumo_producto_anio(datos,function(datosConsumo){
            response.end(JSON.stringify(datosConsumo));
        });
        }
        else{
            if(dia === -1){
                //Consultar por todos los dias del mes.
                db.consumo_producto_mes(datos,function(datosConsumo){
                 response.end(JSON.stringify(datosConsumo));
        });
            }
            else{
                //consultar por dia especifico.
                db.consumo_producto_dia(datos,function(datosConsumo){
                response.end(JSON.stringify(datosConsumo));
        });
            }
        }
    }
}

function consumo_total(response,dataPost){
    datos = JSON.parse(dataPost);
    var dia = datos.dia;
    var mes = datos.mes;
    var anio = datos.anio;
    response.setHeader("Content-Type", "text/json");
    response.setHeader("Access-Control-Allow-Origin", "*");
    if(anio === -1){
        //consultar por todo todo.
        db.consumo_total(function(datosConsumo){
            response.end(JSON.stringify(datosConsumo));
        });
    }
    else{
        if( mes === -1){
            //Consultar por todos los meses del anio.
            db.consumo_total_anio(datos,function(datosConsumo){
            response.end(JSON.stringify(datosConsumo));
        });
        }
        else{
            if(dia === -1){
                //Consultar por todos los dias del mes.
                db.consumo_total_mes(datos,function(datosConsumo){
                 response.end(JSON.stringify(datosConsumo));
        });
            }
            else{
                //consultar por dia especifico.
                db.consumo_total_dia(datos,function(datosConsumo){
                response.end(JSON.stringify(datosConsumo));
        });
            }
        }
    }
}

function incrementar_consumo(response,dataPost) {
    db.checkLogin(dataPost, function(logueado){
    
    response.setHeader("Content-Type", "text/json");
    response.setHeader("Access-Control-Allow-Origin", "*");
    if(logueado === "log"){
        datos = JSON.parse(dataPost);
        
        db.incrementar_consumo(datos,function(salida){
            if(salida === "Error"){
                var result = {
                        "error":"Error en actualización."
                    };
               response.end(JSON.stringify(result));
            }
            else{
                var result = new Array();
                response.end(JSON.stringify(result));
            }
        });
    }
    else{
        var result = {
                        "error":"Usuario No Logueado"
                    };
        response.end(JSON.stringify(result));
    }
    });

}

function productos(response){
    
    db.productos(function(productos){
        response.setHeader("Content-Type", "text/json");
    response.setHeader("Access-Control-Allow-Origin", "*");     
        response.end(JSON.stringify(productos));
    });
}

function eliminar_competidor(response,dataPost) {
    db.checkLogin(function(logueado){
    response.setHeader("Content-Type", "text/json");
    response.setHeader("Access-Control-Allow-Origin", "*");
    if(logueado === "log"){
        datos = JSON.parse(dataPost);
        db.eliminar_competidor(datos,function(salida){
            //console.log("solicitud de agregar");
            if(salida === "Error"){
                var result = {
                        "error":"Error en eliminacion."
                    };
                response.end(JSON.stringify(result));
            }
        });
    }
    else{
        //console.log("solicitud de agregar"); 
        var result = {
                        "error":"Usuario No Logueado"
                    };
        response.end(JSON.stringify(result));
    }
    });

}

function eliminar_producto(response,dataPost) {
    db.checkLogin(function(logueado){
    response.setHeader("Content-Type", "text/json");
    response.setHeader("Access-Control-Allow-Origin", "*");
    if(logueado === "log"){
        datos = JSON.parse(dataPost);
        db.eliminar_producto(datos,function(salida){
            if(salida === "Error"){
                var result = {
                        "error":"Error en eliminacion."
                    };
                response.end(JSON.stringify(result));
            }
        });
    }
    else{
        var result = {
                        "error":"Usuario No Logueado"
                    };
        response.end(JSON.stringify(result));
    }
    });

}

exports.datos_competidores = datos_competidores;
exports.productos = productos;
exports.incrementar_consumo = incrementar_consumo;

exports.consumo_total = consumo_total;
exports.consumo_producto = consumo_producto;

exports.agregar_competidor = agregar_competidor;
exports.agregar_producto = agregar_producto;

exports.modificar_competidor = modificar_competidor;
exports.modificar_producto = modificar_producto;

exports.eliminar_competidor = eliminar_competidor;
exports.eliminar_producto = eliminar_producto;

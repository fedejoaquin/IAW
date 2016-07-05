var mongodb = require('mongodb');
var MongoClient = mongodb.MongoClient
    , format = require('util').format;
    
var async = require("async");

var competidores;
var productos_competencia;
var dataCompetidores;
var dataProductos_competencia;
var info_productos;
var MDB;
/*
 * Estructura de competidores:
 * competidores{
 *       nombreCompetidor: String,
 *       consumoDiario: Number,
 * }
 */

MongoClient.connect('mongodb://localhost:27017/competenciasDB', function(err, db) {
    MDB = db;
    if(err) throw err;
    competidores = db.collection('competidores');
    competidores.find().toArray(function(err, items) {
         dataCompetidores = items;
        
      });
    productos_competencia = db.collection('productos');
    productos_competencia.find().toArray(function(err, items) {
         dataProductos_competencia = items;
        
      });
    info_productos = db.collection('competidores_productos');
    
    //incrementar_consumo(data,function(respuesta){console.log(respuesta);})
   // console.log("Servidor Iniciaado correctamente");
     });

//Checked
function agregar_competidor(datos,callback){
    //Chequeamos que no exista ya el competidor con ese nombre.
    
    var salida;
    async.series([function(callback){   
            competidores.findOne({"nombre_competidor":datos.nombre_competidor}, function(err, item) {
            if(err){salida = "Error";}
            else {
                if(item === null)
                {
                    competidores.insert({
                    nombre_competidor:datos.nombre_competidor,
                    direccion:datos.direccion,
                    telefono:datos.telefono,
                    password : datos.password
                });
                }
                else{
                    salida = "Error";
                }
            }
                callback();
             });
     
        }],function(err){
        callback(salida);
    });
}

//Checked
function agregar_producto(datos,callback){   
    var salida;
    async.series([function(callback){   
            productos_competencia.findOne({"nombre_competidor":datos.nombre_competidor}, function(err, item) {
            if(err){salida = "Error";}
            else {
                if(item === null)
                {
                    productos_competencia.insert({
                    nombre_producto:datos.nombre_producto,
                    caracteristicas: datos.caracteristicas,
                    graduacion: datos.graduacion,
                    ibu : datos.ibu,
                    amargor: datos.amargor,
                    dg:datos.dg
                    
                });
                }
                else{
                    salida = "Error";
                }
            }
                callback();
             });
     
        }],function(err){
        callback(salida);
    });
}


/*Recibe los datos del competidor a actualizar.
 * @param {type} datos, datos del competidor a actualizar.
 * @returns {undefined}
 */
//Checked
function modificar_competidor(datos,callback){
    var salida;
    async.series([function(callback){  
            competidores.findOne({nombre_competidor:datos.nombre_competidor_nuevo}, function(err, repetido) {
            if(err) salida = "Error";
            else{
                //no esta repetido
            if(repetido !== null){
            competidores.findOne({nombre_competidor:datos.nombre_competidor_viejo}, function(err, competidor) {
                if(err)salida = "Error";
                else{
                    if(competidor !== null){
                        console.log("competidor");
                        competidores.update(
                        { _id: competidor['_id'] },
                        {
                            $set: { 
                                nombre_competidor: datos.nombre_competidor_nuevo,
                            }
                        });
                        info_productos.find({"nombre_competidor":datos.nombre_competidor_viejo}).toArray( function(err, infoCompetidor) {
                            if(err)salida = "Error";
                            else{
                                if(infoCompetidor.length !== 0){
                                    for( var i = 0;i<infoCompetidor.length; i++ ) {
                                        modificar = infoCompetidor[i];
                                        //Falta update de elementos, ver nombre, etc.
                                        info_productos.update(
                                        { _id: modificar._id },
                                        {
                                            $set: { 
                                                nombre_competidor: datos.nombre_competidor_nuevo
                                            }
                                        });
                                    }
                                }
                            }
                        });
                    }
                     else salida = "Error";
                }
            });
        }
         callback();
    }});             
        }],function(err){
        callback(salida);
    });    
}

/*
 * Modifica el producto dado, actualizando su nombre en la tabla de productos.
 * @param {type} datos , datos para actualizar el producto determinado.
 */
//Checked
function modificar_producto(datos,callback){
      var salida;
    async.series([function(callback){  
         productos_competencia.findOne({nombre_producto:datos.nombre_producto_nuevo},function(err,repetido){
    if(err) salida = "Error";
    else{
        //no esta repetido
        if(repetido === null){
            productos_competencia.findOne({nombre_producto:datos.nombre_producto_viejo},function(err,producto){
                if(err){salida = "Error";}
                else{
                    if(producto !== null){
                        productos_competencia.update(
                        { _id: producto['_id'] },
                        {
                            $set: { 
                                nombre_producto: datos.nombre_producto_nuevo
                            }
                        });
                        info_productos.find({"nombre_producto":datos.nombre_producto_viejo}).toArray( function(err, productos) {
                        if(err)salida = "Error";
                        else{
                            //console.log("Entre");
                            if(productos.length !== 0){
                                for( var i = 0;i<productos.length; i++ ) {
                                    modificar = productos[i];
                                    info_productos.update(
                                    { _id: modificar._id },
                                    {
                                        $set: { 
                                            nombre_producto: datos.nombre_producto_nuevo
                                        }
                                    });
                                }
                            }
                            else salida = "Error";
                        }
                        });
                       
                    }
                }
            });
        }
        else{
            salida = "Error";
        }  callback();
    }});
     
        }],function(err){
        callback(salida);
    }); 
   
}


//Checked
function datos_competidores(callback){
    var salida;
    async.series([function(callback){
        competidores.find().toArray(function(err, items) 
        {
            salida = items;
            dataCompetidores = items;
            callback();
        });
     
    }],function(err){
        callback(salida);
    });
}

function productos(callback){
     var salida;
    async.series([function(callback){
        productos_competencia.find().toArray(function(err, items) 
        {
            salida = items;
            callback();
        });
     
    }],function(err){
        callback(salida);
    });
}

/**
 * 
 * @param {Array Json} datos , contienen nombre_competidor,nombre de producto y consumo a actualizar en el dia actual.
 */
//Checked, falta agregar que el producto sea correcto y el nombre del local sea correcto (ver validacion de usuario).
function incrementar_consumo(datos,callback){
    var salida;
    async.series([function(callback){   
            //console.log("RAOISJDOIASJDLKASJDLKJASD");
            console.log(datos.nombre_competidor);
            console.log(datos.nombre_producto);
            info_productos.findOne({"nombre_competidor":datos.nombre_competidor,"nombre_producto":datos.nombre_producto}, function(err, item) {
            if(err){salida = "Error";}
            else {
                console.log("Hola"+item);
                if(item !== null)
                {
                    //Obtenemos el dia del producto a actualizar
                    var today = new Date();
                    var dd = today.getDate();
                    var mm = today.getMonth()+1; //Enero es 0
                    var yy = today.getFullYear();
                    info_productos.findOne(
                        {
                            "nombre_competidor":datos.nombre_competidor,
                            "nombre_producto":datos.nombre_producto,
                            "dia":dd,
                            "mes":mm,
                            "anio":yy
                        }
                    , function(err, item) {
                    if(item !== null){
                        info_productos.update(
                        { _id: item['_id'] },
                        {$inc: {consumo:1}}
                    );}
                    else{
                        info_productos.insert(
                        {
                            "nombre_competidor":datos.nombre_competidor,
                            "nombre_producto":datos.nombre_producto,
                            "dia":dd,
                            "mes":mm,
                            "anio":yy,
                            "consumo": 1
                        });
                    }
                    });
                }
                else{
                    salida = "Error";
                }
            }
                callback();
             });
     
        }],function(err){
        callback(salida);
    });
    
}

/**
 * Elimina un competidor determinado, junto con sus productos y consumos.
 * @param {Array} datos del competidor a eliminar.
 */
//Checked
function eliminar_competidor(datos,callback){
    //Chequeamos que no exista ya el competidor con ese nombre.
    
    var salida;
    async.series([function(callback){   
            competidores.findOne({"nombre_competidor":datos.nombre_competidor}, function(err, item) {
            if(err){salida = "Error";}
            else {
                if(item !== null)
                {
                    competidores.remove({nombre_competidor:item.nombre_competidor},function(err,competidor){
                    if(err)  salida = "Error";
                    });
                    info_productos.remove({nombre_competidor:datos.nombre_competidor},function(err,competidor){
                    if(err)  salida = "Error";
                     });
                }
                else{
                    salida = "Error";
                }
            }
                callback();
             });
     
        }],function(err){
        callback(salida);
    });
    
}

/*
 * Eliminar un producto determinado, junto con sus consumos de los diferentes competidores
 * @param {Array} datos del producto a eliminar
 */
//Checked
function eliminar_producto(datos){
    var salida;
    async.series([function(callback){   
            competidores.findOne({"nombre_competidor":datos.nombre_competidor}, function(err, item) {
            if(err){salida = "Error";}
            else {
                if(item !== null)
                {
                    productos_competencia.remove({nombre_producto:datos.nombre_producto},function(err,producto){
                    if(err)  salida = "Error";
                      });
                    info_productos.remove({nombre_producto:datos.nombre_producto},function(err,producto){
                    if(err)  salida = "Error";
                     });  
                }
                else{
                    salida = "Error";
                }
            }
                callback();
             });
     
        }],function(err){
        callback(salida);
    });
      
}

/*
 * Obtiene el consumo de un determinado dia, para cada uno de los competidores de un producto determinado
 * @param {Array} datos del producto, y dia a buscar.
 */
function consumo_producto_dia(datos,callback){
    var salida;
    async.series([function(callback){
            info_productos.find({
                nombre_producto:datos.nombre_producto,
                dia:datos.dia,
                mes:datos.mes,
                anio:datos.anio}
            ).toArray(function(error,productos){
            if(error) salida = "Error";
            else
            {
                salida  = productos;
                callback();
            }
        });
     
    }],function(err){
        callback(salida);
    });   
}

/*
 * Obtiene el consumo de un determinado mes, para cada uno de los competidores de un producto determinado
 * @param {Array} datos del producto, y dia a buscar.
 */
//Checked
function consumo_producto_mes(datos,callback){
 var elementos = new Array();
    competidores.find().toArray(function(err,competidores){
        if(err) console.log("Error" + err);
        else{
            async.each(competidores,
                function(competidor, callback){
                    info_productos.aggregate([
                            {$match : {
                                        nombre_producto : datos.nombre_producto,
                                        nombre_competidor : competidor.nombre_competidor,
                                        mes:datos.mes,
                                        anio:datos.anio}
                                      },
                            {$group : { 
                                   _id : null,
                                   total : {$sum : "$consumo"}
                                  }   
                            }], function(err, result) {
                            if(err){ console.log("Error al obtener la suma");}
                            else{
                                var data_mostrar = new Array();
                                if(result.length > 0) {
                                     data_mostrar = {
                                    "nombre_competidor":competidor.nombre_competidor,
                                    "consumo": result[0].total
                                    };
                                    elementos.push(data_mostrar);
                                }
                            }
                    callback();});
                },
                function(err){
                    callback(elementos);
                }
            );
    }
    });   
    
}
/*
 * Obtiene el consumo de un determinado año, para cada uno de los competidores de un producto determinado
 * @param {Array} datos del producto, y mes a buscar.
 */
//Checked
function consumo_producto_anio(datos,callback){
 var elementos = new Array();
    competidores.find().toArray(function(err,competidores){
        if(err) console.log("Error" + err);
        else{
            async.each(competidores,
                function(competidor, callback){
                    info_productos.aggregate([
                            {$match : {
                                        nombre_producto : datos.nombre_producto,
                                        nombre_competidor : competidor.nombre_competidor,
                                        anio:datos.anio}
                                      },
                            {$group : { 
                                   _id : null,
                                   total : {$sum : "$consumo"}
                                  }   
                            }], function(err, result) {
                            if(err){ console.log("Error al obtener la suma");}
                            else{
                                var data_mostrar = new Array();
                                if(result.length > 0) {
                                     data_mostrar = {
                                    "nombre_competidor":competidor.nombre_competidor,
                                    "consumo": result[0].total
                                    };
                                        elementos.push(data_mostrar);
                                }
                            }
                    callback();});
                },
                function(err){
                    callback(elementos);
                }
            );
    }
    });   
    
}

function consumo_producto(datos,callback){
 var elementos = new Array();
    competidores.find().toArray(function(err,competidores){
        if(err) console.log("Error" + err);
        else{
            async.each(competidores,
                function(competidor, callback){
                    info_productos.aggregate([
                            {$match : {
                                        nombre_producto : datos.nombre_producto,
                                        nombre_competidor : competidor.nombre_competidor,
                                       }
                                      },
                            {$group : { 
                                   _id : null,
                                   total : {$sum : "$consumo"}
                                  }   
                            }], function(err, result) {
                            if(err){ console.log("Error al obtener la suma");}
                            else{
                                var data_mostrar = new Array();
                                if(result.length > 0) {
                                     data_mostrar = {
                                    "nombre_competidor":competidor.nombre_competidor,
                                    "consumo": result[0].total
                                    };
                                    elementos.push(data_mostrar);
                                }
                                
                                
                            }
                    callback();});
                },
                function(err){
                    callback(elementos);
                }
            );
    }
    });   
    
}
/*
 * Obtiene el consumo de un determinado dia, en sus cantidades totales
 * es decir, todos los productos.
 * @param {Array} datos , contiene el dia a obtener los datos.
 */
function consumo_total_dia(datos,callback){
    var elementos = new Array();
    competidores.find().toArray(function(err,competidores){
        if(err) console.log("Error" + err);
        else{
            async.each(competidores,
                function(competidor, callback){
                    info_productos.aggregate([
                            {$match : {
                                        nombre_competidor : competidor.nombre_competidor,
                                        dia:datos.dia,
                                        mes:datos.mes,
                                        anio:datos.anio}
                                      },
                            {$group : { 
                                   _id : null,
                                   total : {$sum : "$consumo"}
                                  }   
                            }], function(err, result) {
                            if(err){ console.log("Error obtener suma consumo total dia");}
                            else{
                                var data_mostrar = new Array();
                                if(result.length > 0) {
                                     data_mostrar = {
                                    "nombre_competidor":competidor.nombre_competidor,
                                    "consumo": result[0].total
                                    };
                                    elementos.push(data_mostrar);
                                }
                    }
                    callback();});
                },
                function(err){
                    callback(elementos);
                }
            );
    }
    });   
}

/*
 * Obtiene los datos de un determinado mes para todos los productos
 */
function consumo_total_mes(datos,callback){
    var elementos = new Array();
    competidores.find().toArray(function(err,competidores){
        if(err) console.log("Error" + err);
        else{
            async.each(competidores,
                function(competidor, callback){
                    info_productos.aggregate([
                                {$match : {
                                        nombre_competidor : competidor.nombre_competidor,
                                        mes:datos.mes,
                                        anio:datos.anio}
                                      },
                            {$group : { 
                                   _id : null,
                                   total : {$sum : "$consumo"}
                                  }   
                            }], function(err, result) {
                            if(err){ console.log("Error al obtener la suma");}
                            else{
                                var data_mostrar = new Array();
                                if(result.length > 0) {
                                     data_mostrar = {
                                    "nombre_competidor":competidor.nombre_competidor,
                                    "consumo": result[0].total
                                    };
                                    elementos.push(data_mostrar);
                                }
                            }
                    callback();});
                },
                function(err){
                    callback(elementos);
                }
            );
    }
    }); 
}

/*
 * Obtiene los datos de todos los productos en el año
 */
function consumo_total_anio(datos,callback){
    var elementos = new Array();
    competidores.find().toArray(function(err,competidores){
        if(err) console.log("Error" + err);
        else{
            async.each(competidores,
                function(competidor, callback){
                    info_productos.aggregate([
                            {$match : {
                                        nombre_competidor : competidor.nombre_competidor,
                                        anio:datos.anio
                                      }
                            },
                            {$group : { 
                                   _id : null,
                                   total : {$sum : "$consumo"}
                                  }   
                            }], function(err, result) {
                            if(err){ console.log("Error al obtener la suma");}
                            else{
                                var data_mostrar = new Array();
                                if(result.length > 0) {
                                     data_mostrar = {
                                    "nombre_competidor":competidor.nombre_competidor,
                                    "consumo": result[0].total
                                    };
                                    elementos.push(data_mostrar);
                                }
                            }
                    callback();});
                },
                function(err){ 
                  callback(elementos);
                }
            );
    }
    }); 
}

function consumo_total(callback){
    var elementos = new Array();
    competidores.find().toArray(function(err,competidores){
        if(err) console.log("Error" + err);
        else{
            async.each(competidores,
                function(competidor, callback){
                    info_productos.aggregate([
                            {$match : {
                                        nombre_competidor : competidor.nombre_competidor,
                                      }
                            },
                            {$group : { 
                                   _id : null,
                                   total : {$sum : "$consumo"}
                                  }   
                            }], function(err, result) {
                            if(err){ console.log("Error al obtener la suma");}
                            else{
                                var data_mostrar = new Array();
                                if(result.length > 0) {
                                     data_mostrar = {
                                    "nombre_competidor":competidor.nombre_competidor,
                                    "consumo": result[0].total
                                    };
                                    elementos.push(data_mostrar);
                                }
                            }
                    callback();});
                },
                function(err){ 
                  callback(elementos);
                }
            );
    }
    }); 
}

function checkLogin(datos,callback){
    var salida;
    async.series([function(callback){   
            competidores.findOne({"nombre_competidor":datos.nombre_competidor,"password":datos.password}, function(err, item) {
            if(err){salida = "error";}
            else {
                if(item === null)
                {
                  salida = "nolog";
                }
                else
                {
                    salida = "log";
                }
            }
                callback();
             });
     
        }],function(err){
        callback(salida);
    });
}

exports.checkLogin = checkLogin;
exports.datos_competidores = datos_competidores;
exports.productos = productos;
exports.incrementar_consumo = incrementar_consumo;

exports.agregar_competidor = agregar_competidor;
exports.agregar_producto = agregar_producto;

exports.modificar_competidor = modificar_competidor;
exports.modificar_producto = modificar_producto;

exports.eliminar_competidor = eliminar_competidor;
exports.eliminar_producto = eliminar_producto;

exports.consumo_total_anio = consumo_total_anio;
exports.consumo_total_mes = consumo_total_mes;
exports.consumo_total_dia = consumo_total_dia;
exports.consumo_total = consumo_total;

exports.consumo_producto_anio = consumo_producto_anio;
exports.consumo_producto_mes = consumo_producto_mes;
exports.consumo_producto_dia = consumo_producto_dia;
exports.consumo_producto = consumo_producto;

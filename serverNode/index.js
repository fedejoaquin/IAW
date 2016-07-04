var server = require("./server");
var router = require("./router");
var requestHandlers = require("./requestHandlers");

var handle = {};
handle["/datos_competidores"] = requestHandlers.datos_competidores;
handle["/consumo_total"] = requestHandlers.consumo_total;
handle["/consumo_producto"] = requestHandlers.consumo_producto;
handle["/productos"] = requestHandlers.productos;
handle["/incrementar_consumo"] = requestHandlers.incrementar_consumo;

handle["/agregar_competidor"] = requestHandlers.agregar_competidor;
handle["/agregar_producto"] = requestHandlers.agregar_producto;

handle["/agregar_producto"] = requestHandlers.agregar_producto;
handle["/modificar_competidor"] = requestHandlers.modificar_competidor;

handle["/eliminar_competidor"] = requestHandlers.eliminar_competidor;
handle["/eliminar_producto"] = requestHandlers.eliminar_producto;

server.iniciar(router.route, handle);
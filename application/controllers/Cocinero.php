<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cocinero extends CI_Controller {
    
    /*
     * Devuelve los pedidos activos que estan presentes en el sistema.
     */
    public function pedidos_activos(){
        $resultado= $this->MPedidos->pedidos_y_promos();
        echo json_encode($resultado); 
    }
    
    
    /*
     * Procesa un determinado producto o promocion.
     */
    public function procesar_producto(){
        $pedido_id = $this->input->post('pedido_id');
        $tabla = $this->input->post('tabla');
        if(strcmp($tabla,"pedidos") === 0){
            $this->MPedidos->procesarPedido($pedido_id);
        }
        else{
            $this->MPedidos->procesarPromo($pedido_id);
        }
    }
    
    /*
     * Da por finalizado un producto o promocion.
     */
     public function terminar_producto(){
        $tupla = $this->input->post('tupla');
        $tabla = $this->input->post('tabla');
        if(strcmp($tabla,"pedidos") === 0){
            $this->MPedidos->terminarPedido($tupla);
        }
        else{
            $this->MPedidos->terminarPromo($tupla);
        }
    }
}
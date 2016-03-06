<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_1 extends CI_Controller {
    
    public function altaPedido(){
        $resultado = array();
        if($this->chequear_vinculado()){
            //Array(tupla_1, tupla_2, ..., tupla_n)
            //Tupla(Id, Producto, Precio, Id_lp, Comentarios)
            $productos = $this->input->post('productosPedidos');
            //Tupla(Id, Producto, Precio, Comentarios)
            $promociones = $this->input->post('promocionesPedidas');
            
            $id_pedidor = $this->session->userdata('cid');
            $id_mesa = $this->session->userdata('mesa_asignada')['id'];
            
            if (!empty($productos)){ 
                foreach ($productos as $row){
                    $this->MPedidos->solicitarProducto($id_pedidor,$id_mesa, $row['id'], $row['id_lp'], $row['comentarios']);
                }
            }
            
            if(!empty($promociones)){
                foreach ($promociones as $row){
                    $this->MPedidos->solicitarPromocion($id_pedidor,$id_mesa, $row['id'], $row['comentarios']);
                }
            }            
            
            if (empty($productos) && empty($promociones)){
                $resultado['error'] = 'Con los datos subministrados, no se puede realizar la operación.';
                $resultado['data'] = array();
                echo json_encode($resultado);
            }else{
                $this->estadoMesa();
            }
             
        }else{
            $resultado['error'] = 'El usuario actual no se encuentra vinculado a webresto.';
            $resultado['data'] = array();
            echo json_encode($resultado);
        }
    }

    /**
     * Dada una petición de un cliente, si este está logueado y vinculado a una mesa, retorna la descripción de los
     * pedidos y promociones confirmadas, así como el estado de procesamiento de cada uno de ellos.
     * @return Productos --> Array(Id_pedidor,Nombre_pedidor, Nombre_producto, Precio, Fecha_e, Fecha_p, Fecha_s)
     * @return Promociones --> Array(Id_pedidor,Nombre_pedidor, Nombre_promocion, Precio, Fecha_e, Fecha_p, Fecha_s)
     * 
     */
    public function estadoMesa(){
        $resultado = array();
        if($this->chequear_vinculado()){
            $resultado['data'] = array();
            $resultado['data']['productos'] = $this->MPedidos->get_productos_procesados($this->session->userdata('mesa_asignada')['id']);
            $resultado['data']['promociones'] = $this->MPedidos->get_promociones_procesadas($this->session->userdata('mesa_asignada')['id']);        
            echo json_encode($resultado);
        }else{
            $resultado['error'] = 'El usuario actual no se encuentra vinculado a webresto.';
            $resultado['data'] = array();
            echo json_encode($resultado);
        }
    }
    
    /**
    * Chequea si existe datos de vinculación de un cliente logueado. 
    * - Responde verdadero en caso de estar vinculado.
    * - Responde falso en caso de no estar vinculado.
    */
    private function chequear_vinculado(){
        $resultado = $this->MMesasPedidores->get_mesa_pedidor($this->session->userdata('cid'));
        $this->session->set_userdata('mesa_asignada',$resultado);
        if (count($resultado)>0){
            return true;
        }else{
            return false;
        }
    } 
    
    public function vincularCliente(){
        $resultado = array();
        $codigo = $this->input->post('codigoCliente');
        $id_mesa = $this->input->post('id_mesa');
        $valido = $this->MMesasPedidores->vincular_cliente($codigo,$id_mesa);
        switch ($valido) {
            case 1: $resultado['error']="La mesa a la que intenta vincular esta cerrada.";
                break;
            case 2: $resultado['error']="El codigo: ".$codigo." no esta vinculado al sistema.";
                break;
        }
        echo json_encode($resultado);
    }

    /*
     * Devuelve las notificaciones para un determinado mozo.
     */
    public function pedir_notificaciones(){
        $id_mozo = $this->input->get('id_mozo');
        /* el cocinero cuando coloca el pedido en salida, genera la notificacion, lo simulamos con la BD*/
        $resultado['notificaciones'] = $this->MPedidos->getNotificaciones($id_mozo);
        echo json_encode($resultado); 
    }
    
     public function eliminar_notificacion(){
         $resultado = array();
        $not_id = $this->input->post('not_id');
        
        $error = $this->MPedidos->eliminarNotificacion($not_id);
        if($error){
            $resultado['error'] = "Se produjo un error en la eliminación de la notificación";
        }
        echo json_encode($resultado); 
    }
    
    public function pedidos_activos(){
        $resultado= $this->MPedidos->pedidos_y_promos();
        echo json_encode($resultado); 
    }
    /*
     * Ponemos 2 funciones, para evitar mas controles, asi como las 4 en MPedidos. es mas codigo,
     * pero es un poco mas rapido, evaluar si conviene..ya que si bien es ajax, es bajo la mano del cocinero.
     *  */
    
    
    //FALTA LA IMPLEMENTACION DE LAS FUNCIONES EN MPEDIDOS!!
    public function procesar_producto(){
        $pedido_id = $this->input->post('pedido_id');
        $tabla = $this->input->post('tabla');
        if($tabla == "pedidos"){
            $this->MPedidos->procesarProd($pedido_id);
        }
        else{
            $this->MPedidos->procesarPromo($pedido_id);
        }
    }
    
     public function terminar_producto(){
        $pedido_id = $this->input->post('pedido_id');
        $tabla = $this->input->post('tabla');
        if($tabla == "pedidos"){
            $this->MPedidos->terminarProd($pedido_id);
        }
        else{
            $this->MPedidos->terminarPromo($pedido_id);
        }
    }
}
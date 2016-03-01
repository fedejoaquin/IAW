<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
     
    public function altaPedido(){
        echo hash('sha256', 'fede').'<br>';
        echo hash('sha256', 'leo').'<br>';
        echo hash('sha256', 'user').'<br>';
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
}
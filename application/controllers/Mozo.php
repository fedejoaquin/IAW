<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mozo extends CI_Controller {

	public function index()
	{
           
            $data['funcion'] = 'index';
            $data['id_empleado'] = $this->session->userdata('eid');
            $data['mesas'] = $this->MMesasPedidores->get_mesas_empleado($data['id_empleado']);
            $this->load->view('vMozo', $data);
	}
        
        public function adminMesa(){
            $data['funcion'] = 'adminMesa';
            $data['id_empleado'] = $this->session->userdata('eid');
            $data['id_mesa'] = $this->input->post('id_mesa');
            $data['num_mesa'] = $this->MPedidos->get_num_mesa($data['id_mesa']);
            $mesa_asignada = $data['id_mesa'];
            $menu_actual = $this->MCartas->get_menu_actual();
            $promo_actual = $this->MCartas->get_promociones_actual();
            $pedidos_procesados = $this->MPedidos->get_productos_procesados($mesa_asignada);
            $promociones_procesadas = $this->MPedidos->get_promociones_procesadas($mesa_asignada);

            $data['id_carta'] = $menu_actual['id_carta'];
            $data['nombre_carta'] = $menu_actual['nombre_carta'];
            $data['info_carta'] = $menu_actual['info_carta'];
            $data['info_promociones'] = $promo_actual;
            $data['pedidos_procesados'] = $pedidos_procesados;
            $data['promociones_procesadas'] = $promociones_procesadas;
            $data['funcion'] = 'adminMesa';
            $this->load->view('vMozo', $data);
        }
        
        public function altaPedidoMozo(){
        $resultado = array();
        if($this->chequear_vinculado()){
            //Array(tupla_1, tupla_2, ..., tupla_n)
            //Tupla(Id, Producto, Precio, Id_lp, Comentarios)
            $productos = $this->input->post('productosPedidos');
            //Tupla(Id, Producto, Precio, Comentarios)
            $promociones = $this->input->post('promocionesPedidas');
            
            $id_pedidor = $this->session->userdata('eid');
            $id_mesa = $this->input->post('id_mesa');
            
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
                $resultado['data'] = array();
                $resultado['data']['productos'] = $this->MPedidos->get_productos_procesados($id_mesa);
                $resultado['data']['promociones'] = $this->MPedidos->get_promociones_procesadas($id_mesa);        
                echo json_encode($resultado);
            }
             
        }else{
            $resultado['error'] = 'El usuario actual no se encuentra vinculado a webresto.';
            $resultado['data'] = array();
            echo json_encode($resultado);
        }
    }

    /**
     * Dada una petición de un mozo, si este está logueado y vinculado a una mesa, retorna la descripción de los
     * pedidos y promociones confirmadas, así como el estado de procesamiento de cada uno de ellos.
     * @return Productos --> Array(Id_pedidor,Nombre_pedidor, Nombre_producto, Precio, Fecha_e, Fecha_p, Fecha_s)
     * @return Promociones --> Array(Id_pedidor,Nombre_pedidor, Nombre_promocion, Precio, Fecha_e, Fecha_p, Fecha_s)
     * 
     */
    public function estadoMesa(){
        $id_mesa = $this->input->post('id_mesa');
        $resultado = array();
        if($this->chequear_vinculado()){
            $resultado['data'] = array();
            $resultado['data']['productos'] = $this->MPedidos->get_productos_procesados($id_mesa);
            $resultado['data']['promociones'] = $this->MPedidos->get_promociones_procesadas($id_mesa);        
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
        $resultado = $this->MMesasPedidores->get_mesa_pedidor($this->session->userdata('eid'));
        if (count($resultado)>0){
            return true;
        }else{
            return false;
        }
    } 
    
    /*
     * Vincula un dado cliente, obteniendo su codigo y id de mesa.
     * Si el cliente esta vinculado al sistema, se lo asocia a la mesa.
     * Si no esta vinculado, entonces envia un mensaje de erro.
     */
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
    
    /*
     * Confirma que una dada notificacion ha sido vista por el mozo.
     */
     public function eliminar_notificacion(){
         $resultado = array();
        $not_id = $this->input->post('not_id');
        
        $error = $this->MPedidos->eliminarNotificacion($not_id);
        if($error){
            $resultado['error'] = "Se produjo un error en la eliminación de la notificación";
        }
        echo json_encode($resultado); 
    }
    
    
}

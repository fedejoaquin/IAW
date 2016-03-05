<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
    /**
     * Computa el alta de pedidos tanto de productos como de promociones, parametrizados por un cliente.
     * Valida que el cliente esté vinculado, y registra el pedido siempre y cuando el producto/promoción
     * se encuentre dentro del menú actualmente habilitado; descarta aquellos productos/promociones no válidos.
     * @return Array con el estado de la mesa, en caso de cómputo exitoso.
     * @return Array con el error detectado, en caso de cómputo incorrecto.
     */ 
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

            $productos_precios = $this->MCartas->get_productos_precio_menu_actual();
            $promociones_precios = $this->MCartas->get_promociones_precio_menu_actual();
        
            if (!empty($productos)){ 
                foreach ($productos as $row){
                    $componente = array('id_producto' => $row['id'], 'precio' => $row['precio'] );
                    if (in_array($componente, $productos_precios)){
                        $this->MPedidos->solicitarProducto($id_pedidor,$id_mesa, $row['id'], $row['id_lp'], $row['comentarios']);
                    }
                }
            }
            
            if(!empty($promociones)){
                foreach ($promociones as $row){
                    $componente = array('id' => $row['id'], 'precio' => $row['precio'] );
                    if (in_array($componente, $promociones_precios)){
                        $this->MPedidos->solicitarPromocion($id_pedidor,$id_mesa, $row['id'], $row['comentarios']);
                    }
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
     * Dada una petición de un cliente, si éste está logueado y vinculado a una mesa, retorna la descripción de los
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
    
    public function menu_cambiar_nombre(){
        $id = $this->input->post('id');
        $nombre = $this->input->post('nombre');
        
        if ($this->MCartas->editar_nombre($id,$nombre)){
            $resultado['data'] = array();
            echo json_encode($resultado);
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'El menú no pudo ser editado correctamente.';
            echo json_encode($resultado);
        }
    }
    
    public function menu_cambiar_horas(){
        $id = $this->input->post('id');
        $id_horas = $this->input->post('id_horas');
        
        if ($this->MCartas->editar_horas($id,$id_horas)){
            $resultado['data'] = array();
            echo json_encode($resultado);
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'El menú no pudo ser editado correctamente.';
            echo json_encode($resultado);
        }
    }
    
    public function menu_cambiar_dias(){
        $id = $this->input->post('id');
        $id_dias = $this->input->post('id_dias');
        
        if ($this->MCartas->editar_dias($id,$id_dias)){
            $resultado['data'] = array();
            echo json_encode($resultado);
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'El menú no pudo ser editado correctamente.';
            echo json_encode($resultado);
        }
    }
    
    public function menu_cambiar_info_lista(){
        $id_prod_info_carta = $this->input->post('id');
        $id_seccion = $this->input->post('id_seccion');
        $id_lista_precio = $this->input->post('id_lista_precio');
        
        if ($this->MInfoCartas->editar_producto($id_prod_info_carta, $id_seccion, $id_lista_precio)){
            $resultado['data'] = array();
            echo json_encode($resultado);
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'El producto no pudo ser editado correctamente.';
            echo json_encode($resultado);
        }           
    }
    
    public function menu_eliminar_producto(){
        $id_p_ic= $this->input->post('id_producto_infocarta');
        if ($this->MInfoCartas->eliminar_producto($id_p_ic)){
            $resultado['data'] = array();
            echo json_encode($resultado);
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'El producto no pudo ser eliminado correctamente.';
            echo json_encode($resultado);
        }
    }
    
    public function menu_info_producto(){
        $id = $this->input->post('id');
        $secciones = $this->MSecciones->get_secciones();
        $listaPrecios = $this->MListaPrecios->get_precios_para_producto($id);
       
        if (count($listaPrecios)>0){
            $resultado['data'] = array();
            $resultado['data']['secciones'] = $secciones;
            $resultado['data']['listaPrecios'] = $listaPrecios;
            echo json_encode($resultado);
        }else{
            $resultado['error'] = 'El producto indicado no existe o no puede ser editado.';
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
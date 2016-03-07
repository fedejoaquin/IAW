<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {
    
    /**
     * Index de Clientes. Chequea que esté logueado y/o vinculado.
     * - En caso de estar logueado, muetra el index.
     * - En caso de estar logueado y vinculado, muestra el index.
     * - En caso no estar logueado, redirige al home de webresto.
     */
    public function index(){
        if($this->chequear_login_redirect()){
            $this->chequear_vinculado();
            $data['funcion'] = 'index';
            $this->load->view('vClientes',$data);
        }
    }
    
    /**
     * Info de Clientes. Chequea que esté logueado y/o vinculado.
     * - En caso de estar logueado y/o vinculado, muetra la info actual.
     * - En caso no estar logueado, redirige al home de webresto.
     */
    public function info(){
        if($this->chequear_login_redirect()){
            $this->chequear_vinculado();
            $data['funcion'] = 'info';
            $this->load->view('vClientes',$data);
        }
    }
    
    /**
     * Lista el menú actual y los pedidos, si es que el cliente está logueado y vinculado.
     * $data['info_carta' ] = Array (Secciones,nombre_producto,Precio, Id_lista_precio)
     * $data['info_promociones'] = Array(NombrePromo,Productos,Precio)
     * $data['pedidos_procesados'] = Array(Id_pedidor,Nombre_pedidor, Nombre_producto, Precio, Fecha_e, Fecha_p, Fecha_s)
     * $data['promociones_procesadas'] = Array(Id_pedidor,Nombre_pedidor, Nombre_promocion, Precio, Fecha_e, Fecha_p, Fecha_s)
     */
    public function pedidos(){
        if($this->chequear_login_redirect()){
            if($this->chequear_vinculado_redirect()){
                $menu_actual = $this->MCartas->get_menu_actual();
                $promo_actual = $this->MCartas->get_promociones_actual();
                $pedidos_procesados = $this->MPedidos->get_productos_procesados($this->session->userdata('mesa_asignada')['id']);
                $promociones_procesadas = $this->MPedidos->get_promociones_procesadas($this->session->userdata('mesa_asignada')['id']);
                
                $data['id_carta'] = $menu_actual['id_carta'];
                $data['nombre_carta'] = $menu_actual['nombre_carta'];
                $data['info_carta'] = $menu_actual['info_carta'];
                $data['info_promociones'] = $promo_actual;
                $data['pedidos_procesados'] = $pedidos_procesados;
                $data['promociones_procesadas'] = $promociones_procesadas;
                $data['funcion'] = 'pedidos';
                $this->load->view('vClientes', $data);
            }
        }
    }
    
    /**
     * Computa el alta de pedidos tanto de productos como de promociones, parametrizados por un cliente.
     * Valida que el cliente esté vinculado, y registra el pedido siempre y cuando el producto/promoción
     * se encuentre dentro del menú actualmente habilitado; descarta aquellos productos/promociones no válidos.
     * @return Array con el estado de la mesa, en caso de cómputo exitoso.
     * @return Array con el error detectado, en caso de cómputo incorrecto.
     */ 
    public function alta_pedido(){
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
     */
    public function estado_mesa(){
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
    * Chequea si existe datos de cliente logueado. 
    * - Si no está logueado, redirige al home del sitio.
    * - Si está logueado, elimina datos de sessión y redirige a webresto/logout.
    */
    public function logout(){
        if($this->chequear_login_redirect()){
            redirect(site_url().'webresto/logout');
        }
    }
            
    /**
    * Chequea si existe datos de cliente logueado. 
    * - Si la session indica que ya se logueó, entonces retorna verdadero.
    * - Si la session indica que no se logueó, entonces redirige al home de webresto y retorna false.
    */
   private function chequear_login_redirect(){
        if ($this->session->userdata('cid') === NULL){
            $data['funcion'] = 'index';
            $this->load->view('vWebresto',$data);
            return false;
        }else{
            return true;
        }
    }
    
    /**
    * Chequea si existe datos de vinculación de un cliente logueado. 
    * - Si la session indica que ya se vinculó, entonces retorna verdadero.
    * - Si la session indica que no se logueó, entonces redirige al home del sitio t retorna false.
    */
    private function chequear_vinculado_redirect(){
        if ($this->chequear_vinculado()){
            return true;
        }else{
            $data['funcion'] = 'index';
            $this->load->view('vClientes',$data);
            return false;
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